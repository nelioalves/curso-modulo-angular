angular.module('app.filters')
.filter('dateBr', function($filter) {
	return function(input) {
		return $filter('date')(input, 'dd/MM/yyyy');
	}
});
