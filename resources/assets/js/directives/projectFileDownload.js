// Lembrete: o nome da diretiva vai virar um atributo html na forma project-file-download

angular.module('app.directives')
.directive('projectFileDownload', ['appConfig', 'ProjectFile',
function(appConfig, ProjectFile){
	return {
		restrict: 'E',
		templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
		link: function(scope, element, attr) {

		},
		controller: ['$scope', '$element', '$attrs', function($scope, $element, $attrs) {
			$scope.downloadFile = function() {
				var anchor = $element.children()[0];
				$jQuery(anchor).addClass('disabled');
				$jQuery(anchor).text('Loading...');

				ProjectFile.download({id:null, idFile: $attrs.idFile} , function(data){
					console.log(data);
				});

//				ProjectFile.download({id:null, idFile: $attrs.idFile} , function(data){
//					console.log(data);
//				});
			};
		}]
	};
}]);
