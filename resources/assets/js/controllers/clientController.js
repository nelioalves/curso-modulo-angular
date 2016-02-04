angular.module('app.controllers')
	.controller('ClientController', 
	['$scope', '$location', '$routeParams', 'Client', 
	function($scope, $location, $routeParams, Client) {

		$scope.cancel = function() {
			$location.path('/clients');
		};

		$scope.new = function() {
			$scope.item = new Client();
		};

		$scope.all = function() {
		    $scope.items = Client.query(
		    	{},
				function(value, responseHeaders) {
                    checkServiceError(value[0]);
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
		    );
        };

		$scope.get = function() {
			$scope.item = Client.get(
				{id: $routeParams.id},
				function(value, responseHeaders) {
                    checkServiceError(value);
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		};

		$scope.save = function() {
			$scope.item.$save(
				{},
				function(value, responseHeaders) {
					if (!checkServiceError(value)) {
						$location.path('/clients');
					}
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		};

		$scope.update = function() {
			Client.update(
				{id: $scope.item.id}, 
				$scope.item, 
				function(value, responseHeaders) {
					if (!checkServiceError(value)) {
						$location.path('/clients');
					}
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		};

		$scope.remove = function() {
			$scope.item.$delete(
				{},
				function(value, responseHeaders) {
					if (!checkServiceError(value)) {
						$location.path('/clients');
					}
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		};
	}]);
