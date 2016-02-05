angular.module('app.services')
.service('Project', ['$resource', '$filter', 'appConfig', 
function($resource, $filter, appConfig){

	function transformDateFields(data) {
		return appConfig.utils.transformData($filter, ['due_date'], 'yyyy-MM-dd', data);
	};

	return $resource(
		appConfig.baseUrl + '/project/:id', 
		{id: '@id'}, 
		{
			update: {
				method: 'PUT',
				transformRequest: transformDateFields
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
			},
			get: {
				method: 'GET',
				transformResponse: function(data, headers) {
					var o = appConfig.utils.transformResponse(data, headers);
					if (angular.isObject(o) && o.hasOwnProperty('due_date')) {
						var vet = o.due_date.split('-');
						var month = parseInt(vet[1])-1;
						o.due_date = new Date(vet[0], month, vet[2]);
					}
					return o; 
				}
			}
		}
	);
}]);
