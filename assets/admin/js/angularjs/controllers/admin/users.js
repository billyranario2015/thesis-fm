fm.controller( "UsersController" , function( $scope, $http, $timeout, settings, $timeout ) {

	$scope.trashUser = function trashUser(id) {
		if ( confirm( 'Are you sure you want to put this user on trash?' ) ) {
			$http.post( settings.base_url + 'api/user/trash' , { id:id } )
			.success( function (response) {
				console.log(response);
				$( '#user-' + id ).fadeOut();
			} );
		}

	}

	$scope.deleteUser = function deleteUser(id) {
		if ( confirm( 'Are you sure you want to delete this user?' ) ) {
			$http.post( settings.base_url + 'api/user/delete' , { id:id } )
			.success( function (response) {
				console.log(response);
				$( '#user-' + id ).fadeOut();
			} );
		}

	}	

	$scope.parameter_lists = {};
	$scope.get_list_of_parameters = function get_list_of_parameters() {
		$http.get( settings.base_url + 'api/get_all_parameters' )
		.success( function (response) {
			console.log(response);
			$scope.parameter_lists = response.response;
		} );		
	}
	$scope.get_list_of_parameters();
	
	// $scope.getRandomColor = function getRandomColor() {
	//     var letters = '0123456789ABCDEF';
	//     var color = '#';
	//     for (var i = 0; i < 6; i++ ) {
	//         color += letters[Math.floor(Math.random() * 16)];
	//     }
	//     return color;
	// }

});