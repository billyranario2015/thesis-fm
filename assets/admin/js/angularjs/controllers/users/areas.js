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
			console.log(response.response);
			$scope.parameters = response.response;
		})
	}

	$scope.parameter = {};
	$scope.createParameter = function createParameter(area_id,type) {
		$scope.inputData = {};
	// 	$scope.inputData.area_id = $scope.parameter.area_id ;

		if ( $scope.parameter.sub_parameter_name.length > 0 && type == 'sub_parent' ) {
			$scope.inputData.parameter_name = $scope.parameter.sub_parameter_name;
		}
		console.log( $scope.inputData );

	// 	$http.post( settings.base_url + 'api/create/parameter', $scope.parameter )
	// 	.success( function(response) {
	// 		$scope.getParameters( area_id );
	// 		console.log( response );
	// 	} );
	}

});