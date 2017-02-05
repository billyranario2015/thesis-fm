fm.controller( "AreasController" , function( $scope, $http, $timeout, settings, $timeout ) {
	$scope.deleteArea = function deleteArea(id) {
		if ( confirm( 'Are you sure you want to delete this area?' ) ) {
			$http.post( settings.base_url + 'api/area/delete' , { id:id } )
			.success( function (response) {
				console.log(response);
				$( '#area-' + id ).fadeOut();
			} );
		}
	}

	$scope.parameters = {};
	$scope.getParameters = function getParameters(area_id) {
		$http.get( settings.base_url + 'api/get/parameters/'+area_id )
		.success(function (response) {
			// console.log(response.response);
			$scope.parameters = response.response;
		})
	}

	$scope.cleanParameters = {};
	$scope.getCleanParameters = function getCleanParameters(area_id) {
		$http.get( settings.base_url + 'api/get/clean_parameters/'+area_id )
		.success(function (response) {
			console.log(response.response);
			$scope.cleanParameters = response.response;
		})
	}

	$scope.parameter = {};
	$scope.createParameter = function createParameter(area_id) {
		if ( !$scope.parameter.parent_id )
			$scope.parameter.parent_id = 0;

		$scope.parameter.area_id  = area_id;
		$http.post( settings.base_url + 'api/create/parameter', $scope.parameter )
		.success( function(response) {
			$scope.getParameters( area_id );
			$scope.getCleanParameters(area_id);
			console.log( response );
			$scope.parameter = {};
		} );
	}

	$scope.parameter_edit = {};
	$scope.edit_parameter = function edit_parameter(data) {
		$( '#modal-edit-parameter' ).modal('show');
		console.log(data)
		$scope.parameter_edit.id 				= data.id;
		$scope.parameter_edit.parent_id 		= data.parent_id;
		$scope.parameter_edit.area_id 			= data.area_id;
		$scope.parameter_edit.parameter_name 	= data.clean_parameter;
	}


	$scope.updateParameter = function updateParameter() {
		$http.post( settings.base_url + 'api/update/parameter', $scope.parameter_edit )
		.success( function(response) {
			$scope.getParameters( $scope.parameter_edit.area_id );
			$scope.getCleanParameters($scope.parameter_edit.area_id);
			$( '#modal-edit-parameter' ).modal('hide');
		} );
	}

	$scope.delete_parameter = function delete_parameter(data) {
		if ( confirm( 'Are you sure you want to delete this parameter?' ) ) {
			$http.post( settings.base_url + 'api/delete/parameter', data )
			.success( function(response) {
				$( '.item-paramater-' + data.id ).fadeOut('slow');
				$( '.item-paramater-parent-' + data.id ).fadeOut('slow');
				setTimeout(function() {
					$scope.getParameters( data.area_id );
					$scope.getCleanParameters(data.area_id);
				}, 1000);
				console.log( response );
			} );
		}
	}

	$scope.files = [];

	$scope.related_files = {};
	$scope.parameter_id = 0;
	$scope.uploadFile = function(files,parameter_id) {
	    $scope.files = files;
	    // Check for similar file uploads
	    if ( files.length > 0 ) {
	    	for( x in files ) {
	    		if ( files[x].name ) {
		    		var file = files[x].name;
					var name = file.substring(file.lastIndexOf('/')+1, file.lastIndexOf('.'));
					console.log(name);
		    		$http.post( settings.base_url + 'api/search_for_file/', { data : name, parameter_id : parameter_id } )
		    		.success( function (response) {
		    			console.log( response );
		    		} )	
	    		}

		    }
	    }
	    // console.log( parameter_id );
	};

	$scope.submitFileUpload = function submitFileUpload(parameter_id) {
		var fd = new FormData();

		if ( $scope.files != null ) {

			for( var x in $scope.files ) {
				if ( $scope.files[x].name  ) {
					$scope.files[x].parameter_id = parameter_id;
					fd.append("file[]", $scope.files[x], $scope.files[x].name);
				}
			}

			$http.post( settings.base_url + 'user/file_upload/' + parameter_id, fd, {
				headers: {'Content-Type': undefined },
				transformRequest: angular.identity
		  	}).success( function(data) {
				console.log( data );
			});

		} else {
			console.log( 'empty' );
		}
	}

});