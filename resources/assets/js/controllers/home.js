angular.module('app.controllers')
.controller('HomeController', ['$scope', '$cookies', '$location', 'Project', 
function($scope, $cookies, $location, Project){

	//console.log($cookies.getObject('user').email + '(controller page home)');

	$scope.inserir = function() {
		$location.path('/projects/new');
	}

	$scope.disp = function(width) {
		if (width == 4) {
			return "col-sm-4";
		}
		else {
			return "col-sm-12";
		}
	}

	$scope.corAlerta = function(project) {
		var hoje = new Date();
		var vet = project.due_date.split('-');
        var month = parseInt(vet[1])-1;
        var data_projeto = new Date(vet[0], month, vet[2]);
		//console.log(data_projeto + ": " + hoje); // IMPRIME O TRIPO DE VEZES!?!?!?
		if (project.status != 3 && data_projeto < hoje)
			return "text-danger status";
		else 
			return "text-default status";
	}

	$scope.showItem = function(item) {
		$scope.item = item;
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

	//---------------------------------------------
	// Pagination:

	$scope.items = [];
    $scope.itemsTotal = 0;
    $scope.itemsPerPage = 6; // this should match however many results your API puts on one page

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