fm.controller( "OrganizationController" , function( $scope, $http, $timeout, settings, $timeout ) {

	$scope.deleteOrg = function deleteOrg(id) {
		if ( confirm( 'Are you sure you want to delete this organization?' ) ) {
			$http.post( settings.base_url + 'api/organization/delete' , { id:id } )
			.success( function (response) {
				console.log(response);
				$( '#org-' + id ).fadeOut();
			} );
		}

	}

});