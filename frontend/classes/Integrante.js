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

function getIntegranteByNome(nome)
{
	var locaisEncontrados = new Array();
	
	var url = baseurlIntegrantes + nome;
	new Ajax.Request(url,
	{
		method: 'get',
		asynchronous: true,
		onSuccess: function(transport)
		{
			/* Recebimento da resposta */
			var response = transport.responseXML;
			var xmlRoot = response.documentElement;

			var noticiaDOMArray = xmlRoot.getElementsByTagName("Noticia");
			for(var i=0; i<noticiaDOMArray.length; i++) {
				var n = new Noticia();
				n.idnoticia = noticiaDOMArray.item(i).getElementsByTagName("idnoticia").item(0).firstChild.data;
				n.data_pub = noticiaDOMArray.item(i).getElementsByTagName("data_pub").item(0).firstChild.data;
				n.assunto = noticiaDOMArray.item(i).getElementsByTagName("assunto").item(0).firstChild.data;
				//console.log("Noticia: " + n.idnoticia);
				var locaisNoticia = noticiaDOMArray.item(i).getElementsByTagName("Local");
				//console.log("Locais nesta noticia: " + locaisNoticia.length);
				for(var j=0; j<locaisNoticia.length; j++) {
					var l = new Local();
					var idlocal = locaisNoticia[j].getElementsByTagName("idlocal").item(0).firstChild.data;
					var flag = false;
					for(var aux=0; aux<locaisEncontrados.length; aux++) {
						if(locaisEncontrados[aux].idlocal == idlocal) {
							locaisEncontrados[aux].noticias.push(n);
							//console.log("Entrei no if-flag com local " + idlocal);
							flag = true;
						}
					}
					if(!flag) {
						//console.log("Entrei em !flag com " + idlocal);
						l.idlocal = idlocal;
						l.nome_local = locaisNoticia[j].getElementsByTagName("nome_local").item(0).firstChild.data;
						l.lat = locaisNoticia[j].getElementsByTagName("lat").item(0).firstChild.data;
						l.log = locaisNoticia[j].getElementsByTagName("log").item(0).firstChild.data;
						l.noticias.push(n);
						locaisEncontrados.push(l);
					}
				}
			}
			//alert(locaisEncontrados.length);
			for(var k=0; k<locaisEncontrados.length; k++) {
				local = new google.maps.LatLng(parseFloat(locaisEncontrados[k].lat), parseFloat(locaisEncontrados[k].log));
				nome_local = locaisEncontrados[k].nome_local;
				marker = new google.maps.Marker({
					position: local,
					title: nome_local,
					map: map
				});
				markersArray.push(marker);
				var infoWindow = new google.maps.InfoWindow;
				var contentString = "<div id='infoMarker'>";
				contentString += "<h2><center>Notícias em " + nome_local + "</center></h2>";
				contentString +=  "<table id='infoMarker-t'><thread>";
				contentString += "<tr><th>Data de Publicação</th>";
				contentString += "<th>Assunto</th></tr></thread>";
				contentString += "<tbody>";

				noticiasL = locaisEncontrados[k].noticias;
				for(var b=0; b<noticiasL.length;b++) {
					var dataAux = noticiasL[b].data_pub.substring(0,11);
					contentString += "<tr><td>" + dataAux +  "</td>";
					contentString += "<td><a href='javascript: void 0' onclick=showQuadroNoticia("+noticiasL[b].idnoticia+")>" + noticiasL[b].assunto +  "</a></td></tr>";
				}
				contentString +=  "</tbody></table>";
				contentString +=  "</div>";

				google.maps.event.addListener(marker, 'click', function(content) {
					return function() {
						infoWindow.setContent(content);
						infoWindow.open(map,this);
					}
				}(contentString));
			}
	},
	//DEBUG

	/* Tratamento de Falhas */
	onFailure: function(){ return null; }
	//alert("Success! \n\n" + clubes.length);
		
	});
}