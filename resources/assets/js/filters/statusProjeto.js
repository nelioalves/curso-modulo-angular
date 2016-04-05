angular.module('app.filters')
.filter('statusProjeto', function($filter) {
	return function(project) {
		var hoje = new Date();
		var vet = project.due_date.split('-');
        var month = parseInt(vet[1])-1;
        var data_projeto = new Date(vet[0], month, vet[2]);
		//console.log(data_projeto + ": " + hoje); // IMPRIME O TRIPO DE VEZES!?!?!?
		if (project.status != 3 && data_projeto < hoje)
			return "Atrasado";
		else {
			if (project.status == 1)
				return "Não iniciado";
			else if (project.status == 2)
				return "Iniciado";
			else 
				return "Concluído";
		} 
	}
});
