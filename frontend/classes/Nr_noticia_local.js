function Nr_noticia_local() {
	this.nome_local;
	this.nr_noticia;
	
	/* URL base para comunicacao com o web service */
	this.baseurl = "http://localhost/proj/webservice/stats.php/noticiasporlocal/";
	
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
		      var nome_localDOMArray = xmlRoot.getElementsByTagName("nome_local");
			  var nr_noticiaDOMArray = xmlRoot.getElementsByTagName("nr_noticia");
			  
			  /* Armazena dados retornados em Arrays */ 
			  var noticias_local = new Array();
			  
			  for(var i=0; i<nome_localDOMArray.length; i++) {
			  	var c = new Nr_noticia_local();
				c.nome_local = nome_localDOMArray.item(i).firstChild.data;
				c.nr_noticia = parseInt(nr_noticiaDOMArray.item(i).firstChild.data,10);
				noticias_local[i] = c;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  cb(noticias_local);
		    },
		    on404: cb(null),
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Notícias por local' do webservice!"); }
		});
	};
}