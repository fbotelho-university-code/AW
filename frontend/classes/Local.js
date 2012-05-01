/**
 * Classe que representa uma referencia espacial de uma not�cia.
 */

function Local() {
	this.idlocal;
	this.nome_local;
	this.coordenadas;
	
	/* URL base para comunicacao com o web service */
	this.baseurl = "http://localhost/proj/webservice/espaco.php/";
	
	/**
	 * M�todo para recuperar todos os locais.
	 * Necessita de fun��o callback como parametro para devolver resultado
	 */
	this.getAllLocais = function (start, count, cb) 
	{
		var params = "";
		if(start != 0 && count != 0) {
			params = "?start=" + start + "&count=" + count;
		}
		var url = this.baseurl + params;
		
		new Ajax.Request(url,
		{
		    method:'get',
		    asynchronous: false,
		    onSuccess: function(transport){
		      /* Recebimento da resposta */
		      var response = transport.responseXML;
		      var xmlRoot = response.documentElement;
		      
		      /* Recupera arrays com tags do XML retornado */
		      var idlocalDOMArray = xmlRoot.getElementsByTagName("idlocal");
			  var nome_localDOMArray = xmlRoot.getElementsByTagName("nome_local");
			  var coordenadasDOMArray = xmlRoot.getElementsByTagName("coordenadas");
			  
			  /* Armazena dados retornados em Array */ 
			  var locais = new Array();
			  
			  /* Constru���o dos objectos e armazenamento no Array de retorno */
			  for(var i=0; i<idlocalDOMArray.length; i++) {
			  	var l = new Local();
				l.idlocal = idlocalDOMArray.item(i).firstChild.data;
				l.nome_local = nome_localDOMArray.item(i).firstChild.data;
			  	l.coordenadas = coordenadasDOMArray.item(i).firstChild.data;
			  	locais[i] = l;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  
			  /* Retorno do array de objectos usando fun��o callback passada como par�metro */
			  cb(locais);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Locais' do webservice!"); }
		});
	};
	
	/**
	 * Recupera um local especifico de acordo com o id passado como par�metro.
	 * Necessita de fun��o callback como parametro para devolver resultado
	 */
	this.getLocalById = function (id, cb)
	{
		var url = this.baseurl + id;
		new Ajax.Request(url,
		{
			method: 'get',
			asynchronous: false,
			onSuccess: function(transport){
				/* Recebimento da resposta */
			      var response = transport.responseXML;
			      var xmlRoot = response.documentElement;
			      
			      /* Recupera arrays com tags do XML retornado */
			      var idlocalDOMArray = xmlRoot.getElementsByTagName("idlocal");
				  var nome_localDOMArray = xmlRoot.getElementsByTagName("nome_local");
				  var coordenadasDOMArray = xmlRoot.getElementsByTagName("coordenadas");
				  
				  /* Cria��o do objecto usando XML retornado */
				  var l = new Local();
				  l.idlocal = idlocalDOMArray.item(0).firstChild.data;
				  l.nome_local = nome_localDOMArray.item(0).firstChild.data;
				  l.coordenadas = coordenadasDOMArray.item(0).firstChild.data;
				  
				  //DEBUG
			      //alert("Success! \n\n" + l);
				  
				  /* Retorno do objecto usando fun��o callback passada como parametro */
				  cb(l);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Local' do webservice!"); }
		});
	};
	
	this.getLocalCountNoticias = function(id, cb)
	{
		var url = this.baseurl + id + '/noticias';
		
		new Ajax.Request(url,
		{
		    method:'get',
		    asynchronous: false,
		    onSuccess: function(transport){
		      /* Recebimento da resposta */
		      var response = transport.responseXML;
		      var xmlRoot = response.documentElement;
		      
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  cb(xmlRoot.getElementsByTagName("idnoticia").length);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar noticias do clube!"); }
		});		
	}
}