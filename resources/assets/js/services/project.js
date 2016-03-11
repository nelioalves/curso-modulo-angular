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
				isArray: false
			},
			get: {
				method: 'GET',
				transformResponse: transformDateFieldsResp
			}
		}
	);
}]);
