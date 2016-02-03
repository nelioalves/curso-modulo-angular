angular.module('app.controllers')
	.controller('ProjectController', 
	['$scope', '$location', '$cookies', '$routeParams', 'appConfig', 'Project', 'Client', 
	function($scope, $location, $cookies, $routeParams, appConfig, Project, Client) {

		$scope.cancel = function() {
			$location.path('/projects'); // ATENCAO
		}

		$scope.new = function() {
			$scope.clients = Client.query(); // ATENCAO
			$scope.status = appConfig.project.status; // ATENCAO
			$scope.item = new Project(); 
			$scope.item.progress = 0; // ATENCAO
			//$scope.item.project_id = $routeParams.id; // ATENCAO
		}

		$scope.all = function() {
		    $scope.items = Project.query(
		    	{}, // ATENCAO
				function(value, responseHeaders) {
                    checkServiceError(value[0]);
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
		    );
        }

		$scope.get = function() {
			$scope.clients = Client.query(); // ATENCAO
			$scope.status = appConfig.project.status; // ATENCAO
			$scope.item = Project.get(
				{id: $routeParams.id}, // ATENCAO
				function(value, responseHeaders) {
                    checkServiceError(value);
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		}

		$scope.save = function() {
			$scope.item.owner_id = $cookies.getObject('user').id; // ATENCAO
			$scope.item.$save(
				{},
				function(value, responseHeaders) {
					if (!checkServiceError(value)) {
						$location.path('/projects'); // ATENCAO
					}
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		}

		$scope.update = function() {
			//$scope.item.owner_id = $cookies.getObject('user').id; // ATENCAO
			//$scope.item.owner_id = $scope.item.owner.data.id;
			Project.update(
				{id: $scope.item.id}, 
				$scope.item, 
				function(value, responseHeaders) {
					if (!checkServiceError(value)) {
						$location.path('/projects'); // ATENCAO
					}
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		}

		$scope.remove = function() {
			//project_id = $scope.item.project_id; // ATENCAO
			$scope.item.$delete(
				{},
				function(value, responseHeaders) {
					if (!checkServiceError(value)) {
						$location.path('/projects'); // ATENCAO
					}
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		}
	}]);
