function Nr_noticia_data() {
	this.mes;
	this.nr_noticia;
	
	/* URL base para comunicacao com o web service */
	this.baseurl = "http://localhost/AW3/webservice/stats.php/noticiaspordata";
	
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
		      var mesDOMArray = xmlRoot.getElementsByTagName("mes");
			  var nr_noticiaDOMArray = xmlRoot.getElementsByTagName("nr_noticia");
			  
			  /* Armazena dados retornados em Arrays */ 
			  var noticias_data = new Array();
			  
			  for(var i=0; i<mesDOMArray.length; i++) {
			  	var c = new Nr_noticia_data();
				c.mes = mesDOMArray.item(i).firstChild.data;
				c.nr_noticia = parseInt(nr_noticiaDOMArray.item(i).firstChild.data,10);
				noticias_data[i] = c;
			  }
			  //DEBUG
		      //alert("Success! \n\n" + clubes.length);
			  cb(noticias_data);
		    },
		    on404: cb(null),
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Notícias por data' do webservice!"); }
		});
	};
}