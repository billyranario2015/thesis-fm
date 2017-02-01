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

});