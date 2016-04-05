angular.module('app.filters')
.filter('incompletas', function($filter) {
	return function(input) {
		var list = [];
		angular.forEach(input, function(x) {
			if (x.status == 1) {
				list.push(x);
			}
		});
		return list;
	}
});
