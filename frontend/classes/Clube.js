function Clube() {
	this.idclube;
	this.idlocal;
	this.idcompeticao;
	this.nome_clube;
	this.nome_oficial;
	this.url_img;
	
	/* URL base para comunicacao com o web service */
	this.baseurl = "http://localhost/AW3/webservice/entidades.php/clube/";
	
	this.getAllClubes = function (start, count, cb) 
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
		      var idclubeDOMArray = xmlRoot.getElementsByTagName("idclube");
			  var nome_oficialDOMArray = xmlRoot.getElementsByTagName("nome_oficial");
			  
			  /* Armazena dados retornados em Arrays */ 
			  var clubes = new Array();
			  
			  for(var i=0; i<idclubeDOMArray.length; i++) {
			  	var c = new Clube();
				c.idclube = idclubeDOMArray.item(i).firstChild.data;
				c.nome_oficial = nome_oficialDOMArray.item(i).firstChild.data;
			  	clubes[i] = c;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  cb(clubes);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Clubes' do webservice!"); }
		});
	};
	
	/**
	 * Recupera um clube especifico de acordo com o nome passado como parâmetro.
	 * Necessita de função callback como parametro para devolver resultado
	 */
	this.getClubeByNome = function (nome, cb)
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
			      var idclubeDOMArray = xmlRoot.getElementsByTagName("idclube");
				  var idlocalDOMArray = xmlRoot.getElementsByTagName("idlocal");
				  var idcompeticaoDOMArray = xmlRoot.getElementsByTagName("idcompeticao");
				  var nome_clubeDOMArray = xmlRoot.getElementsByTagName("nome_clube");
				  var nome_oficialDOMArray = xmlRoot.getElementsByTagName("nome_oficial");
				  
				  /* Armazena dados retornados em Arrays */ 
				  var clubes = new Array();
				  
				  for(var i=0; i<idclubeDOMArray.length; i++) {
				  	var cl = new Clube();
					cl.idclube = idclubeDOMArray.item(i).firstChild.data;
					cl.idlocal = idlocalDOMArray.item(i).firstChild.data;
					cl.idcompeticao = idcompeticaoDOMArray.item(i).firstChild.data;
					cl.nome_clube = nome_clubeDOMArray.item(i).firstChild.data;
					cl.nome_oficial = nome_oficialDOMArray.item(i).firstChild.data;
				  	clubes[i] = cl;
				  }
				  //DEBUG
			      //alert("Success! \n\n" + clubes.length);
				  cb(clubes);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ cb(null); }
		});
	};
	
	/**
	 * Recupera as notícias de clube especifico de acordo com um id passado por parametro
	 * Necessita de função callback como parametro para devolver resultado
	 */
	this.getNoticiasByIdClube = function (id, cb)
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
				  var noticiasClube = new Array();
				  
				  for(var i=0; i<idnoticiaDOMArray.length; i++) {
					  var n = new Noticia();
					  n.idnoticia = idnoticiaDOMArray.item(i).firstChild.data;
					  n.data_pub = data_pubDOMArray.item(i).firstChild.data;
					  n.assunto = assuntoDOMArray.item(i).firstChild.data;
					  n.descricao = descricaoDOMArray.item(i).firstChild.data;
					  noticiasClube[i] = n;
				  }	  
				  //DEBUG
			      //alert("Success! \n\n" + noticiasClube.length);
						  
				  /* Retorno do objecto usando função callback passada como parametro */
				  cb(noticiasClube);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ cb(null); }
		});
	}
}

var baseurlClubes = "http://localhost/AW3/webservice/entidades.php/clube/";
var allClubes = new Array();
var nome_clubeArray = new Array();
var img_clubes = new Array();
var id_clubes = new Array();

function getAllClubes(start, count) 
{
	var params = "";
	if(start != 0 && count != 0) {
		params = "?start=" + start + "&count=" + count;
	}
	var url = baseurlClubes + params;
	
	new Ajax.Request(url,
	{
	    method:'get',
	    asynchronous: false,
	    onSuccess: function(transport){
	      /* Recebimento da resposta */
	      var response = transport.responseXML;
	      var xmlRoot = response.documentElement;
	      
	      var nome_oficialDOMArray = xmlRoot.getElementsByTagName("nome_oficial");
	      var img_clubesDOMArray = xmlRoot.getElementsByTagName("url_img");
	      var id_clubesDOMArray = xmlRoot.getElementsByTagName("idclube");
	      
	      for(var i=0; i<nome_oficialDOMArray.length; i++) {
			  nome_clubeArray[i] = nome_oficialDOMArray.item(i).firstChild.data;
			  id_clubes[i] = id_clubesDOMArray.item(i).firstChild.data;
			 if(img_clubesDOMArray.item(i).firstChild != null) {
				  img_clubes[i] = img_clubesDOMArray.item(i).firstChild.data;
			  }
			  else{
				  img_clubes[i] = "css/images/escudo_default.JPG";
			  }
		  }
		  //alert("Antes Clube \n\n" + nomes_pesquisa.length);
		  nomes_pesquisa = nomes_pesquisa.concat(nome_clubeArray);
		  //DEBUG
	      //alert("Depois Clube \n\n" + img_clubes.length);
		  
	    },
	    /* Tratamento de Falhas */
	    onFailure: function(){ alert("Erro ao recuperar 'Clubes' do webservice!"); }
	});
};