angular.module('app.directives')
.directive('corAlerta', 
function(status){
	if (status == 1)
		return "text-danger status";
	else 
		return "text-default status";
});
