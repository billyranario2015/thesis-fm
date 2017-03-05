fm.controller( "AreasController" , function( $scope, $http, $timeout, settings, $timeout, $rootScope ) {
	$scope.pre_upload_files = {};

	$scope.deleteArea = function deleteArea(id) {
		if ( confirm( 'Are you sure you want to delete this area?' ) ) {
			$http.post( settings.base_url + 'api/area/delete' , { id:id } )
			.success( function (response) {
				console.log(response);
				$( '#area-' + id ).fadeOut();
			} );
		}
	}
	$scope.trashArea = function trashArea(id) {
		if ( confirm( 'Are you sure you want to trash this area?' ) ) {
			$http.post( settings.base_url + 'api/area/trash' , { id:id } )
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
	$scope.trashedCleanParameters = {};
	$scope.totalParentParameters = 0;
	$scope.completedParentParameters = 0;
	$scope.getCleanParameters = function getCleanParameters(area_id) {
		$http.get( settings.base_url + 'api/get/clean_parameters/'+area_id )
		.success(function (response) {
			console.log(response.response);
			$scope.cleanParameters = response.response;

			var count_parents = 0;
			var count_completed_parents = 0;
			for( x in response.response ) {
				if ( response.response[x].parent_id == 0 ) {
					count_parents = count_parents + 1;
					if ( response.response[x].parameter_status == 'complete' ) {
						count_completed_parents = count_completed_parents + 1;
					}
				}
			}
			$scope.totalParentParameters = count_parents;
			$scope.completedParentParameters = count_completed_parents;
		})
	}

	$scope.getTrashedCleanParameters = function getTrashedCleanParameters(area_id) {
		$http.get( settings.base_url + 'api/get/trashed_clean_parameters/'+area_id )
		.success(function (response) {
			console.log(response);
			$scope.trashedCleanParameters = response.response;

			var count_parents = 0;
			var count_completed_parents = 0;
			for( x in response.response ) {
				if ( response.response[x].parent_id == 0 ) {
					count_parents = count_parents + 1;
					if ( response.response[x].parameter_status == 'complete' ) {
						count_completed_parents = count_completed_parents + 1;
					}
				}
			}
			$scope.totalParentParameters = count_parents;
			$scope.completedParentParameters = count_completed_parents;
		})
	}

	$scope.parameter = {};
	$scope.createParameter = function createParameter(level_id, area_id) {
		if ( !$scope.parameter.parent_id )
			$scope.parameter.parent_id = 0;

		$scope.parameter.area_id   = area_id;
		$scope.parameter.level_id  = level_id;
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
		$scope.parameter_edit.total_files 		= parseInt(data.total_files);
		$scope.parameter_edit.area_id 			= data.area_id;
		$scope.parameter_edit.parameter_name 	= data.clean_parameter;
		$scope.parameter_edit.tags 				= data.tags;
	}


	$scope.updateParameter = function updateParameter() {
		$http.post( settings.base_url + 'api/update/parameter', $scope.parameter_edit )
		.success( function(response) {
			console.log(response);
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

	$scope.trash_parameter = function trash_parameter(data) {
		if ( confirm( 'Are you sure you want to trash this parameter?' ) ) {
			$http.post( settings.base_url + 'api/trash/parameter', data )
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
	$scope.uploadFile = function(files,parameter_id,area_id) {
		$scope.loader_search = true;
		var related_files = [];
		var related_parameters = [];

		$scope.related_files = [];
		$scope.related_parameters = [];

	    $scope.files = files;
	    $scope.related_file_count = 0;

	    var current_file = {
	    	id       : 0,
	    	filename : ''
	    };
	    var search_request = angular.forEach( files, function (value,key) {
	    	var file = value.name;
			var name = file.substring(file.lastIndexOf('/')+1, file.lastIndexOf('.'));

			// Search for related files
	    	$http.post( settings.base_url + 'api/search_for_file/', { data : name, parameter_id : parameter_id, area_id : area_id } )
    		.success( function (response) {
    			$scope.$applyAsync(function () {
    				angular.forEach( response.response, function (value2,key2) {
    					related_files.push(value2);
    				} );
    			} );
    		} );

    		// Search for related parameters
	    	$http.post( settings.base_url + 'api/search_for_parameters/', { data : name, parameter_id : parameter_id, area_id : area_id } )
    		.success( function (response) {
    			console.log( response );

    			$scope.$applyAsync(function () {
    				angular.forEach( response.response, function (value2,key2) {
    					related_parameters.push(value2);
    				} );
    			} );
    		} );

	    } );

	    setTimeout(function() {
			$scope.related_file_count = related_files.length;
	    	
	    	$scope.related_files = related_files;
	    	$scope.related_parameters = related_parameters;

	    	$scope.loader_search = false;
	    	$scope.$apply();
	    	console.log( $scope.related_files );
	    	console.log( $scope.related_parameters );
	    }, 1500);

	};

	// Upload Selected FILE to specific PARAMETER
	$scope.uploadFileToParameter = function uploadFileToParameter(parameter) {
		if ( confirm( 'Are you sure you want to upload file(s) to ' + parameter.parameter_name +'?' ) ) {
			$scope.submitFileUploadToParameter(parameter.id, parameter.parameter_name);
		}
	}
	$scope.submitFileUploadToParameter = function submitFileUploadToParameter(parameter_id,parameter_name) {
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
				alert( 'File(s) successfully uploaded to ' + parameter_name )
			});

		} else {
			console.log( 'empty' );
		}
	}
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

	$scope.trashed_parameter_files = {};
	$scope.getTrashedParameterFiles = function getTrashedParameterFiles(parameter_id) {
		$http.get(  settings.base_url + 'api/get_trashed_uploads/' + parameter_id )
		.success(function(response) {
			console.log(response);
			$scope.trashed_parameter_files = response.response;
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

	$scope.trashFile = function trashFile(file) {
		if (confirm('Are you sure you want to trash this file?')) {
			$http.post( settings.base_url + 'api/file/trash', file )
			.success( function (response) {
				$( '.row-file-' + file.id ).fadeOut();
			} );
		}
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

	$scope.submitToChairman = function submitToChairman(level_id, area_id) {
		var userdata = settings.userdata();
		if ( confirm( 'Are you sure you want to send your submission?' ) ) {
			userdata.success( function (response) {
				response.userdata.level_id = level_id;
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
	$scope.submitToEvaluator = function submitToEvaluator(level_id) {
		var userdata = settings.userdata();
		if ( confirm( 'Are you sure you want to send entry to In-House Evaluator?' ) ) {
			userdata.success( function (response) {
				response.userdata.level_id = level_id;
				$http.post( settings.base_url + 'api/submission/evaluate', response )
				.success(function (data_response) {
					console.log(data_response);
					if ( data_response.submission > 0 ) {
						alert( 'Successfull submitted. ' );
						location.reload();
					} else {
						alert( 'Error on submission. Check if there is an In house evaluator account. Please try again later' );
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

	// DISPLAY RELATED FILES FIRST
	$scope.dispayAllAvailableFiles = function dispayAllAvailableFiles(parameter_tags) {
		var tagArr = $scope.extractTag(parameter_tags);
		var related_files = [];
		$scope.loader_search = true;
		$scope.related_files = [];
	    $scope.related_file_count = 0;

		if ( tagArr.length > 0 ) {
			for( x in tagArr ) {
				$http.post( settings.base_url + 'api/get_related_files_by_tag/', { tag : tagArr[x] })
				.success( function (response) {
					$scope.$applyAsync(function () {
	    				angular.forEach( response.response, function (value2,key2) {
	    					related_files.push(value2);

	    				} );
	    			} );
				} );				
			}
		}

	    setTimeout(function() {
			$scope.related_file_count = unique(related_files).length;
	    	$scope.related_files = unique(related_files);
	    	$scope.loader_search = false;
	    	$scope.$apply();
	    }, 1500);	
	    	
		// $http.get( settings.base_url + 'api/get_available_files/' + parameter_id )
		// .success( function (response) {
		// 	console.log( response.response )
		// 	$scope.related_files = response.response;
	 //    	$scope.related_file_count = response.response.length;
		// } );
	}
    function unique(arr) {
        var comparer = function compareObject(a, b) {
            if (a.upload_id == b.upload_id) {
                if (a.artist < b.artist) {
                    return -1;
                } else if (a.artist > b.artist) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                if (a.upload_id < b.upload_id) {
                    return -1;
                } else {
                    return 1;
                }
            }
        }

        arr.sort(comparer);
        var end;
        for (var i = 0; i < arr.length - 1; ++i) {
            if (comparer(arr[i], arr[i+1]) === 0) {
                arr.splice(i, 1);
            }
        }
        return arr;
    }

	$scope.submission_status = 0;
	$scope.updateEntryStatus = function updateEntryStatus(submission_id , user_id) {
		console.log( $scope.submission_status, submission_id );
		$http.post( settings.base_url + 'api/submission/status_update/', { submission_status : $scope.submission_status, id : submission_id , user_id : user_id } )
		.success( function (response) {
			console.log( response );
			location.reload();
		} );

	}

	$scope.checkIfHasFiles = function checkIfHasFiles(parameter) {
		// console.log(parameter);
		$http.get( settings.base_url + 'api/parameter/'+parameter.id+'/child_count/'+parameter.child_param_count )
		.success( function (response) {
			console.log( response );
		} );
	}

	$scope.deleteLevel = function deleteLevel(level_id) {
		if ( confirm( 'Are you sure you want to delete this level and its contents?' ) ) {
			$http.post( settings.base_url + 'api/level/delete' , { id:level_id } )
			.success( function (response) {
				console.log(response);
				$( '#level_id-' + level_id ).fadeOut();
			} );
		}
	}

	$scope.trashLevel = function trashLevel(level_id) {
		if ( confirm( 'Are you sure you want to put this level on trash?' ) ) {
			$http.post( settings.base_url + 'api/level/trash' , { id:level_id } )
			.success( function (response) {
				console.log(response);
				$( '#level_id-' + level_id ).fadeOut();
			} );
		}

	}


	$scope.extractTag = function extractTag(stringTags) {
		var tag_arr = new Array();
		// this will return an array with strings "1", "2", etc.
		if ( stringTags ) {
			tag_arr = stringTags.split(",");
		}
		return tag_arr;
	}
	
});