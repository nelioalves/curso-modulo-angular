angular.module('app.services')
.service('ProjectTask', ['$resource', '$filter', 'appConfig', 
function($resource, $filter, appConfig){

	function transformDateFieldsReq(data) {
		return appConfig.utils.transformDataReq($filter, ['due_date', 'start_date'], 'yyyy-MM-dd', data);
	};

	function transformDateFieldsResp(data, headers) {
        var obj = appConfig.utils.transformResponse(data, headers);
		return appConfig.utils.transformDataResp(['due_date', 'start_date'], obj);
	};

	return $resource(
		appConfig.baseUrl + '/project/task/:id/:idTask', 
		{id: '@id', idTask: '@idTask'}, 
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
