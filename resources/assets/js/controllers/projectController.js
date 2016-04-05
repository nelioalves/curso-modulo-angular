angular.module('app.controllers')
.controller('ProjectController', 
['$scope', '$location', '$cookies', '$routeParams', 'appConfig', 'Project', 'Client2', 'ProjectTask', 
function($scope, $location, $cookies, $routeParams, appConfig, Project, Client2, ProjectTask) {

	$scope.finalizarTarefa = function(task) {
		task.status = 2;
		ProjectTask.update(
			{id: task.id}, 
			task, 
			function(value, responseHeaders) {
                //checkServiceError(value);
               	//$location.path('/project/'+id+'/tasks');
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	}

	$scope.cancel = function() {
		$location.path('/projects'); // ATENCAO
	};

	$scope.showItem = function(item) {
		$scope.item = item;
	};

	$scope.new = function() {
		//$scope.clients = Client2.query(); // ATENCAO (removido pq agora nao estamos mais trabalhando com a lista estatica de clientes)
		$scope.status = appConfig.project.status; // ATENCAO
		$scope.item = new Project(); 
		$scope.item.due_date = new Date();
		$scope.item.progress = 0; // ATENCAO
	};

	$scope.allPaginate = function(pageNumber) {
	    Project.query(
	    	{page: pageNumber, limit: $scope.itemsPerPage}, // ATENCAO
			function(value, responseHeaders) {
                if (checkServiceError(value[0])) {
                	$location.path('/home');
                }
                else {
	                $scope.items = value.data;
	                if ($scope.items.length > 0) {
	                	$scope.showItem($scope.items[0]);
	                }
	                $scope.itemsTotal = value.meta.pagination.total;
	            }
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
	    );
    };



	$scope.all = function() {
	    $scope.items = Project.query(
	    	{}, // ATENCAO
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
		//$scope.clients = Client2.query(); // ATENCAO (removido pq agora nao estamos mais trabalhando com a lista estatica de clientes)
		$scope.status = appConfig.project.status; // ATENCAO
		$scope.item = Project.get(
			{id: $routeParams.id}, // ATENCAO
			function(value, responseHeaders) {
                if (checkServiceError(value)) {
                	$location.path('/projects');
                }
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

	$scope.save = function() {
		$scope.item.owner_id = $cookies.getObject('user').id; // ATENCAO
		$scope.item.$save(
			{},
			function(value, responseHeaders) {
				checkServiceError(value);
				$location.path('/projects/dashboard'); // ATENCAO
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

	$scope.update = function() {
		Project.update(
			{id: $scope.item.id}, 
			$scope.item, 
			function(value, responseHeaders) {
				checkServiceError(value);
				$location.path('/projects/dashboard'); // ATENCAO
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
				$location.path('/projects/dashboard'); // ATENCAO
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
    $scope.itemsPerPage = 5; // this should match however many results your API puts on one page

    $scope.pagination = {
        current: 1
    };

    $scope.pageChanged = function(newPage) {
        getResultsPage(newPage);
    };

    function getResultsPage(pageNumber) {
    	$scope.allPaginate(pageNumber);
    }

    //getResultsPage(1);

	//---------------------------------------------
	// Datepicker:

	$scope.due_date_popup = {
	    opened: false
	};

	$scope.due_date_open = function() {
	    $scope.due_date_popup.opened = true;
	};

	//---------------------------------------------
	// Typeahead:

	$scope.formatName = function(obj) {
		if (obj) {
			return obj.name;
		}
		return '';
	};

	$scope.getClients = function(name) {
		return Client2.query({
			search: name,
			searchFields: 'name:like'
		}).$promise;
	};

	$scope.selectClient = function(obj) {
		$scope.item.client_id = obj.id;
	};

}]);
