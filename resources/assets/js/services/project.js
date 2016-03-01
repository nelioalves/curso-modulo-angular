angular.module('app.services')
.service('Project', ['$resource', '$filter', 'appConfig', 
function($resource, $filter, appConfig){

	function transformDateFieldsReq(data) {
		return appConfig.utils.transformDataReq($filter, ['due_date'], 'yyyy-MM-dd', data);
	};

	function transformDateFieldsResp(data, headers) {
        var obj = appConfig.utils.transformResponse(data, headers);
		return appConfig.utils.transformDataResp(['due_date'], obj);
	};

	return $resource(
		appConfig.baseUrl + '/project/:id', 
		{id: '@id'}, 
		{
			update: {
				method: 'PUT',
				transformRequest: transformDateFieldsReq
			},
			save: {
				method: 'POST',
				transformRequest: transformDateFieldsReq
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
			},
			get: {
				method: 'GET',
				transformResponse: transformDateFieldsResp
			}
		}
	);
}]);
