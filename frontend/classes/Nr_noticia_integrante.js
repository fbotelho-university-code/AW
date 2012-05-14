function Nr_noticia_integrante() {
	this.nome_integrante;
	this.nr_noticia;
	
	/* URL base para comunicacao com o web service */
	this.baseurl = "http://localhost/AW3/webservice/stats.php/noticiasporintegrante/";
	
	this.get = function (start, count, cb) 
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
		      var nome_integranteDOMArray = xmlRoot.getElementsByTagName("nome_integrante");
			  var nr_noticiaDOMArray = xmlRoot.getElementsByTagName("nr_noticia");
			  
			  /* Armazena dados retornados em Arrays */ 
			  var noticias_integrante = new Array();
			  
			  for(var i=0; i<nome_integranteDOMArray.length; i++) {
			  	var c = new Nr_noticia_integrante();
				c.nome_integrante = nome_integranteDOMArray.item(i).firstChild.data;
				c.nr_noticia = parseInt(nr_noticiaDOMArray.item(i).firstChild.data,10);
				noticias_integrante[i] = c;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  cb(noticias_integrante);
		    },
		    /* Tratamento de Falhas */
		    on404: cb(null),
		    onFailure: function(){ alert("Erro ao recuperar 'Notícias por integrante' do webservice!"); }
		});
	};
}