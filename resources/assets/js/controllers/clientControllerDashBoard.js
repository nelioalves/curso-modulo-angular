angular.module('app.controllers')
.controller('ClientControllerDashBoard', 
['$scope', '$location', '$routeParams', 'Client', 
function($scope, $location, $routeParams, Client) {

	$scope.cancel = function() {
		$location.path('/clients');
	};

	$scope.new = function() {
		$scope.item = new Client();
	};

	$scope.showItem = function(item) {
		$scope.item = item;
	};

	$scope.allPaginate = function(pageNumber) {
	    Client.query(
	    	{
	    		page: pageNumber,
				orderBy: 'created_at',
				sortedBy: 'desc',
				limit: $scope.itemsPerPage	    	
			}, // ATENCAO
			function(value, responseHeaders) {
                if (checkServiceError(value[0])) {
                	$location.path('/home');
                }
                else {
	                $scope.items = value.data;
	                $scope.itemsTotal = value.meta.pagination.total;
	                if ($scope.items.length > 0) {
	                	$scope.showItem($scope.items[0]);
	                }
	            }
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
	    );
	};

	$scope.all = function() {
	    Client.query(
	    	{},
			function(value, responseHeaders) {
                if (checkServiceError(value[0])) {
                	$location.path('/home');
                }
                else {
	                $scope.items = value.data;
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

		//---------------------------------------------
	// Pagination:

	$scope.items = [];
    $scope.itemsTotal = 0;
    $scope.itemsPerPage = 3; // this should match however many results your API puts on one page

    $scope.pagination = {
        current: 1
    };

    $scope.pageChanged = function(newPage) {
        getResultsPage(newPage);
    };

    function getResultsPage(pageNumber) {
    	$scope.allPaginate(pageNumber);
    }

}]);
