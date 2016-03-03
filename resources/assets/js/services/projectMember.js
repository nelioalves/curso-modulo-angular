angular.module('app.services')
.service('ProjectMember', ['$resource', 'appConfig', 
function($resource, appConfig){
	return $resource(
		appConfig.baseUrl + '/project/:id/member/:idMember', 
		{id: '@id', idMember: '@idMember'}, 
		{
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
