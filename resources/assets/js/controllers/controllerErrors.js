var checkServiceError = function(obj) {
	if (obj.hasOwnProperty('error') && obj.error==true) {
    	alert(obj.message);
    	history.back();
    	return true;
	}			
	return false;
};


