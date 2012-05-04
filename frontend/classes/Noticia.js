/**
 * Classe que representa uma Notícia
 */
function Noticia() {
	
	/* Identificador unico da notícia */
	this.idnoticia = 0;
	
	/* Data de publicação da notícia */
	this.data_pub = "";
	
	/* Assunto da notícia */
	this.assunto = "";
	
	/* Descrição da notícia */
	this.descricao = "";
	
	/* URL da notícia */
	this.url = "";
	
	/* Qualificação da Notícia */
	this.qualificacao = 0;
	
	/* Array com locais das referências espaciais da notícia */
	this.locaisNoticias = new Array();
	
	/* Array com datas das referências espaciais da notícia */
	this.datasNoticias = new Array();
	
	/* Array com clubes presentes na notícia */
	this.clubesNoticias = new Array();
	
	/* Array com integrantes presentes na notícia */
	this.integrantesNoticias = new Array();
	
	/* URL para acesso ao recurso notícia do Web Service */
	this.baseurl = "http://localhost/AW3/webservice/noticias.php/";
	
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
	 * Recupera uma noticia especifica de acordo com o id passado como parâmetro.
	 * Necessita de função callback como parametro para devolver resultado
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
				  
				  /* Criação do objecto usando XML retornado */
				  var n = new Noticia();
				  n.idnoticia = idnoticiaDOMArray.item(0).firstChild.data;
				  n.data_pub = data_pubDOMArray.item(0).firstChild.data;
				  n.assunto = assuntoDOMArray.item(0).firstChild.data;
				  n.descricao = descricaoDOMArray.item(0).firstChild.data;
				  n.url = urlDOMArray.item(0).firstChild.data;
				  
				  /* Array de Locais das referencias espaciais da notícia */
				  var localDOMArray = xmlRoot.getElementsByTagName("Local");
				  if(localDOMArray != null) {
					  var myLocaisNoticias = new Array();
					  for(var j=0; j<localDOMArray.length;j++) {
							var l = new Local();
							l.idlocal = localDOMArray[j].getElementsByTagName("idlocal").item(0).firstChild.data;
							l.nome_local = localDOMArray[j].getElementsByTagName("nome_local").item(0).firstChild.data;
							l.coordenadas = localDOMArray[j].getElementsByTagName("coordenadas").item(0).firstChild.data;
							myLocaisNoticias[j] = l;
					  }
					  n.locaisNoticias = myLocaisNoticias;
				  }
				  //alert(n.locaisNoticias.length);
				  /* Array de Datas das referências temporais da notícia */
				  var dataDOMArray = xmlRoot.getElementsByTagName("data");
				  if(dataDOMArray != null) {
					  var myDatasNoticias = new Array();
					  for(var j=0; j<dataDOMArray.length;j++) {
							var d = dataDOMArray[j].firstChild.data;
							myDatasNoticias[j] = d;
					  }
					  n.datasNoticias = myDatasNoticias;
				  }
				  //alert(n.datasNoticias.length);
				  /* Array de Clubes das da notícia */
				  var clubeDOMArray = xmlRoot.getElementsByTagName("Clube");
				  var myClubesNoticias = new Array();
				  if(clubeDOMArray != null) {
					 
					  for(var j=0; j<clubeDOMArray.length;j++) {
							var c = new Clube();
							c.idclube = clubeDOMArray[j].getElementsByTagName("idclube").item(0).firstChild.data;
							c.nome_clube = clubeDOMArray[j].getElementsByTagName("nome_clube").item(0).firstChild.data;
							c.nome_oficial = clubeDOMArray[j].getElementsByTagName("nome_oficial").item(0).firstChild.data;
							n.qualificacao += Number(clubeDOMArray[j].getElementsByTagName("qualificacao").item(0).firstChild.data);
							myClubesNoticias[j] = c;
							
					  }
				  }
				  n.clubesNoticias = myClubesNoticias;
				  //alert(n.clubesNoticias.length);
				  /* Array de Integrantes das da notícia */
				  var integranteDOMArray = xmlRoot.getElementsByTagName("Integrante");
				  if(integranteDOMArray != null) {
					  var myIntegrantesNoticias = new Array();
					  for(var j=0; j<integranteDOMArray.length;j++) {
							var int = new Integrante();
							int.idintegrante = integranteDOMArray[j].getElementsByTagName("idintegrante").item(0).firstChild.data;
							int.nome_integrante = integranteDOMArray[j].getElementsByTagName("nome_integrante").item(0).firstChild.data;
							n.qualificacao += Number(integranteDOMArray[j].getElementsByTagName("qualificacao").item(0).firstChild.data);
							myIntegrantesNoticias[j] = int;
							
					  }
					  n.integrantesNoticias = myIntegrantesNoticias;
				  }
				  //alert(n.integrantesNoticias.length);
				  /* Retorno do objecto usando função callback passada como parametro */
				  cb(n);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ cb(null); }
		});
	};
}