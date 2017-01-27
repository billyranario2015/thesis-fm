fm.controller( "CourseController" , function( $scope, $http, $timeout, settings, $timeout ) {
	console.log('dassda')
	$scope.deleteCourse = function deleteCourse(id) {
		if ( confirm( 'Are you sure you want to delete this course?' ) ) {
			$http.post( settings.base_url + 'api/course/delete' , { id:id } )
			.success( function (response) {
				console.log(response);
				$( '#course-' + id ).fadeOut();
			} );
		}

	}

});