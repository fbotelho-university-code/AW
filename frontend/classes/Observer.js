function Observer() {
	this.observing = new Array();
	this.pes = new Array();
	this.id = 0;

	this.observe = function(observable, idcb) {
		this.observing.push(observable);
		var pe = new PeriodicalExecuter(this.get(observable));
		pes.push({
			id : id,
			pe : pe
		});

		idcb(id);
		id++;
	};

	this.stop = function(id) {
		for ( var i = 0; i < pes.length; i++) {
			if (pes[i].id == id) {
				pes[i].pe.stop();
				pes.splice(i, 1);
			} else
				continue;
		}
	};

	this.get = function(obs) {
		new Ajax.Request(obs.url, { // options
			method : 'get',
			asynchronous : true,
			requestHeaders : {
				'If-None-Match' : obs.etag
			},
			onSuccess : function(transport) {
				// callback
				obs.cb(transport);
			},
			/* Tratamento de Falhas */
			on304 : function(){
				console.log('nada alterado');
			},
			onFailure : function() {
				alert("Erro ao recuperar 'Clubes' do webservice!");
			}
		});
	};
}