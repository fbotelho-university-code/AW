/**
 * Classe que representa uma Not�cia
 */
function Noticia() {
	
	/* Identificador unico da not�cia */
	this.idnoticia = 0;
	
	/* Data de publica��o da not�cia */
	this.data_pub = "";
	
	/* Assunto da not�cia */
	this.assunto = "";
	
	/* Descri��o da not�cia */
	this.descricao = "";
	
	/* URL para acesso ao recurso not�cia do Web Service */
	this.baseurl = "http://localhost/proj/webservice/noticias.php/";
	
	/**
	 * Retorna um conjunto de Noticias
	 */
	this.getAllNoticias = function (start, count, cb) {
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
			      var idnoticiaDOMArray = xmlRoot.getElementsByTagName("idnoticia");
				  var data_pubDOMArray = xmlRoot.getElementsByTagName("data_pub");
				  var assuntoDOMArray = xmlRoot.getElementsByTagName("assunto");
				  var descricaoDOMArray = xmlRoot.getElementsByTagName("descricao");
				  var urlDOMArray = xmlRoot.getElementsByTagName("url");
				  
				  /* Armazena dados retornados em Arrays */ 
				  var noticias = new Array();
				  for(var i=0; i<idnoticiaDOMArray.length; i++) {
					  var n = new Noticia();
					  n.idnoticia = idnoticiaDOMArray.item(i).firstChild.data;
					  n.data_pub = data_pubDOMArray.item(i).firstChild.data;
					  n.assunto = assuntoDOMArray.item(i).firstChild.data;
					  n.descricao = descricaoDOMArray.item(i).firstChild.data;
					  n.url = urlDOMArray.item(i).firstChild.data;
					  noticias[i] = n;
				  }
				  //DEBUG
				  //alert("Success! \n\n" + noticias.length);
				  cb(noticias);
			    },
			    /* Tratamento de Falhas */
			    onFailure: function(){ alert("Erro ao recuperar 'Noticias' do webservice!"); }
			}
		);
	};
	
	/**
	 * Recupera uma noticia especifica de acordo com o id passado como par�metro.
	 * Necessita de fun��o callback como parametro para devolver resultado
	 */
	this.getNoticiaById = function (id, cb)
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
			      var idnoticiaDOMArray = xmlRoot.getElementsByTagName("idnoticia");
				  var data_pubDOMArray = xmlRoot.getElementsByTagName("data_pub");
				  var assuntoDOMArray = xmlRoot.getElementsByTagName("assunto");
				  var descricaoDOMArray = xmlRoot.getElementsByTagName("descricao");
				  var urlDOMArray = xmlRoot.getElementsByTagName("url");
				  
				  /* Cria��o do objecto usando XML retornado */
				  var n = new Noticia();
				  n.idnoticia = idnoticiaDOMArray.item(0).firstChild.data;
				  n.data_pub = data_pubDOMArray.item(0).firstChild.data;
				  n.assunto = assuntoDOMArray.item(0).firstChild.data;
				  n.descricao = descricaoDOMArray.item(0).firstChild.data;
				  n.url = urlDOMArray.item(0).firstChild.data;
				  
				  //DEBUG
			      //alert("Success! \n\n" + n.idnoticia);
				  
				  /* Retorno do objecto usando fun��o callback passada como parametro */
				  cb(n);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Noticia' do webservice!"); }
		});
	};
}