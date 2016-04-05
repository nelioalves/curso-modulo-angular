<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>
	@if(Config::get('app.debug'))
		<link href="{{ asset('build/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('build/css/flaticon.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('build/css/components.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('build/css/app.css') }}" rel="stylesheet" type="text/css">
	@else
		<link href="{{ elixir('css/all.css') }}" rel="stylesheet" type="text/css">
	@endif

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	<load-template url="build/views/templates/menu.html"></load-template>

	<div ng-view></div>

	<!-- Scripts -->
	@if(Config::get('app.debug'))
		<script src="{{ asset('build/js/vendor/jquery.min.js') }}" type="text/javascript"></script>
		<script>var $jQuery = jQuery.noConflict();</script>

		<script src="{{ asset('build/js/vendor/angular.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-route.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-resource.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-animate.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-messages.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/ui-bootstrap-tpls.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/navbar.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-cookies.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/query-string.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-oauth2.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/ng-file-upload.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/http-auth-interceptor.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/dirPagination.js') }}" type="text/javascript"></script>

		<script src="{{ asset('build/js/app.js') }}" type="text/javascript"></script>

		<!-- CONTROLLERS -->
		<script src="{{ asset('build/js/controllers/controllerErrors.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/home.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/menu.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/login.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/loginModal.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/clientController.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/projectController.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/projectNoteController.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/projectFileController.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/projectTaskController.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/projectMemberController.js') }}" type="text/javascript"></script>

		<script src="{{ asset('build/js/controllers/ui-datepicker.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/ui-typeahead.js') }}" type="text/javascript"></script>

		<!-- DIRECTIVES -->
		<script src="{{ asset('build/js/directives/showStatus.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/directives/loadTemplate.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/directives/loginForm.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/directives/projectFileDownload.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/directives/menu-activated.js') }}" type="text/javascript"></script>

		<!-- FILTERS -->
		<script src="{{ asset('build/js/filters/dateBr.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/filters/incompletas.js') }}" type="text/javascript"></script>

		<!-- SERVICES -->
		<script src="{{ asset('build/js/services/oauthFixInterceptor.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/url.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/user.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/client.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/client2.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/project.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/projectNote.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/projectFile.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/projectTask.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/projectMember.js') }}" type="text/javascript"></script>

	@else
		<script src="{{ elixir('js/all.js') }}" type="text/javascript"></script>
	@endif
</body>
</html>
