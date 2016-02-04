angular.module('app.controllers')
	.controller('ProjectNoteController', 
	['$scope', '$location', '$routeParams', 'ProjectNote', 
	function($scope, $location, $routeParams, ProjectNote) {

		$scope.project_id = $routeParams.id; // ATENCAO

		$scope.cancel = function() {
			$location.path('/project/'+$scope.item.project_id+'/notes'); // ATENCAO
		};

		$scope.new = function() {
			$scope.item = new ProjectNote();
			$scope.item.project_id = $routeParams.id; // ATENCAO
		};

		$scope.all = function() {
		    $scope.items = ProjectNote.query(
		    	{id: $routeParams.id}, // ATENCAO
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
			$scope.item = ProjectNote.get(
				{id: $routeParams.id, idNote: $routeParams.idNote}, // ATENCAO
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
						$location.path('/project/'+$scope.item.project_id+'/notes'); // ATENCAO
					}
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		};

		$scope.update = function() {
			ProjectNote.update(
				{id: $scope.item.id}, 
				$scope.item, 
				function(value, responseHeaders) {
					if (!checkServiceError(value)) {
						$location.path('/project/'+$scope.item.project_id+'/notes'); // ATENCAO
					}
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		};

		$scope.remove = function() {
			project_id = $scope.item.project_id; // ATENCAO
			$scope.item.$delete(
				{},
				function(value, responseHeaders) {
					if (!checkServiceError(value)) {
						$location.path('/project/'+project_id+'/notes'); // ATENCAO
					}
				},
				function(httpResponse) {
					alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
					console.log(httpResponse);
				}
			);
		};
	}]);
