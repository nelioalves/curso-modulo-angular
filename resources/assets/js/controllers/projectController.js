angular.module('app.controllers')
.controller('ProjectController', 
['$scope', '$location', '$cookies', '$routeParams', 'appConfig', 'Project', 'Client', 
function($scope, $location, $cookies, $routeParams, appConfig, Project, Client) {

	$scope.cancel = function() {
		$location.path('/projects'); // ATENCAO
	};

	$scope.new = function() {
		$scope.clients = Client.query(); // ATENCAO (removido pq agora nao estamos mais trabalhando com a lista estatica de clientes)
		$scope.status = appConfig.project.status; // ATENCAO
		$scope.item = new Project(); 
		$scope.item.due_date = new Date();
		$scope.item.progress = 0; // ATENCAO
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
		$scope.clients = Client.query(); // ATENCAO (removido pq agora nao estamos mais trabalhando com a lista estatica de clientes)
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
				$location.path('/projects'); // ATENCAO
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
				$location.path('/projects'); // ATENCAO
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
				$location.path('/projects'); // ATENCAO
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

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
		return Client.query({
			search: name,
			searchFields: 'name:like'
		}).$promise;
	};

	$scope.selectClient = function(obj) {
		$scope.item.client_id = obj.id;
	};

}]);
