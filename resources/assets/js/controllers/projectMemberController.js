angular.module('app.controllers')
.controller('ProjectMemberController', 
['$scope', '$location', '$routeParams', 'ProjectMember', 'User', 
function($scope, $location, $routeParams, ProjectMember, User) {

	$scope.cancel = function() {
		var id = $scope.item.project_id;
		$location.path('/project/'+id+'/members'); // ATENCAO
	};

	$scope.new = function() {
		$scope.item = new ProjectMember();
		$scope.item.project_id = $routeParams.id; // ATENCAO
	};

	$scope.all = function() {
		$scope.father_id = $routeParams.id; // ATENCAO
	    $scope.items = ProjectMember.query(
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
		$scope.item = ProjectMember.get(
			{id: $routeParams.id, idMember: $routeParams.idMember}, // ATENCAO
			function(value, responseHeaders) {
                if (checkServiceError(value)) {
                	$location.path('/project/'+id+'/members');
                }
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

	$scope.quickSave = function() {
		var id = $scope.item.project_id; // ATENCAO (salva o id do projeto)
		$scope.item.$save(
			{id: $routeParams.id},
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

	$scope.remove = function() {
		var id = $scope.item.project_id; // ATENCAO (salva o id pra montar a url depois)
		$scope.item.$delete(
			{id: $routeParams.id, idMember: $routeParams.idMember},
			function(value, responseHeaders) {
                checkServiceError(value);
               	$location.path('/project/'+id+'/members');
			},
			function(httpResponse) {
				alert("Erro "+httpResponse.status+": "+httpResponse.statusText);
				console.log(httpResponse);
			}
		);
	};

	//---------------------------------------------
	// Typeahead:

	$scope.formatName = function(obj) {
		if (obj) {
			return obj.name;
		}
		return '';
	};

	$scope.getUsers = function(name) {
		return User.query({
			search: name,
			searchFields: 'name:like'
		}).$promise;
	};

	$scope.selectUser = function(obj) {
		$scope.item.user_id = obj.id;
	};

}]);
