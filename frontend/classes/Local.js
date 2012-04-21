function Local() {
	this.idlocal;
	this.nome_local;
	this.coordenadas;
	
	this.getAllLocais = function (cb) 
	{
		new Ajax.Request('http://localhost/AW3/webservice/espaco.php/',
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
			  
			  for(var i=0; i<idlocalDOMArray.length; i++) {
			  	var l = new Local();
				l.idlocal = idlocalDOMArray.item(i).firstChild.data;
				l.nome_local = nome_localDOMArray.item(i).firstChild.data;
			  	l.coordenadas = coordenadasDOMArray.item(i).firstChild.data;
			  	locais[i] = l;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  cb(locais);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Locais' do webservice!"); }
		});
	};
}