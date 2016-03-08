// Lembrete: o nome da diretiva vai virar um elemento html na forma login-form

// Esta diretiva foi necessaria para forçar o template a compartilhar o escopo anterior,
// pois o ng-include cria um novo escopo

angular.module('app.directives')
.directive('loginForm', ['appConfig',
function(appConfig){
	return {
		restrict: 'E',
		templateUrl: appConfig.baseUrl + '/build/views/templates/form-login.html',
		scope: false
	};
}]);
