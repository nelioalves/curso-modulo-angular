angular.module('app.controllers')
.controller('ProjectTaskController', 
['$scope', '$location', '$routeParams', 'appConfig', 'ProjectTask', 
function($scope, $location, $routeParams, appConfig, ProjectTask) {

	$scope.loadTask = function() {
		$scope.items = ProjectTask.query({
			id: $routeParams.id,
			orderBy: 'id',
			sortedBy: 'desc'
		});
	};

	$scope.loadTask();

	$scope.cancel = function() {
		var id = $scope.item.project_id;
		$location.path('/project/'+id+'/tasks'); // ATENCAO
	};

	$scope.new = function() {
		$scope.item = new ProjectTask();
		$scope.status = appConfig.projectTask.status; // ATENCAO
		$scope.item.project_id = $routeParams.id; // ATENCAO
	};

	$scope.all = function() {
		$scope.father_id = $routeParams.id; // ATENCAO
	    $scope.items = ProjectTask.query(
	    	{id: $routeParams.id,
			orderBy: 'id',
			sortedBy: 'desc'}, // ATENCAO
			function(value, responseHeaders) {
                if (checkServiceError(value[0])) {
                	$location.path('/projects');
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
		$scope.status = appConfig.projectTask.status; // ATENCAO
		$scope.item = ProjectTask.get(
			{id: $routeParams.id, idTask: $routeParams.idTask}, // ATENCAO
			function(value, responseHeaders) {
                if (checkServiceError(value)) {
                	$location.path('/project/'+id+'/tasks');
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
               	$location.path('/project/'+id+'/tasks');
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

	$scope.quickSave = function() {
		var id = $scope.item.project_id; // ATENCAO (salva o id do projeto)
		$scope.item.status = appConfig.projectTask.status[0].key;
		$scope.item.$save(
			{},
			function(value, responseHeaders) {
                checkServiceError(value);
               	$scope.all();
               	$scope.new();
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

	$scope.update = function() {
		var id = $scope.item.project_id; // ATENCAO
		ProjectTask.update(
			{id: $scope.item.id}, 
			$scope.item, 
			function(value, responseHeaders) {
                checkServiceError(value);
               	$location.path('/project/'+id+'/tasks');
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
               	$location.path('/project/'+id+'/tasks');
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

	$scope.start_date_popup = {
	    opened: false
	};

	$scope.start_date_open = function() {
	    $scope.start_date_popup.opened = true;
	};

}]);
