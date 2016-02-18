angular.module('app.services')
.service('ProjectFile', ['$resource', 'appConfig', 'Url', 
function($resource, appConfig, Url){
	var url = appConfig.baseUrl + Url.getUrlResource(appConfig.urls.projectFile);
	return $resource(
		url,  
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
