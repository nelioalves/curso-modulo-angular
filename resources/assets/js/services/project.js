angular.module('app.services')
.service('Project', ['$resource', '$filter', '$httpParamSerializer', 'appConfig', 
function($resource, $filter, $httpParamSerializer, appConfig){
	return $resource(
		appConfig.baseUrl + '/project/:id', 
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
