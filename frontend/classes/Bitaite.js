function Bitaite() {
	this.idbitaite;
	this.texto;
	this.user;
	this.link;
	
	/* URL base para comunicacao com o web service */
	this.url = "http://localhost/proj/webservice/bitas.php/";
	
	this.get = function (cb) 
	{
		
		new Ajax.Request(this.url,
		{
		    method:'get',
		    asynchronous: false,
		    onSuccess: function(transport){
		      /* Recebimento da resposta */
		      var response = transport.responseXML;
		      var xmlRoot = response.documentElement;
		      
		      /* Recupera arrays com tags do XML retornado */
		      var idbitaiteDOMArray = xmlRoot.getElementsByTagName("idbitaite");
		      var textoDOMArray = xmlRoot.getElementsByTagName("texto");
		      var userDOMArray = xmlRoot.getElementsByTagName("user");
		      var linkDOMArray = xmlRoot.getElementsByTagName("url");
			  
			  /* Armazena dados retornados em Arrays */ 
			  var bitaites = new Array();
			  
			  for(var i=0; i<idbitaiteDOMArray.length; i++) {
			  	var c = new Bitaite();
				c.idbitaite = parseInt(idbitaiteDOMArray.item(i).firstChild.data,10);
				c.texto = textoDOMArray.item(i).firstChild.data;
				c.user = userDOMArray.item(i).firstChild.data;
				c.link = linkDOMArray.item(i).firstChild.data;
				bitaites[i] = c;
			  }
			  //DEBUG
			  cb(bitaites,transport.getHeader("Etag"));
		    },
		    on404: cb(null),
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'bitaites' do webservice!"); }
		});
	};
}