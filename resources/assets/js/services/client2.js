angular.module('app.services')
.service('Client2', ['$resource', 'appConfig', 
function($resource, appConfig){
	return $resource(
		appConfig.baseUrl + '/clientsAll', 
		{}, 
		{}
	);
}]);
