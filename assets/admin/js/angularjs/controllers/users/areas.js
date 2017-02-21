fm.controller( "AreasController" , function( $scope, $http, $timeout, settings, $timeout, $rootScope ) {
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

	$scope.parameter_id = 0;
	$scope.loader_search = false;
	$scope.uploadFile = function(files,parameter_id) {
		$scope.loader_search = true;
		var related_files = [];
		$scope.related_files = [];
	    $scope.files = files;
	    $scope.related_file_count = 0;

	    var current_file = {
	    	id       : 0,
	    	filename : ''
	    };
	    var search_request = angular.forEach( files, function (value,key) {
	    	var file = value.name;
			var name = file.substring(file.lastIndexOf('/')+1, file.lastIndexOf('.'));
	    	$http.post( settings.base_url + 'api/search_for_file/', { data : name, parameter_id : parameter_id } )
    		.success( function (response) {
    			$scope.$applyAsync(function () {
    				angular.forEach( response.response, function (value2,key2) {
    					related_files.push(value2);
    				} );
    			} );
    		} );
	    } );

	    setTimeout(function() {
			$scope.related_file_count = related_files.length;
	    	$scope.related_files = related_files;
	    	$scope.loader_search = false;
	    	$scope.$apply();
	    	console.log( $scope.related_files );
	    }, 1000);

	};

	// CLEAR SEARCHED
	$scope.clearSearch = function clearSearch() {
		$scope.related_files = [];
		angular.element("input[name='file_data']").val(null);
	}
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
				$scope.getParameterFiles(parameter_id);
			});

		} else {
			console.log( 'empty' );
		}
		angular.element("input[name='file_data']").val(null);
	}

	$scope.parameter_files = {};
	$scope.getParameterFiles = function getParameterFiles(parameter_id) {
		$http.get(  settings.base_url + 'api/get_uploads/' + parameter_id )
		.success(function(response) {
			// console.log(response);
			$scope.parameter_files = response.response;
		});
	}


	$scope.edit_options = {};
	$scope.editFile = function editFile(file) {
		console.log( file );
		$scope.edit_options = file;
		setTimeout(function() {
			$( '#modal-edit-file' ).modal('show');
		}, 500);
	}

	$scope.is_success = false;
	$scope.updateFile = function updateFile() {
		$http.post( settings.base_url + 'api/file/update', $scope.edit_options )
		.success( function (response) {
			$scope.is_success = true;
			setTimeout(function() {
				// $( '#modal-edit-file' ).modal('hide');
				$scope.is_success = false;
				$scope.getParameterFiles($scope.edit_options.parameter_id);
			}, 1300);
		} );
	}

	$scope.close_modal_file = function close_modal_file(parameter_id) {
		$( '#modal-edit-file' ).modal('hide');
		$scope.edit_options = {};
		$scope.getParameterFiles(parameter_id);
		console.log(parameter_id)
	}

	$scope.deleteFile = function deleteFile(file) {
		if (confirm('Are you sure you want to remove this file?')) {
			$http.post( settings.base_url + 'api/file/delete', file )
			.success( function (response) {
				$( '.row-file-' + file.id ).fadeOut();
			} );
		}
	}

	$scope.copyFile = function copyFile(file,parameter_id) {
		if (confirm( 'Do you want to copy this file to your current Area?' )) {
			$http.post( settings.base_url + 'api/file/copy/' + parameter_id, file )
			.success( function (response) {
				// alert('File successfully copied!');/
				console.log(response);
				setTimeout(function() {
					$scope.getParameterFiles(parameter_id);
				}, 1000);
			} );
		}
	}

	$scope.submitToChairman = function submitToChairman(area_id) {
		var userdata = settings.userdata();
		if ( confirm( 'Are you sure you want to send your submission?' ) ) {
			userdata.success( function (response) {
				response.userdata.area_id = area_id;
				console.log(response);
				$http.post( settings.base_url + 'api/submission/area', response )
				.success(function (data_response) {
					console.log(data_response);
					if ( data_response.submission > 0 ) {
						alert( 'Successfull submitted. ' );
						location.reload();
					} else {
						alert( 'Error on submission. Please try again later' );
					}
				})
			} );			
		}
	}

	// ADD SUBMISSION TO IN-HOUSE EVALUATOR
	$scope.submitToEvaluator = function submitToEvaluator() {
		var userdata = settings.userdata();
		if ( confirm( 'Are you sure you want to send entry to In-House Evaluator?' ) ) {
			userdata.success( function (response) {
				$http.post( settings.base_url + 'api/submission/evaluate', response )
				.success(function (data_response) {
					console.log(data_response);
					if ( data_response.submission > 0 ) {
						alert( 'Successfull submitted. ' );
						location.reload();
					} else {
						alert( 'Error on submission. Please try again later' );
					}
				})
			} );			
		}
	}

	// ADD COMMENT 
	$scope.commentFields = {};
	$scope.addComment = function addComment(comment_type,area_id) {
		$scope.commentFields.target_id = area_id;
		// $scope.commentFields.area_id   = area_id;
		$scope.commentFields.comment_type = comment_type;
		console.log( $scope.commentFields );
		$http.post( settings.base_url + 'api/comment/create', $scope.commentFields )
		.success( function (response) {
			console.log(response);
			$scope.getComments(area_id);
			$scope.commentFields.comment = null;
		} )
	}

	$scope.comments = {};
	$scope.getComments = function getComments(area_id) {
		$http.get( settings.base_url + 'api/comments/area/' + area_id )
		.success( function (response) {
			console.log( response );
			$scope.comments = response.comments;
		} );
	}

	$scope.searchQuery = '';
	$scope.searchRelatedFiles = function searchRelatedFiles() {
		$scope.loader_search = true;
		var related_files = [];
		$scope.related_files = [];
	    $scope.related_file_count = 0;

		$http.post( settings.base_url + 'api/search_for_file/', { data : $scope.searchQuery } )
		.success( function (response) {
			console.log( response.response )
			$scope.related_files = response.response;
	    	$scope.loader_search = false;
	    	$scope.related_file_count = response.response.length;
		} );
	}

	$scope.submission_status = 0;
	$scope.updateEntryStatus = function updateEntryStatus(submission_id , user_id) {
		console.log( $scope.submission_status, submission_id );
		$http.post( settings.base_url + 'api/submission/status_update/', { submission_status : $scope.submission_status, id : submission_id , user_id : user_id } )
		.success( function (response) {
			console.log( response.response );
			location.reload();
		} );

	}
});