function Integrante() {
	
	/** Identificador único do integrante **/
	this.idintegrante = 0;
	
	/** Identificador único do clube do integrante **/
	this.idclube = 0;
	
	/** Nome do integrante **/
	this.nome_integrante = "";
	
	/** Função do Integrante no clube 8jogador, presudente, guarda-redes, etc.) **/
	this.funcao = "";
	
	/** URL base para acesso ao recurso integrante no Web Service **/
	this.baseurl = "http://localhost/AW3/webservice/entidades.php/integrante/";
	
	this.url_img = "";
	
	/**
	 * Recupera todos os integrantes
	 */
	this.getAllIntegrantes = function (start, count, cb) 
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
		      var idintegranteDOMArray = xmlRoot.getElementsByTagName("idintegrante");
			  var idclubeDOMArray = xmlRoot.getElementsByTagName("idclube");
			  var nome_integranteDOMArray = xmlRoot.getElementsByTagName("nome_integrante");
			  
			  /* Armazena dados retornados em Arrays */ 
			  var integrantes = new Array();
			  
			  for(var i=0; i<idintegranteDOMArray.length; i++) {
			  	var integ = new Integrante();
				integ.idintegrante = idintegranteDOMArray.item(i).firstChild.data;
				integ.idclube = idclubeDOMArray.item(i).firstChild.data;
				integ.nome_integrante = nome_integranteDOMArray.item(i).firstChild.data;
			  	integrantes[i] = integ;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  cb(integrantes);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Integrantes' do webservice!"); }
		});
	};
	
	/**
	 * Recupera um integrante especifico de acordo com um id passado cmo parâmetro
	 */
	this.getIntegranteById = function (id, cb) 
	{
		var url = this.baseurl + id;
		
		new Ajax.Request(url,
		{
		    method:'get',
		    asynchronous: false,
		    onSuccess: function(transport){
		      /* Recebimento da resposta */
		      var response = transport.responseXML;
		      var xmlRoot = response.documentElement;
		      
		      /* Recupera arrays com tags do XML retornado */
		      var idintegranteDOMArray = xmlRoot.getElementsByTagName("idintegrante");
			  var idclubeDOMArray = xmlRoot.getElementsByTagName("idclube");
			  var nome_integranteDOMArray = xmlRoot.getElementsByTagName("nome_integrante");
			  		  
			  	var integ = new Integrante();
				integ.idintegrante = idintegranteDOMArray.item(0).firstChild.data;
				integ.idclube = idclubeDOMArray.item(0).firstChild.data;
				integ.nome_integrante = nome_integranteDOMArray.item(0).firstChild.data;
			  	integrantes[i] = integ;
			  
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  cb(integ);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Integrante' do webservice!"); }
		});
	};
	
	/**
	 * Recupera um integrante especifico de acordo com o nome passado como parâmetro.
	 * Necessita de função callback como parametro para devolver resultado
	 */
	this.getIntegranteByNome = function (nome, cb)
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
			      var idintegranteDOMArray = xmlRoot.getElementsByTagName("idintegrante");
				  var idclubeDOMArray = xmlRoot.getElementsByTagName("idclube");
				  var nome_integranteDOMArray = xmlRoot.getElementsByTagName("nome_integrante");
				  
				  /* Armazena dados retornados em Arrays */ 
				  var integrantes = new Array();
				  
				  for(var i=0; i<idintegranteDOMArray.length; i++) {
				  	var integ = new Integrante();
					integ.idintegrante = idintegranteDOMArray.item(i).firstChild.data;
					integ.idclube = idclubeDOMArray.item(i).firstChild.data;
					integ.nome_integrante = nome_integranteDOMArray.item(i).firstChild.data;
				  	integrantes[i] = integ;
				  }
				  //DEBUG
			      //alert("Success! \n\n" + clubes.length);
				  cb(integrantes);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ cb(null); }
		});
	};
	
	/**
	 * Recupera as notícias de integrante especifico de acordo com um id passado por parametro
	 * Necessita de função callback como parametro para devolver resultado
	 */
	this.getNoticiasByIdIntegrante = function (id, cb)
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
				  var noticiasIntegrante = new Array();
				  
				  for(var i=0; i<idnoticiaDOMArray.length; i++) {
					  var n = new Noticia();
					  n.idnoticia = idnoticiaDOMArray.item(i).firstChild.data;
					  n.data_pub = data_pubDOMArray.item(i).firstChild.data;
					  n.assunto = assuntoDOMArray.item(i).firstChild.data;
					  n.descricao = descricaoDOMArray.item(i).firstChild.data;
					  noticiasIntegrante[i] = n;
				  }	  
				  //DEBUG
			      //alert("Success! \n\n" + l);
						  
				  /* Retorno do objecto usando função callback passada como parametro */
				  cb(noticiasIntegrante);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ cb(null); }
		});
	};
}

var baseurlIntegrantes = "http://localhost/AW3/webservice/entidades.php/integrante/";
var allIntegrantes = new Array();
var nome_integranteArray = new Array();
var img_integrantes = new Array();
var id_integrantes = new Array();

function getAllIntegrantes (start, count) 
{
	var params = "";
	if(start != 0 && count != 0) {
		params = "?start=" + start + "&count=" + count;
	}
	var url = baseurlIntegrantes + params;
	
	new Ajax.Request(url,
	{
	    method:'get',
	    asynchronous: false,
	    onSuccess: function(transport){
	      /* Recebimento da resposta */
	      var response = transport.responseXML;
	      var xmlRoot = response.documentElement;
	      
	      var nome_integranteDOMArray = xmlRoot.getElementsByTagName("nome_integrante");
	      var img_integrantesDOMArray = xmlRoot.getElementsByTagName("url_img");
	      var id_integrantesDOMArray = xmlRoot.getElementsByTagName("idintegrante");
	      
	      for(var i=0; i<nome_integranteDOMArray.length; i++) {
	    	  nome_integranteArray[i] = nome_integranteDOMArray.item(i).firstChild.data;
	    	  id_integrantes[i] = id_integrantesDOMArray.item(i).firstChild.data;
	    	  if(img_integrantesDOMArray.item(i).firstChild != null) {
	    		  img_integrantes[i] = img_integrantesDOMArray.item(i).firstChild.data;
			  }
			  else{
				  img_integrantes[i] = "css/images/jogador_default.jpg";
			  }
		  }
		  //DEBUG
	      //alert("Antes Integrante \n\n" + nomes_pesquisa.length);
	      nomes_pesquisa = nomes_pesquisa.concat(nome_clubeArray);
	      //alert("Depois Integrante \n\n" + img_integrantes.length);
		  
	    },
	    /* Tratamento de Falhas */
	    onFailure: function(){ alert("Erro ao recuperar 'Integrantes' do webservice!"); }
	});
};