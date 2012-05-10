/**
 * Classe que representa uma referencia temporal de uma noticia
 */
function Tempo() {
	
	/** Data presente em uma not�cia com interpreta���o AAA-MM-DD **/ 
	this.dataInterpretada = "";
	
	/** Array de not�cias com referencia espacial igual a dataInterpretada **/
	this.noticias = new Array();
	
	/** URL base para comunicacao com o web service **/
	this.baseurl = "http://localhost/AW3/webservice/tempo.php/";
	
	/**
	 * Retorna as not�cias do ano corrente
	 */
	this.getUltimasNoticias = function (cb) {
		/* Obten��o da data atual */ 
	    var hoje = new Date();
	    var ano = hoje.getFullYear();
	    var mes = hoje.getMonth();
	    //var dia = hoje.getDate();
		var url = this.baseurl + ano;
		
	    new Ajax.Request(url,
				{
				    method:'get',
				    asynchronous: false,
				    onSuccess: function(transport){
				    	
				      /* Recebimento da resposta */
				      var response = transport.responseXML;
				      var xmlRoot = response.documentElement;
				      
				      
				      /* Recupera arrays com tags do XML retornado */
				      /* Recupera arrays com tags do XML retornado */
						var dataDOMArray = xmlRoot.getElementsByTagName("Data");

						/* Armazena dados retornados em Arrays */ 
						var tempos = new Array();
						for(var i=0; i<dataDOMArray.length; i++) {
							t = new Tempo();
							var data = dataDOMArray.item(i).getElementsByTagName("tempo").item(0).firstChild.data;
							//alert(data);
							t.dataInterpretada = data;
							
							/* Recupera��o das not�cias associadas � data interpretada recuperada */
							var noticiasArray = dataDOMArray.item(i).getElementsByTagName("Noticia");
							var noticiasTempo = new Array();
							//alert(data + ": " + noticiasArray.length);
							for(var j=0; j<noticiasArray.length;j++) {
							var n = new Noticia();
							n.idnoticia = noticiasArray[j].getElementsByTagName("idnoticia").item(0).firstChild.data;
							n.data_pub = noticiasArray[j].getElementsByTagName("data_pub").item(0).firstChild.data;
							n.assunto = noticiasArray[j].getElementsByTagName("assunto").item(0).firstChild.data;
							n.descricao = noticiasArray[j].getElementsByTagName("descricao").item(0).firstChild.data;
							n.url = noticiasArray[j].getElementsByTagName("url").item(0).firstChild.data;
							noticiasTempo[j] = n;
						}
						t.noticias = noticiasTempo;
						tempos[i] = t;
					  }
					  //DEBUG
					  /*for(var k=0; k<tempos.length; k++) {
						  var result = tempos[k].dataInterpretada;
				    	  for(var m=0; m<tempos[k].noticias.length; m++) {
				    		  result += "," + tempos[k].noticias[m].idnoticia;
				    	  }
				    	  alert(result);
				      }*/
					  /* Retorno do array de refer�ncias temporais usando fun��o callback */
					  //alert(tempos.length);
					  cb(tempos);
				    },
				    /* Tratamento de Falhas */
				    onFailure: function(){ alert("Erro ao recuperar '�ltimas Not�cias' do webservice!"); }
				});
	};
}

var baseurlTempo = "http://localhost/AW3/webservice/tempo.php/";
var markersArray = new Array();


function getUltimasNoticias() {
	
	var hoje = new Date();
	var ano = hoje.getFullYear();
	var mes = hoje.getMonth() + 1;
	//var dia = "1";
	var dia = hoje.getDate();
	mes = 4;
	var url = baseurlTempo + ano + "/" + mes;
	
	new Ajax.Request(url,
	{
		method:'get',
		asynchronous: true,
		onSuccess: function(transport){
			/* Recebimento da resposta */
			var response = transport.responseXML;
			var xmlRoot = response.documentElement;


			/* Recupera arrays com tags do XML retornado */
			var dataDOMArray = xmlRoot.getElementsByTagName("Data");

			/* Armazena dados retornados em Arrays */ 
			var tempos = new Array();
			for(var i=0; i<dataDOMArray.length; i++) {
				
				var data = dataDOMArray.item(i).getElementsByTagName("tempo").item(0).firstChild.data;
				//alert(data);
				
				/* Recupera��o das not�cias associadas � data interpretada recuperada */
				var noticiasArray = dataDOMArray.item(i).getElementsByTagName("Noticia");
				var noticiasTempo = new Array();
			
				for(var j=0; j<noticiasArray.length;j++) {
					var idnoticia = noticiasArray[j].getElementsByTagName("idnoticia").item(0).firstChild.data;
					var locaisArray = noticiasArray[j].getElementsByTagName("Local");
					for(var k=0; k<locaisArray.length; k++) {
						var nome_local = locaisArray[k].getElementsByTagName("nome_local").item(0).firstChild.data;
						var lat = locaisArray[k].getElementsByTagName("lat").item(0).firstChild.data;
						var log = locaisArray[k].getElementsByTagName("log").item(0).firstChild.data;
						local = new google.maps.LatLng(parseFloat(lat), parseFloat(log));
						//alert(data + "\n\nNoticia: " + idnoticia + "\n\nLocal: " + lat + "," + log);
						marker = new google.maps.Marker({
				  			position: local,
				  			title: nome_local,
				  			map: map
				  		});
						markersArray.push(marker);
					}
					//n.data_pub = noticiasArray[j].getElementsByTagName("data_pub").item(0).firstChild.data;
					//n.assunto = noticiasArray[j].getElementsByTagName("assunto").item(0).firstChild.data;
					//n.descricao = noticiasArray[j].getElementsByTagName("descricao").item(0).firstChild.data;
					//n.url = noticiasArray[j].getElementsByTagName("url").item(0).firstChild.data;
					//noticiasTempo[j] = n;
					//alert(data + "\n\n" + idnoticia + "\n\n" + locaisArray.length);
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
			/* Retorno do array de refer�ncias temporais usando fun��o callback */
			//cb(tempos);
		},
		/* Tratamento de Falhas */
		onFailure: function(){ alert("Erro ao recuperar '�ltimas Not�cias' do webservice!"); }
	});
	
}