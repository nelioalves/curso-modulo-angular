angular.module('app.services')
.service('Project', ['$resource', '$filter', '$httpParamSerializer', 'appConfig', 
function($resource, $filter, $httpParamSerializer, appConfig){

	function transformDateFields(data) {
		return appConfig.utils.transformData($filter, ['due_date'], 'yyyy-MM-dd', data);
	};

	return $resource(
		appConfig.baseUrl + '/project/:id', 
		{id: '@id'}, 
		{
			update: {
				method: 'PUT'
			},
			save: {
				method: 'POST',
				transformRequest: transformDateFields
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
