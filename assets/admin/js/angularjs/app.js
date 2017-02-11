var fm = angular.module( 'MUSTFM' , ['ngSanitize', 'angular.filter'] );


fm.factory( 'settings' , function($http){
	var env = {
		status 		: 'development',
		base_url	: window.location.origin + '/',
		userdata: function() {
			return $http.get( window.location.origin + '/get/userdata' );
	    }
	}


	return env;
});


fm.controller( "MainController" , function( $scope, $http, $timeout, settings, $timeout, $rootScope ) {
	$scope.notifications = {};
	$scope.submission_data = {};
	$scope.submission_count = 0;

	var userdata = settings.userdata();
	var userInfo = {};

	userdata.success( function (response) {
		userInfo = response;
	} );

	setTimeout(function() {
		$scope.notifications = userInfo.notifications;
		$scope.submission_data = userInfo.submission;
		if ( typeof userInfo.submission['id'] !== 'undefined' && userInfo.submission['id'] !== null ) {
			$scope.submission_count = 1;
		} else {
			$scope.submission_count = 0;
		}
		console.log( $scope.submission_data )
		$scope.$apply();
	}, 700);

	// ADD COMMENT 
	$scope.commentFields = {};
	$scope.addComment = function addComment(comment_type,area_id) {
		$scope.commentFields.target_id = area_id;
		$scope.commentFields.comment_type = comment_type;
		console.log( $scope.commentFields );
		$http.post( settings.base_url + 'api/comment/create', $scope.commentFields )
		.success( function (response) {
			console.log(response);
			$scope.getComments(area_id);
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
	$scope.dateParser = function dateParser(date) {
    	return new Date(date);
	}

} );