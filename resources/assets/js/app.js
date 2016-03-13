var app = angular.module('app', [
  'ngRoute', 'angular-oauth2', 'app.controllers', 
  'app.services', 'app.filters', 'app.directives',
  'ngAnimate', 'ui.bootstrap.tpls', 'ui.bootstrap.typeahead', 
  'ui.bootstrap.datepicker', 'ui.bootstrap.modal',
  'ngFileUpload', 'http-auth-interceptor', 'angularUtils.directives.dirPagination',
  'mgcrea.ngStrap.navbar', 'ui.bootstrap.dropdown'
]);

angular.module('app.controllers', ['ngMessages','angular-oauth2']);
angular.module('app.filters', []);
angular.module('app.directives', []);
angular.module('app.services', ['ngResource']);

app.provider('appConfig', ['$httpParamSerializerProvider', 
function($httpParamSerializerProvider) {
  var config = {
    baseUrl: 'http://localhost:8000',
    project: {
      status: [
        {key: 1, value: 'Não iniciado'},
        {key: 2, value: 'Iniciado'},
        {key: 3, value: 'Concluído'}
      ] 
    },
    projectTask: {
      status: [
        {key: 1, value: 'Incompleta'},
        {key: 2, value: 'Completa'}
      ] 
    },
    urls: {
      projectFile: '/project/file/{{id}}/{{idFile}}'
    },
    utils: {
      transformRequest: function(data) {
        if (angular.isObject(data)) {
          return $httpParamSerializerProvider.$get()(data);
        }
        return data;
      },
      transformResponse: function(data, headers) {
        var headersGetter = headers();
        if (headersGetter['content-type']=='application/json' || headersGetter['content-type']=='application/json') {
          var dataJson = JSON.parse(data);
           if (dataJson.hasOwnProperty('data') && Object.keys(dataJson).length == 1) {
            dataJson = dataJson.data;
          }
          return dataJson;
        }
        return data;
      },
      transformDataReq: function (angularFilter, dateFields, strFormat, obj) {
        if (angular.isObject(obj)) {
          var i;
          var o = angular.copy(obj);
          for (i=0; i<dateFields.length; i++) {
            if (obj.hasOwnProperty(dateFields[i]) && obj[dateFields[i]] != null) {
              o[dateFields[i]] = angularFilter('date')(obj[dateFields[i]], strFormat);
            }
          }
          return $httpParamSerializerProvider.$get()(o);
        }
        return obj;
      },
      transformDataResp: function(dateFields, obj) {
        if (angular.isObject(obj)) {
          var i;
          for (i=0; i<dateFields.length; i++) {
            if (obj.hasOwnProperty(dateFields[i]) && obj[dateFields[i]] != null) {
              var vet = obj[dateFields[i]].split('-');
              var month = parseInt(vet[1])-1;
              obj[dateFields[i]] = new Date(vet[0], month, vet[2]);
            }
          }
        }
        return obj;
      }
    }
  };

  return {
    config : config,
    $get: function() {
        return config;
    }
  }
}]);

// config so aceita provider, portanto criamos um provider acima (ATENCAO AO PADRAO DE 
  //NOMES: o provider chama 'appConfig' e aqui ele eh referenciado como 'appConfigProvider')
app.config([
  '$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider',
  function($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider) {

    // Por causa da adaptacao de datas que fizemos, precisamos configurar a aplicacao para aceitar
    // os dados do post e put na forma de urlencoded
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.headers.put['Content-Type']  = 'application/x-www-form-urlencoded;charset=utf-8';

    $httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;
    $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

//    $httpProvider.interceptors.splice(0,1);
//    $httpProvider.interceptors.splice(0,1);
    $httpProvider.interceptors.push('oauthFixInterceptor');

    $routeProvider
      .when('/', {
          templateUrl: 'build/views/home.html',
          controller: 'HomeController'
      })
      .when('/home', {
          templateUrl: 'build/views/home.html',
          controller: 'HomeController'
      })
      .when('/login', {
          templateUrl: 'build/views/login.html',
          controller: 'LoginController'
      })
      .when('/logout', {
          resolve : {
            logout: ['$location', 'OAuthToken', function($location, OAuthToken) {
              OAuthToken.removeToken();
              $location.path('/login');
            }]
          }
          // Criamos o resolve e nao um controller separado por ser muito simples
          // logout eh um objeto no escopo que foi criado
      })
      .when('/clients', {
          templateUrl: 'build/views/client/list.html',
          controller: 'ClientController'
      })
      .when('/clients/new', {
          templateUrl: 'build/views/client/new.html',
          controller: 'ClientController'
      })
      .when('/clients/:id/edit', {
          templateUrl: 'build/views/client/edit.html',
          controller: 'ClientController'
      })
      .when('/clients/:id/remove', {
          templateUrl: 'build/views/client/remove.html',
          controller: 'ClientController'
      })
      .when('/clients/:id', {
          templateUrl: 'build/views/client/show.html',
          controller: 'ClientController'
      })
      .when('/projects', {
          templateUrl: 'build/views/project/list.html',
          controller: 'ProjectController'
      })
      .when('/projects/new', {
          templateUrl: 'build/views/project/new.html',
          controller: 'ProjectController'
      })
      .when('/projects/:id/edit', {
          templateUrl: 'build/views/project/edit.html',
          controller: 'ProjectController'
      })
      .when('/projects/:id/remove', {
          templateUrl: 'build/views/project/remove.html',
          controller: 'ProjectController'
      })
      .when('/projects/:id', {
          templateUrl: 'build/views/project/show.html',
          controller: 'ProjectController'
      })
      .when('/project/:id/notes', {
          templateUrl: 'build/views/projectNote/list.html',
          controller: 'ProjectNoteController'
      })
      .when('/project/:id/notes/new', {
          templateUrl: 'build/views/projectNote/new.html',
          controller: 'ProjectNoteController'
      })
      .when('/project/:id/notes/:idNote/edit', {
          templateUrl: 'build/views/projectNote/edit.html',
          controller: 'ProjectNoteController'
      })
      .when('/project/:id/notes/:idNote/remove', {
          templateUrl: 'build/views/projectNote/remove.html',
          controller: 'ProjectNoteController'
      })
      .when('/project/:id/notes/:idNote', {
          templateUrl: 'build/views/projectNote/show.html',
          controller: 'ProjectNoteController'
      })
      .when('/project/:id/tasks', {
          templateUrl: 'build/views/projectTask/list.html',
          controller: 'ProjectTaskController'
      })
      .when('/project/:id/tasks/new', {
          templateUrl: 'build/views/projectTask/new.html',
          controller: 'ProjectTaskController'
      })
      .when('/project/:id/tasks/:idTask/edit', {
          templateUrl: 'build/views/projectTask/edit.html',
          controller: 'ProjectTaskController'
      })
      .when('/project/:id/tasks/:idTask/remove', {
          templateUrl: 'build/views/projectTask/remove.html',
          controller: 'ProjectTaskController'
      })
      .when('/project/:id/tasks/:idTask', {
          templateUrl: 'build/views/projectTask/show.html',
          controller: 'ProjectTaskController'
      })
      .when('/project/:id/members', {
          templateUrl: 'build/views/projectMember/list.html',
          controller: 'ProjectMemberController'
      })
      .when('/project/:id/members/:idMember/remove', {
          templateUrl: 'build/views/projectMember/remove.html',
          controller: 'ProjectMemberController'
      })
      .when('/project/:id/files', {
          templateUrl: 'build/views/projectFile/list.html',
          controller: 'ProjectFileController'
      })
      .when('/project/:id/files/new', {
          templateUrl: 'build/views/projectFile/new.html',
          controller: 'ProjectFileController'
      })
      .when('/project/:id/files/:idFile/edit', {
          templateUrl: 'build/views/projectFile/edit.html',
          controller: 'ProjectFileController'
      })
      .when('/project/:id/files/:idFile/remove', {
          templateUrl: 'build/views/projectFile/remove.html',
          controller: 'ProjectFileController'
      })


      .when('/ui-datepicker', {
          templateUrl: 'build/views/ui/datepicker.html',
          controller: 'DatepickerDemoCtrl'
      })
      .when('/ui-typeahead', {
          templateUrl: 'build/views/ui/typeahead.html',
          controller: 'TypeaheadCtrl'
      })
    ;

    OAuthProvider.configure({
      baseUrl: appConfigProvider.config.baseUrl,
      clientId: 'appid1',
      clientSecret: 'secret', // optional
      grantPath: 'oauth/access_token'
    });

    // Em producao este codigo deve ser retirado:
    OAuthTokenProvider.configure({
      name: 'token',
      options: {
        secure: false
      }
    });

  }
]);

app.run(['$rootScope', '$location', '$http', '$uibModal', 'httpBuffer', 'OAuth',  
  function($rootScope, $location, $http, $uibModal, httpBuffer, OAuth) {

    // Parametros da funcao: 
    // - dados do evento
    // - proxima rota que o usuario quer acessar
    // - rota atual (se a rota nao existir, vem como undefined)
    $rootScope.$on('$routeChangeStart', function(event, next, current) {
      if (next.$$route.originalPath != '/login') {
        if (!OAuth.isAuthenticated()) {
          $location.path('/login');
        }
      }
    });

    $rootScope.$on('oauth:error', function(event, data) {

      if ((data.hasOwnProperty('rejection') && 'invalid_request' === data.rejection.data.error) || (data.hasOwnProperty('data') && data.data.error === 'invalid_request')) {
        return;
      }

      else if (data.hasOwnProperty('rejection') && 'access_denied' === data.rejection.data.error) {

        return OAuth.getRefreshToken().then(function(response){
          return $http(data.rejection.config).then(function(response){
            return data.deferred.resolve(response);
          });
        },
        function(response) {
          httpBuffer.append(data.rejection.config, data.deferred);
          if (!$rootScope.loginModalOpened) {
            var modalInstance = $uibModal.open({
              templateUrl: 'build/views/templates/loginModal.html',
              controller: 'LoginModalController'
             });
            $rootScope.loginModalOpened = true;
          }
          return;
        });
      }

      else 
        return $location.path('/login');
    });
}]);


