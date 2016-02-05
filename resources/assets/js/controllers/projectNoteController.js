angular.module('app.controllers')
.controller('ProjectNoteController', 
['$scope', '$location', '$routeParams', 'ProjectNote', 
function($scope, $location, $routeParams, ProjectNote) {

	$scope.cancel = function() {
		var id = $scope.item.project_id;
		$location.path('/project/'+id+'/notes'); // ATENCAO
	};

	$scope.new = function() {
		$scope.item = new ProjectNote();
		$scope.item.project_id = $routeParams.id; // ATENCAO
	};

	$scope.all = function() {
		$scope.father_id = $routeParams.id; // ATENCAO
	    $scope.items = ProjectNote.query(
	    	{id: $routeParams.id}, // ATENCAO
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
		var id = $routeParams.id; // ATENCAO (salva o id do projeto)
		$scope.item = ProjectNote.get(
			{id: $routeParams.id, idNote: $routeParams.idNote}, // ATENCAO
			function(value, responseHeaders) {
                if (checkServiceError(value)) {
                	$location.path('/project/'+id+'/notes');
                }
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

	$scope.save = function() {
		var id = $scope.item.project_id; // ATENCAO (salva o id do projeto)
		$scope.item.$save(
			{},
			function(value, responseHeaders) {
                checkServiceError(value);
               	$location.path('/project/'+id+'/notes');
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

	$scope.update = function() {
		var id = $scope.item.project_id; // ATENCAO
		ProjectNote.update(
			{id: $scope.item.id}, 
			$scope.item, 
			function(value, responseHeaders) {
                checkServiceError(value);
               	$location.path('/project/'+id+'/notes');
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

	$scope.remove = function() {
		var id = $scope.item.project_id; // ATENCAO (salva o id pra montar a url depois)
		$scope.item.$delete(
			{},
			function(value, responseHeaders) {
                checkServiceError(value);
               	$location.path('/project/'+id+'/notes');
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};
}]);
