angular.module('app.controllers')
.controller('LoginModalController', 
['$scope', '$rootScope', '$location', '$cookies', '$uibModalInstance', 
'authService', 'User', 'OAuth', 'OAuthToken', 
function($scope, $rootScope, $location, $cookies, $uibModalInstance, 
	authService, User, OAuth, OAuthToken){
	$scope.user = {
		username : '',
		password : ''
	};

	$scope.error = {
		message: '',
		error: false
	};

	$scope.$on('event:auth-loginCancelled', function(){
		OAuthToken.removeToken();
	});

	$scope.$on('event:auth-loginConfirmed', function(){
		$rootScope.loginModalOpened = false;
		$uibModalInstance.close();
	});

	$scope.$on('$routeChangeStart', function(){
		$rootScope.loginModalOpened = false;
		$uibModalInstance.dismiss('cancel');
	});

	$scope.login = function() {
		if ($scope.form.$valid) {

			OAuth.getAccessToken($scope.user).then(
			function() {
				User.authenticated({},{}, function(data) {
					$cookies.putObject('user', data);
					authService.loginConfirmed();
				});
			}, 
			function(data) {
				$scope.error.error = true;
				$scope.error.message = data.data.error_description;
			});
		}
	};

	$scope.cancel = function() {
		authService.loginCancelled();
		$location.path('/login');
	};
}]);