angular.module('app.filters')
.filter('statusTask', function($filter) {
	return function(status) {
		if (status == 1)
			return "Incompleta";
		else 
			return "Completa"; 
	}
});
