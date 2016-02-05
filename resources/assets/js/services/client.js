angular.module('app.services')
.service('Client', ['$resource', 'appConfig', 
function($resource, appConfig){
	return $resource(
		appConfig.baseUrl + '/client/:id', 
		{id: '@id'}, 
		{
			update: {
				method: 'PUT'
			},
			query: {
				method: 'GET',
				isArray: true,
				transformResponse: function(data, headers) {
					resp = appConfig.utils.transformResponse(data, headers);
					if (angular.isObject(resp) && resp.hasOwnProperty('error') && resp.error == true) {
						return [resp];
					}
					return resp;
				}
			}
		}
	);
}]);
