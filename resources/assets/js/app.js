var app = angular.module('app', [
  'ngRoute', 'angular-oauth2', 'app.controllers', 
  'app.services', 'app.filters', 'ngAnimate',
  'ui.bootstrap.tpls', 'ui.bootstrap.typeahead', 
  'ui.bootstrap.datepicker', 'ngFileUpload'
]);

angular.module('app.controllers', ['ngMessages','angular-oauth2']);
angular.module('app.filters', []);
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
          if (dataJson.hasOwnProperty('data')) {
            dataJson = dataJson.data;
          }
          return dataJson;
        }
        return data;
      },
      transformData: function (filter, dateFields, strFormat, data) {
        if (angular.isObject(data)) {
          var i;
          var o = angular.copy(data);
          for (i=0; i<dateFields.length; i++) {
            if (data.hasOwnProperty(dateFields[i])) {
              o[dateFields[i]] = filter('date')(data[dateFields[i]], strFormat);
            }
          }
          return $httpParamSerializerProvider.$get()(o);
        }
        return data;
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

    OAuthTokenProvider.configure({
      name: 'token',
      options: {
        secure: false
      }
    });

  }
]);

app.run(['$rootScope', '$window', 'OAuth', '$location', function($rootScope, $window, OAuth, $location) {
    $rootScope.$on('oauth:error', function(event, rejection) {
      // Ignore `invalid_grant` error - should be catched on `LoginController`.
      if ('invalid_grant' === rejection.data.error) {
        return;
      }

      // Refresh token when a `invalid_token` error occurs.
      if ('invalid_token' === rejection.data.error) {
        return OAuth.getRefreshToken();
      }

      // Redirect to `/login` with the `error_reason`.
      //$location.path('/login');
      //return $window.location.href = '/login';
      return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });
}]);


