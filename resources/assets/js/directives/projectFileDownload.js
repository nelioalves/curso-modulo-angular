// Lembrete: o nome da diretiva vai virar um elemento html na forma project-file-download

angular.module('app.directives')
.directive('projectFileDownload', ['$timeout', 'appConfig', 'ProjectFile',
function($timeout, appConfig, ProjectFile){
	return {
		restrict: 'E',
		templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
		link: function(scope, element, attr) {
			var anchor = element.children()[0];
			scope.$on('salvar-arquivo', function(event, data) {
				$jQuery(anchor).removeClass('disabled');
				$jQuery(anchor).text('Download');
				$jQuery(anchor).attr({
					href: 'data:application-octet-stream;base64,'+data.file,
					download: data.name
				});

				$timeout(function() {
					scope.downloadFile = function() {};
					$jQuery(anchor)[0].click();
				});


			});
		},
		controller: ['$scope', '$element', '$attrs',
			function($scope, $element, $attrs) {
			$scope.downloadFile = function() {
				var anchor = $element.children()[0];
				$jQuery(anchor).addClass('disabled');
				$jQuery(anchor).text('Loading...');

				ProjectFile.download({id:null, idFile: $attrs.idFile} , function(data){
					$scope.$emit('salvar-arquivo', data);
				});
			};
		}]
	};
}]);
