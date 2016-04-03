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

	$scope.allPaginate = function() {
	    Client.query(
	    	{
	    		page: 1,
				orderBy: 'created_at',
				sortedBy: 'desc',
				limit: 8	    	
			}, // ATENCAO
			function(value, responseHeaders) {
                if (checkServiceError(value[0])) {
                	$location.path('/home');
                }
                else {
	                $scope.items = value.data;
	                //$scope.itemsTotal = value.meta.pagination.total;
	            }
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
	    );
	};

	$scope.all = function() {
	    $scope.items = Client.query(
	    	{},
			function(value, responseHeaders) {
                if (checkServiceError(value[0])) {
                	$location.path('/home');
                }
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
                if (checkServiceError(value)) {
                	$location.path('/clients');
                }
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
                checkServiceError(value);
               	$location.path('/clients');
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
                checkServiceError(value);
               	$location.path('/clients');
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
                checkServiceError(value);
               	$location.path('/clients');
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};
}]);
