
var baseurl = "http://localhost/AW3/webservice/espaco.php/";
var todosLocais = new Array();


function Local() {
	this.idlocal;
	this.nome_local;
	this.coordenadas;
	
	this.noticias = new Array();
	
}

function getAllLocais (start, count) 
	{
		var params = "";
		if(start != 0 && count != 0) {
			params = "?start=" + start + "&count=" + count;
		}
		var url = baseurl + params;
		
		new Ajax.Request(url,
		{
		    method:'get',
		    asynchronous: true,
		    onSuccess: function(transport){
		      /* Recebimento da resposta */
		      var response = transport.responseXML;
		      var xmlRoot = response.documentElement;
		      
		      /* Recupera arrays com tags do XML retornado */
		      var idlocalDOMArray = xmlRoot.getElementsByTagName("idlocal");
			  var nome_localDOMArray = xmlRoot.getElementsByTagName("nome_local");
			  var coordenadasDOMArray = xmlRoot.getElementsByTagName("coordenadas");
			  
			   /* Construçção dos objectos e armazenamento no Array de retorno */
			  for(var i=0; i<idlocalDOMArray.length; i++) {
			  	var l = new Local();
				l.idlocal = idlocalDOMArray.item(i).firstChild.data;
				l.nome_local = nome_localDOMArray.item(i).firstChild.data;
			  	l.coordenadas = coordenadasDOMArray.item(i).firstChild.data;
			  	
			  	coord = l.coordenadas.split(";");
				local = new google.maps.LatLng(parseFloat(coord[0]), parseFloat(coord[1]));
				nome_local = l.nome_local;
				//idlocal = newAux.locaisNoticias[k].idlocal
				/* Criação do objeto Marker */
				var marker = new google.maps.Marker({
		  			position: local,
		  			title: nome_local,
		  			map: map
		  		});
				//todosLocais[i] = l;
			  }
			  
			  //DEBUG
		      //alert("Success! \n\n" + todosLocais.length);
			  
			  /* Retorno do array de objectos usando função callback passada como parâmetro */
			  //cb(locais);
		    },
		    /* Tratamento de Falhas */
		    onFailure: function(){ alert("Erro ao recuperar 'Locais' do webservice!"); }
		});
	};
