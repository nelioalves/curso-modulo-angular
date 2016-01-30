angular.module('app.services')
.service('Client', ['$resource', 'appConfig', function($resource, appConfig){
	return $resource(
		appConfig.baseUrl + '/client/:id', 
		{id: '@id'}, 
		{
			update: {
				method: 'PUT'
			},
			query: {
				method: 'GET',
				isArray: true,
				transformResponse: function(data, headers) {
					var dataJson = JSON.parse(data);
					if (dataJson.hasOwnProperty('error') && dataJson.error == true) {
						return [dataJson];
					}
					return dataJson;
				}
			}
		}
	);
}]);
