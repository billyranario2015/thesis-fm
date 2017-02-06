var fm = angular.module( 'MUSTFM' , ['ngSanitize', 'angular.filter'] );


fm.factory( 'settings' , function(){
	var env = {
		status 		: 'development',
		base_url	: window.location.origin + '/',
	}
	return env;
});