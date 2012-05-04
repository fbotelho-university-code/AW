/**
 * Classe que representa uma referencia espacial de uma notícia.
 */

function Local() {
	this.idlocal;
	this.nome_local;
	this.coordenadas;
	
	this.noticias = new Array();
	
	/* URL base para comunicacao com o web service */
	this.baseurl = "http://localhost/AW3/webservice/espaco.php/";
	
	/**
	 * Método para recuperar todos os locais.
	 * Necessita de função callback como parametro para devolver resultado
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
			  
			  /* Construçção dos objectos e armazenamento no Array de retorno */
			  for(var i=0; i<idlocalDOMArray.length; i++) {
			  	var l = new Local();
				l.idlocal = idlocalDOMArray.item(i).firstChild.data;
				l.nome_local = nome_localDOMArray.item(i).firstChild.data;
			  	l.coordenadas = coordenadasDOMArray.item(i).firstChild.data;
			  	locais[i] = l;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  
			  /* Retorno do array de objectos usando função callback passada como parâmetro */
			  cb(locais);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Locais' do webservice!"); }
		});
	};
	
	/**
	 * Recupera um local especifico de acordo com o id passado como parâmetro.
	 * Necessita de função callback como parametro para devolver resultado
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
				  
				  /* Criação do objecto usando XML retornado */
				  var l = new Local();
				  l.idlocal = idlocalDOMArray.item(0).firstChild.data;
				  l.nome_local = nome_localDOMArray.item(0).firstChild.data;
				  l.coordenadas = coordenadasDOMArray.item(0).firstChild.data;
				  
				  //DEBUG
			      //alert("Success! \n\n" + l);
				  
				  /* Retorno do objecto usando função callback passada como parametro */
				  cb(l);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Local' do webservice!"); }
		});
	};
	
	/**
	 * Recupera um local especifico de acordo com o nome passado como parâmetro.
	 * Necessita de função callback como parametro para devolver resultado
	 */
	this.getLocalByNome = function (nome, cb)
	{
		var url = this.baseurl + nome;
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
				  
				  /* Armazena dados retornados em Array */ 
				  var locais = new Array();
				  
				  /* Construçção dos objectos e armazenamento no Array de retorno */
				  for(var i=0; i<idlocalDOMArray.length; i++) {
				  	var l = new Local();
					l.idlocal = idlocalDOMArray.item(i).firstChild.data;
					l.nome_local = nome_localDOMArray.item(i).firstChild.data;
				  	l.coordenadas = coordenadasDOMArray.item(i).firstChild.data;
				  	locais[i] = l;
				  }
				  //DEBUG
			      //alert("Success! \n\n" + clubes.length);
				  
				  /* Retorno do array de objectos usando função callback passada como parâmetro */
				  cb(locais);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ cb(null); }
		});
	};
	
	/**
	 * Recupera as notícias de local especifico de acordo com um id passado por parametro
	 * Necessita de função callback como parametro para devolver resultado
	 */
	this.getNoticiasLocal = function (id, cb)
	{
		var url = this.baseurl + id + "/noticias";
		new Ajax.Request(url,
		{
			method: 'get',
			asynchronous: false,
			onSuccess: function(transport){
				/* Recebimento da resposta */
			      var response = transport.responseXML;
			      var xmlRoot = response.documentElement;
					      
			      /* Recupera arrays com tags do XML retornado */
			      var idnoticiaDOMArray = xmlRoot.getElementsByTagName("idnoticia");
				  var data_pubDOMArray = xmlRoot.getElementsByTagName("data_pub");
				  var assuntoDOMArray = xmlRoot.getElementsByTagName("assunto");
				  var descricaoDOMArray = xmlRoot.getElementsByTagName("descricao");
						  
				  /* Criação de um array para armazenar os dados retornados */ 
				  var noticiasLocal = new Array();
				  
				  for(var i=0; i<idnoticiaDOMArray.length; i++) {
					  var n = new Noticia();
					  n.idnoticia = idnoticiaDOMArray.item(i).firstChild.data;
					  n.data_pub = data_pubDOMArray.item(i).firstChild.data;
					  n.assunto = assuntoDOMArray.item(i).firstChild.data;
					  n.descricao = descricaoDOMArray.item(i).firstChild.data;
					  noticiasLocal[i] = n;
				  }	  
				  //DEBUG
			      //alert("Success! \n\n" + l);
						  
				  /* Retorno do objecto usando função callback passada como parametro */
				  cb(noticiasLocal);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'NoticiasLocal' do webservice!"); }
		});
	};
}