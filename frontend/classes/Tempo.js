/**
 * Classe que representa uma referencia temporal de uma noticia
 */
function Tempo() {
	
	/** Data presente em uma notícia com interpretaçção AAA-MM-DD **/ 
	this.dataInterpretada = "";
	
	/** Array de notícias com referencia espacial igual a dataInterpretada **/
	this.noticias = new Array();
	
	/** URL base para comunicacao com o web service **/
	this.baseurl = "http://localhost/AW3/webservice/tempo.php/";
	
	/**
	 * Retorna as notícias do ano corrente
	 */
	this.getUltimasNoticias = function (cb) {
		/* Obtenção da data atual */ 
	    var hoje = new Date();
	    var ano = hoje.getFullYear();
	    var mes = hoje.getMonth();
	    //var dia = hoje.getDate();
		
	    new Ajax.Request(this.baseurl + ano,
				{
				    method:'get',
				    asynchronous: false,
				    onSuccess: function(transport){
				      /* Recebimento da resposta */
				      var response = transport.responseXML;
				      var xmlRoot = response.documentElement;
				      
				      
				      /* Recupera arrays com tags do XML retornado */
				      var dataDOMArray = xmlRoot.getElementsByTagName("Data");
				      
					  /* Armazena dados retornados em Arrays */ 
					  var tempos = new Array();
					  for(var i=0; i<dataDOMArray.length; i++) {
						var t = new Tempo();
						/* Recuperação da data interpretada do documento XML retornado */
						var tempoXML = dataDOMArray.item(i).getElementsByTagName("tempo").item(0).firstChild.data;
						t.dataInterpretada = tempoXML;
						
						/* Recuperação das notícias associadas à data interpretada recuperada */
						var noticiasArray = dataDOMArray.item(i).getElementsByTagName("Noticia");
						var noticiasTempo = new Array();
						
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
					  /* Retorno do array de referências temporais usando função callback */
					  cb(tempos);
				    },
				    /* Tratamento de Falhas */
				    onFailure: function(){ alert("Erro ao recuperar 'Últimas Notícias' do webservice!"); }
				});
	};
}

function getUltimasNoticias() {
	
	var hoje = new Date();
	var ano = hoje.getFullYear();
	//var mes = hoje.getMonth();
	var dia = "1";
	//var dia = hoje.getDate();
	
	var baseurl = "http://localhost/AW3/webservice/tempo.php/";
	var url = baseurl + ano;
	alert(url);
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
				var t = new Tempo();
				/* Recuperação da data interpretada do documento XML retornado */
				var tempoXML = dataDOMArray.item(i).getElementsByTagName("tempo").item(0).firstChild.data;
				t.dataInterpretada = tempoXML;
				$("noticias").innerHTML += "<ul>" + t.dataInterpretada + "</ul>";
				
				/* Recuperação das notícias associadas à data interpretada recuperada */
				var noticiasArray = dataDOMArray.item(i).getElementsByTagName("Noticia");
				var noticiasTempo = new Array();
				for(var j=0; j<noticiasArray.length;j++) {
					//var n = new Noticia();
					//var idnoticia = noticiasArray[j].getElementsByTagName("idnoticia").item(0).firstChild.data;
					//n.data_pub = noticiasArray[j].getElementsByTagName("data_pub").item(0).firstChild.data;
					var assunto = noticiasArray[j].getElementsByTagName("assunto").item(0).firstChild.data;
					//n.descricao = noticiasArray[j].getElementsByTagName("descricao").item(0).firstChild.data;
					var url = noticiasArray[j].getElementsByTagName("url").item(0).firstChild.data;
					//noticiasTempo[j] = n;
					//alert(tempoXML + ": " + n.idnoticia);
					$("noticias").innerHTML += "<li><a href='"+ url + "'>" + assunto + "</a></li>";
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
			/* Retorno do array de referências temporais usando função callback */
			//cb(tempos);
		},
		/* Tratamento de Falhas */
		onFailure: function(){ alert("Erro ao recuperar 'Últimas Notícias' do webservice!"); }
	});
	
}