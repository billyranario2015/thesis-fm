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
	$scope.userdata = {};
	$scope.belongsToArea = {};
	$scope.notifications = {};
	$scope.submission_data = {};
	$scope.submission_count = 0;

	var userdata = settings.userdata();
	var userInfo = {};

	userdata.success( function (response) {
		userInfo = response;
		console.log(response)
	} );

	setTimeout(function() {
		$scope.userdata = userInfo.userdata;
		$scope.notifications = userInfo.notifications;
		// $scope.submission_data = userInfo.submission;
		$scope.belongsToArea = userInfo.belongsToArea;
		// if ( typeof userInfo.submission['id'] !== 'undefined' && userInfo.submission['id'] !== null ) {
		// 	$scope.submission_count = 1;
		// } else {
		// 	$scope.submission_count = 0;
		// }
		// console.log( $scope.submission_data )
		$scope.$apply();
	}, 700);


	// GET SUBMISSION STATUS OF THE CURRENT AREA
	$scope.getSubmissionStatus = function getSubmissionStatus(area_id) {
		$http.get( settings.base_url + 'api/submission/status/area/' + area_id )
		.success( function (response) {
			if ( typeof response.submission_status.id !== 'undefined' && response.submission_status.id !== null ) {
				$scope.submission_count = 1;
				$scope.submission_data = response.submission_status;
			} else {
				$scope.submission_count = 0;
			}
			console.log(response.submission_status);
		} );
	}

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

	// Filter Notification
	$scope.filterNotification = function filterNotification(notification,user_id) {
		var notifs = [];
		for( x in notification ) {
			if ( notification[x].id != user_id ) {
				notifs.push(notification[x]);	
			}
		}
		return notifs.length;
	}

	var colors = [
		{ color: 'bg-red' },
		{ color: 'bg-pink' },
		{ color: 'bg-purple' },
		{ color: 'bg-deep-purple' },
		{ color: 'bg-indigo'},
		{ color: 'bg-blue' },
		{ color: 'bg-light-blue' },
		{ color: 'bg-cyan' },
		{ color: 'bg-teal' },
		{ color: 'bg-green'},
		{ color: 'bg-light-green' },
		{ color: 'bg-lime' },
		{ color: 'bg-yellow' },
		{ color: 'bg-amber' },
		{ color: 'bg-orange'},
		{ color: 'bg-deep-orange' },
		{ color: 'bg-brown' },
		{ color: 'bg-grey' },
		{ color: 'bg-blue' },
		{ color: 'bg-black' }
	];


	$scope.randomColor = function() {
	  // return colors[Math.floor(Math.random() * colors.length)].color;
	  return colors[8].color;
	};

} );