function Clube() {
	this.idclube;
	this.idlocal;
	this.idcompeticao;
	this.nome_clube;
	this.nome_oficial;
	
	/* URL base para comunicacao com o web service */
	this.baseurl = "http://localhost/proj/webservice/entidades.php/clube/";
	
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
			  var idlocalDOMArray = xmlRoot.getElementsByTagName("idlocal");
			  var idcompeticaoDOMArray = xmlRoot.getElementsByTagName("idcompeticao");
			  var nome_clubeDOMArray = xmlRoot.getElementsByTagName("nome_clube");
			  var nome_oficialDOMArray = xmlRoot.getElementsByTagName("nome_oficial");
			  
			  /* Armazena dados retornados em Arrays */ 
			  var clubes = new Array();
			  
			  for(var i=0; i<idclubeDOMArray.length; i++) {
			  	var c = new Clube();
				c.idclube = idclubeDOMArray.item(i).firstChild.data;
				c.idlocal = idlocalDOMArray.item(i).firstChild.data;
				c.idcompeticao = idcompeticaoDOMArray.item(i).firstChild.data;
				c.nome_clube = nome_clubeDOMArray.item(i).firstChild.data;
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
	
	this.getClubeById = function (id, cb)
	{
		
	};
	
	this.getClubeNoticias = function(id, cb)
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
		      
		      /* Recupera arrays com tags do XML retornado */
		      var idnoticiaDOMArray = xmlRoot.getElementsByTagName("idnoticia");
			  var data_pubDOMArray = xmlRoot.getElementsByTagName("data_pub");
			  var assuntoDOMArray = xmlRoot.getElementsByTagName("assunto");
			  var descricaoDOMArray = xmlRoot.getElementsByTagName("descricao");
			  
			  /* Armazena dados retornados em Arrays */ 
			  var noticias = new Array();
			  
			  for(var i=0; i<idnoticiaDOMArray.length; i++) {
			  	var c = new Noticia();
				c.idnoticia = idnoticiaDOMArray.item(i).firstChild.data;
				c.data_pub = data_pubDOMArray.item(i).firstChild.data;
				c.assunto = assuntoDOMArray.item(i).firstChild.data;
				c.descricao = descricaoDOMArray.item(i).firstChild.data;
			  	noticias[i] = c;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  cb(noticias);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar noticias do clube!"); }
		});		
	}
	
	this.getClubeCountNoticias = function(id, cb)
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