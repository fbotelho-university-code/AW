/**
 * Classe que representa uma referencia espacial de uma notï¿½cia.
 */

function Local() {
	this.idlocal;
	this.nome_local;
	this.lat;
	this.log;
	
	this.noticias = new Array();
	
	/* URL base para comunicacao com o web service */
	this.baseurl = "http://localhost/AW3/webservice/espaco.php/";

	/**
	 * Mï¿½todo para recuperar todos os locais.
	 * Necessita de funï¿½ï¿½o callback como parametro para devolver resultado
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
			  
			  /* Construï¿½ï¿½ï¿½o dos objectos e armazenamento no Array de retorno */
			  for(var i=0; i<idlocalDOMArray.length; i++) {
			  	var l = new Local();
				l.idlocal = idlocalDOMArray.item(i).firstChild.data;
				l.nome_local = nome_localDOMArray.item(i).firstChild.data;
			  	l.coordenadas = coordenadasDOMArray.item(i).firstChild.data;
			  	locais[i] = l;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  
			  /* Retorno do array de objectos usando funï¿½ï¿½o callback passada como parï¿½metro */
			  cb(locais);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Locais' do webservice!"); }
		});
	};
	
	/**
	 * Recupera um local especifico de acordo com o id passado como parï¿½metro.
	 * Necessita de funï¿½ï¿½o callback como parametro para devolver resultado
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
				  
				  /* Criaï¿½ï¿½o do objecto usando XML retornado */
				  var l = new Local();
				  l.idlocal = idlocalDOMArray.item(0).firstChild.data;
				  l.nome_local = nome_localDOMArray.item(0).firstChild.data;
				  l.coordenadas = coordenadasDOMArray.item(0).firstChild.data;
				  
				  //DEBUG
			      //alert("Success! \n\n" + l);
				  
				  /* Retorno do objecto usando funï¿½ï¿½o callback passada como parametro */
				  cb(l);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Local' do webservice!"); }
		});
	};
	
	/**
	 * Recupera um local especifico de acordo com o nome passado como parï¿½metro.
	 * Necessita de funï¿½ï¿½o callback como parametro para devolver resultado
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
				  
				  /* Construï¿½ï¿½ï¿½o dos objectos e armazenamento no Array de retorno */
				  for(var i=0; i<idlocalDOMArray.length; i++) {
				  	var l = new Local();
					l.idlocal = idlocalDOMArray.item(i).firstChild.data;
					l.nome_local = nome_localDOMArray.item(i).firstChild.data;
				  	l.coordenadas = coordenadasDOMArray.item(i).firstChild.data;
				  	locais[i] = l;
				  }
				  //DEBUG
			      //alert("Success! \n\n" + clubes.length);
				  
				  /* Retorno do array de objectos usando funï¿½ï¿½o callback passada como parï¿½metro */
				  cb(locais);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ cb(null); }
		});
	};
	
	/**
	 * Recupera as notï¿½cias de local especifico de acordo com um id passado por parametro
	 * Necessita de funï¿½ï¿½o callback como parametro para devolver resultado
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
						  
				  /* Criaï¿½ï¿½o de um array para armazenar os dados retornados */ 
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
						  
				  /* Retorno do objecto usando funï¿½ï¿½o callback passada como parametro */
				  cb(noticiasLocal);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'NoticiasLocal' do webservice!"); }
		});
	};
}


var baseurlLocais = "http://localhost/AW3/webservice/espaco.php/";
var allLocais = new Array();
var nome_localArray = new Array();
var id_localArray = new Array();

function getAllLocais(start, count) {
	
	var params = "";
	if(start != 0 && count != 0) {
		params = "?start=" + start + "&count=" + count;
	}
	var url =  baseurlLocais + params;
	
	new Ajax.Request(url,
	{
	    method:'get',
	    asynchronous: false,
	    onSuccess: function(transport){
	      /* Recebimento da resposta */
	      var response = transport.responseXML;
	      var xmlRoot = response.documentElement;
	      
	      var nome_localDOMArray = xmlRoot.getElementsByTagName("nome_local");
	      var id_localDOMArray = xmlRoot.getElementsByTagName("idlocal");
		  
	      for(var i=0; i<nome_localDOMArray.length; i++) {
		  	nome_localArray[i] = nome_localDOMArray.item(i).firstChild.data;
		  	id_localArray[i] = id_localDOMArray.item(i).firstChild.data;
		  }
	      //alert("Antes Local \n\n" + nomes_pesquisa.length);
		  nomes_pesquisa = nomes_pesquisa.concat(nome_localArray);
		  //DEBUG
	      //alert("Depois Local \n\n" + nomes_pesquisa.length);
	    },
	    /* Tratamento de Falhas */
	    onFailure: function(){ alert("Erro ao recuperar 'Locais' do webservice!"); }
	});
}



function getLocaisNoticiasByCoordenadas(lat_1, lat_2, log_1, log_2) {
	
	var url = baseurlLocais + lat_1 + "/" + lat_2 + "/" + log_1 + "/" + log_2;
	var count = "?count=15";
	url += count;
	//alert(url);
	new Ajax.Request(url,
	{
		method:'get',
		asynchronous: true,
		onSuccess: function(transport){
			/* Recebimento da resposta */
			var response = transport.responseXML;
			var xmlRoot = response.documentElement;
			
			/* Recupera arrays com tags do XML retornado */
			var localDOMArray = xmlRoot.getElementsByTagName("Local");
			for(var i=0; i<localDOMArray.length; i++) {
				var idlocal = localDOMArray.item(i).getElementsByTagName("idlocal").item(0).firstChild.data;
				var nome_local = localDOMArray.item(i).getElementsByTagName("nome_local").item(0).firstChild.data;
				var lat = localDOMArray.item(i).getElementsByTagName("lat").item(0).firstChild.data;
				var log = localDOMArray.item(i).getElementsByTagName("log").item(0).firstChild.data;
				var noticiasArray = localDOMArray.item(i).getElementsByTagName("noticias");
				
				//TODO
				// Retirar apï¿½s acerto no WebService
				if(noticiasArray.length != 0) {
					local = new google.maps.LatLng(parseFloat(lat), parseFloat(log));
					//alert(data + "\n\nNoticia: " + idnoticia + "\n\nLocal: " + lat + "," + log);
					
					marker = new google.maps.Marker({
						position: local,
						title: nome_local,
						map: map
					});
					markersArray.push(marker);
					var infoWindow = new google.maps.InfoWindow;
					var contentString = "<div id='infoMarker'>";
		  			contentString += "<h2><center>Noticias em " + nome_local + "</center></h2>";
		  			contentString +=  "<table id='infoMarker-t'><thread>";
		  			contentString += "<tr><th>Data Pub</th>";
		  			contentString += "<th>Assunto</th></tr></thread>";
		  			contentString += "<tbody>";
		  			//alert(nome_local);
		  			var noticiaXML = noticiasArray[0].getElementsByTagName("Noticia");
					for(var j=0; j<noticiaXML.length;j++) {
						var idnoticia = noticiaXML[j].getElementsByTagName("idnoticia").item(0).firstChild.data;
						var data_pub = noticiaXML[j].getElementsByTagName("data_pub").item(0).firstChild.data;
						var assunto = noticiaXML[j].getElementsByTagName("assunto").item(0).firstChild.data;
					
						var dataAux = data_pub.substring(0,11);
		  				contentString += "<tr><td>" + dataAux +  "</td>";
		  				contentString += "<td><a href='javascript: void 0' onclick=showQuadroNoticia("+idnoticia+")>" + assunto +  "</a></td></tr>";
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
				//t.noticias = noticiasTempo;
				//tempos[i] = t;
			}
			//DEBUG
			/*for(var k=0; k<tempos.length; k++) {
							  var result = tempos[k].dataInterpretada;
					    	  for(var m=0; m<tempos[k].noticias.length; m++) {
					    		  result += "," + tempos[k].noticias[m].idnoticia;
					    	  }
					    	  alert(result);
					      }*/
			/* Retorno do array de referï¿½ncias temporais usando funï¿½ï¿½o callback */
			//cb(tempos);
		},
		/* Tratamento de Falhas */
	    onFailure: function(){ alert("Erro ao recuperar 'Locais' do webservice!"); }
		});
}



function getLocalByNome(nome)
{
	var url = this.baseurlLocais + nome;
	new Ajax.Request(url,
	{
		method: 'get',
		asynchronous: true,
		onSuccess: function(transport){
			/* Recebimento da resposta */
		      var response = transport.responseXML;
		      var xmlRoot = response.documentElement;

		      /* Recupera arrays com tags do XML retornado */
		      var localDOMArray = xmlRoot.getElementsByTagName("Local");
		      for(var i=0; i<localDOMArray.length; i++) {
		    	  var idlocal = localDOMArray.item(i).getElementsByTagName("idlocal").item(0).firstChild.data;
		    	  var nome_local = localDOMArray.item(i).getElementsByTagName("nome_local").item(0).firstChild.data;
		    	  var lat = localDOMArray.item(i).getElementsByTagName("lat").item(0).firstChild.data;
		    	  var log = localDOMArray.item(i).getElementsByTagName("log").item(0).firstChild.data;
		    	  var noticiasArray = localDOMArray.item(i).getElementsByTagName("noticias");

		    	  //TODO
		    	  // Retirar após acerto no WebService
		    	  if(noticiasArray.length != 0) {
		    		  local = new google.maps.LatLng(parseFloat(lat), parseFloat(log));
		    		  //alert(data + "\n\nNoticia: " + idnoticia + "\n\nLocal: " + lat + "," + log);

		    		  marker = new google.maps.Marker({
		    			  position: local,
		    			  title: nome_local,
		    			  map: map
		    		  });
		    		  markersArray.push(marker);
		    		  var infoWindow = new google.maps.InfoWindow;
		    		  var contentString = "<div id='infoMarker'>";
		    		  contentString += "<h2><center>Noticias em " + nome_local + "</center></h2>";
		    		  contentString +=  "<table id='infoMarker-t'><thread>";
		    		  contentString += "<tr><th>Data Pub</th>";
		    		  contentString += "<th>Assunto</th></tr></thread>";
		    		  contentString += "<tbody>";
		    		  //alert(nome_local);
		    		  var noticiaXML = noticiasArray[0].getElementsByTagName("Noticia");
		    		  for(var j=0; j<noticiaXML.length;j++) {
		    			  var idnoticia = noticiaXML[j].getElementsByTagName("idnoticia").item(0).firstChild.data;
		    			  var data_pub = noticiaXML[j].getElementsByTagName("data_pub").item(0).firstChild.data;
		    			  var assunto = noticiaXML[j].getElementsByTagName("assunto").item(0).firstChild.data;

		    			  var dataAux = data_pub.substring(0,11);
		    			  contentString += "<tr><td>" + dataAux +  "</td>";
		    			  contentString += "<td><a href='javascript: void 0' onclick=showQuadroNoticia("+idnoticia+")>" + assunto +  "</a></td></tr>";
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
		      }
		},
		/* Tratamento de Falhas */
	    onFailure: function(){ return null; }
	});
};
