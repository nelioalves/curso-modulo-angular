var checkServiceError = function(obj) {
	if (angular.isObject(obj) && obj.hasOwnProperty('error') && obj.error==true) {
    	alert(obj.message);
    	return true;
	}			
	return false;
};
