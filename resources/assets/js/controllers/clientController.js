angular.module('app.controllers')
	.controller('ClientController', 
	['$scope', '$location', '$routeParams', 'Client', 
		function($scope, $location, $routeParams, Client) {
		
		$scope.new = function() {
			$scope.client = new Client();
		}

		$scope.all = function() {
		    $scope.clients = Client.query();
        }

		$scope.get = function() {
			$scope.client = Client.get({id: $routeParams.id});
		}

		$scope.save = function() {
			if ($scope.form.$valid) {
				$scope.client.$save().then(function() {
					$location.path('/clients');
				});
			}
		}

		$scope.update = function() {
			if ($scope.form.$valid) {
				Client.update({id: $scope.client.id}, $scope.client, function() {
					$location.path('/clients');
				});
			}
		}

		$scope.remove = function() {
			$scope.client.$delete().then(function() {
				$location.path('/clients');
			});
		}
	}]);