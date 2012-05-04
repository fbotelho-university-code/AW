/**
 * Classe que representa uma referencia temporal de uma noticia
 */
function Tempo() {
	
	/** Data presente em uma notï¿½cia com interpretaï¿½ï¿½ï¿½o AAA-MM-DD **/ 
	this.dataInterpretada = "";
	
	/** Array de notï¿½cias com referencia espacial igual a dataInterpretada **/
	this.noticias = new Array();
	
	/** URL base para comunicacao com o web service **/
	this.baseurl = "http://localhost/proj/webservice/tempo.php/";
	
	/**
	 * Retorna as notï¿½cias do ano corrente
	 */
	this.getUltimasNoticias = function (cb) {
		/* Obtenï¿½ï¿½o da data atual */ 
	    var hoje = new Date();
	    var ano = hoje.getFullYear();
	    var mes = hoje.getMonth();
	    //var dia = hoje.getDate();
		
	    new Ajax.Request(this.baseurl + ano + "/" + mes,
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
						/* Recuperaï¿½ï¿½o da data interpretada do documento XML retornado */
						var tempoXML = dataDOMArray.item(i).getElementsByTagName("tempo").item(0).firstChild.data;
						t.dataInterpretada = tempoXML;
						
						/* Recuperaï¿½ï¿½o das notï¿½cias associadas ï¿½ data interpretada recuperada */
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
					  /* Retorno do array de referï¿½ncias temporais usando funï¿½ï¿½o callback */
					  cb(tempos);
				    },
				    /* Tratamento de Falhas */
				    onFailure: function(){ alert("Erro ao recuperar 'Últimas Notícias' do webservice!"); }
				});
	};
}