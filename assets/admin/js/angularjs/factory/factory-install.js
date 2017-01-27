ims.factory('install', ['$http', function($http) {
    
    var validation = {};

    validation.db_install = function (data) {
        return $http( {
            url: window.location.origin + '/installation/configure-db',
            method: "POST",
            data: data,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        } );
    }
    return validation;
}]);