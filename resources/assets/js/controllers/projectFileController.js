angular.module('app.controllers')
.controller('ProjectFileController', 
['$scope', '$location', '$routeParams', 'appConfig', 'Url', 'Upload', 'ProjectFile', 
function($scope, $location, $routeParams, appConfig, Url, Upload, ProjectFile) {

	// TESTE DO SERVICO URL:
	//console.log(Url.getUrlResource('project/file/{{id}}/{{idFile}}'));
	//console.log(Url.getUrlFromUrlSymbol('project/file/{{id}}/{{idFile}}', {id:1, idFile:10}));
	//console.log(Url.getUrlFromUrlSymbol('project/file/{{id}}/{{idFile}}', {id:'', idFile:10}));
	//console.log(Url.getUrlFromUrlSymbol('project/file/{{id}}/{{idFile}}', {id:1, idFile:''}));

	$scope.cancel = function() {
		var id = $scope.item.project_id;
		$location.path('/project/'+id+'/files'); // ATENCAO
	};

	$scope.new = function() {
		$scope.item = new ProjectFile();
		$scope.item.project_id = $routeParams.id; // ATENCAO
	};

	$scope.all = function() {
		$scope.father_id = $routeParams.id; // ATENCAO
	    $scope.items = ProjectFile.query(
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
/*
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
*/
	$scope.save = function() {
		var id = $scope.item.project_id; // ATENCAO (salva o id do projeto)
		var url = appConfig.baseUrl + 
			Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {id: '', idFile: ''});
		//console.log(url);
		var data = {
        	file: $scope.item.file,
        	name: $scope.item.name,
        	description: $scope.item.description,
        	project_id: $scope.item.project_id
        };
  		//console.log(data);
		Upload.upload({
            url: url,
            data: data
        }).then(function (resp) {
            //console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
            $location.path('/project/'+id+'/files');
        });
        /*
        , function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        }); */


		/*
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
		*/
	};
/*
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
*/
}]);
