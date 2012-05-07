function Observer() {
	this.observing = new Array();
	this.pes = new Array();
	this.id = 0;

	this.observe = function(observable, idcb) {
		var pe = new PeriodicalExecuter(function() {
			new Ajax.Request(observable.url, { // options
				method : 'get',
				asynchronous : true,
				requestHeaders : {
					'If-None-Match' : observable.etag
				},
				onSuccess : function(transport) {
					//actualizar etag
					observable.etag = transport.getHeader('Etag');
					
					// callback
					observable.cb(transport);
				},
				/* Nada alterado */
				on304 : function(){
					// Nada para fazer?
				},
				/* Tratamento de Falhas */
				onFailure : function() {
					alert("Erro em: "+observable.url);
				}
			});
		},10);
		
		// Adicionar a lista de pes
		this.pes.push({
			id : this.id,
			pe : pe
		});

		// Retorna/actualiza id
		idcb(this.id);
		this.id++;
	};

	this.stop = function(id) {
		for ( var i = 0; i < this.pes.length; i++) {
			if (this.pes[i].id == id) {
				this.pes[i].pe.stop();
				this.pes.splice(i, 1);
			} else
				continue;
		}
	};
}