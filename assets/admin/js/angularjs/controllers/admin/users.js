fm.controller( "UsersController" , function( $scope, $http, $timeout, settings, $timeout ) {

	$scope.deleteUser = function deleteUser(id) {
		if ( confirm( 'Are you sure you want to delete this user?' ) ) {
			$http.post( settings.base_url + 'api/user/delete' , { id:id } )
			.success( function (response) {
				console.log(response);
				$( '#user-' + id ).fadeOut();
			} );
		}

	}

});