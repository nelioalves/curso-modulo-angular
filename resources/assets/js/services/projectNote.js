angular.module('app.services')
.service('ProjectNote', ['$resource', 'appConfig', function($resource, appConfig){
	return $resource(
		appConfig.baseUrl + '/project/note/:id/:idNote', 
		{id: '@id', idNote: '@idNote'}, 
		{
			update: {
				method: 'PUT'
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