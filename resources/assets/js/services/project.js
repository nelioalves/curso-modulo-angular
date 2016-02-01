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
			save: {
				method: 'POST',
				transformRequest: function(data, headers) {
					if (angular.isObject(data) && data.hasOwnProperty('due_date')) {
						data.due_date = $filter('date')(data.due_date, 'yyyy-MM-dd');
						return $httpParamSerializer(data);
					}
					return data;
				}
			},
			query: {
				method: 'GET',
				isArray: true,
				transformResponse: function(data, headers) {
					var headersGetter = headers();
				    if (headersGetter['content-type']=='application/json' || headersGetter['content-type']=='application/json') {
				    	var dataJson = JSON.parse(data);
				        if (dataJson.hasOwnProperty('data')) {
				          dataJson = dataJson.data;
				        }
				        if (dataJson.hasOwnProperty('error') && dataJson.error == true) {
							return [dataJson];
						}
				        return dataJson;
				      }
				    return data;
				}
			}
		}
	);
}]);
