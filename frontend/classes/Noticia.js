/**
 * Classe que representa uma Notícia
 */
function Noticia() {
	
	/* Identificador unico da notícia */
	this.idnoticia = 0;
	
	/* Data de publicação da notícia */
	this.data_pub = "";
	
	/* Assunto da notícia */
	this.assunto = "";
	
	/* Descrição da notícia */
	this.descricao = "";
	
	/* URL da notícia */
	this.url = "";
	
	/* Qualificação da Notícia */
	this.qualificacao = 0;
	
	/* Array com locais das referências espaciais da notícia */
	this.locaisNoticias = new Array();
	
	/* Array com datas das referências espaciais da notícia */
	this.datasNoticias = new Array();
	
	/* Array com clubes presentes na notícia */
	this.clubesNoticias = new Array();
	
	/* Array com integrantes presentes na notícia */
	this.integrantesNoticias = new Array();
	
	/* URL para acesso ao recurso notícia do Web Service */
	this.baseurl = "http://localhost/AW3/webservice/noticias.php/";
	
	/**
	 * Retorna um conjunto de Noticias
	 */
	this.getAllNoticias = function (start, count, cb) {
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
			      var idnoticiaDOMArray = xmlRoot.getElementsByTagName("idnoticia");
				  var data_pubDOMArray = xmlRoot.getElementsByTagName("data_pub");
				  var assuntoDOMArray = xmlRoot.getElementsByTagName("assunto");
				  var descricaoDOMArray = xmlRoot.getElementsByTagName("descricao");
				  var urlDOMArray = xmlRoot.getElementsByTagName("url");
				  
				  /* Armazena dados retornados em Arrays */ 
				  var noticias = new Array();
				  for(var i=0; i<idnoticiaDOMArray.length; i++) {
					  var n = new Noticia();
					  n.idnoticia = idnoticiaDOMArray.item(i).firstChild.data;
					  n.data_pub = data_pubDOMArray.item(i).firstChild.data;
					  n.assunto = assuntoDOMArray.item(i).firstChild.data;
					  n.descricao = descricaoDOMArray.item(i).firstChild.data;
					  n.url = urlDOMArray.item(i).firstChild.data;
					  noticias[i] = n;
				  }
				  //DEBUG
				  //alert("Success! \n\n" + noticias.length);
				  cb(noticias);
			    },
			    /* Tratamento de Falhas */
			    onFailure: function(){ alert("Erro ao recuperar 'Noticias' do webservice!"); }
			}
		);
	};
	
	/**
	 * Recupera uma noticia especifica de acordo com o id passado como parâmetro.
	 * Necessita de função callback como parametro para devolver resultado
	 */
	this.getNoticiaById = function (id, cb)
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
			      var idnoticiaDOMArray = xmlRoot.getElementsByTagName("idnoticia");
				  var data_pubDOMArray = xmlRoot.getElementsByTagName("data_pub");
				  var assuntoDOMArray = xmlRoot.getElementsByTagName("assunto");
				  var descricaoDOMArray = xmlRoot.getElementsByTagName("descricao");
				  //var urlDOMArray = xmlRoot.getElementsByTagName("url");
				  
				  /* Criação do objecto usando XML retornado */
				  var n = new Noticia();
				  n.idnoticia = idnoticiaDOMArray.item(0).firstChild.data;
				  n.data_pub = data_pubDOMArray.item(0).firstChild.data;
				  n.assunto = assuntoDOMArray.item(0).firstChild.data;
				  n.descricao = descricaoDOMArray.item(0).firstChild.data;
				  //n.url = urlDOMArray.item(0).firstChild.data;
				  
				  /* Array de Locais das referencias espaciais da notícia */
				  var localDOMArray = xmlRoot.getElementsByTagName("Local");
				  if(localDOMArray != null) {
					  var myLocaisNoticias = new Array();
					  for(var j=0; j<localDOMArray.length;j++) {
							var l = new Local();
							l.idlocal = localDOMArray[j].getElementsByTagName("idlocal").item(0).firstChild.data;
							l.nome_local = localDOMArray[j].getElementsByTagName("nome_local").item(0).firstChild.data;
							l.coordenadas = localDOMArray[j].getElementsByTagName("coordenadas").item(0).firstChild.data;
							myLocaisNoticias[j] = l;
					  }
					  n.locaisNoticias = myLocaisNoticias;
				  }
				  //alert(n.locaisNoticias.length);
				  /* Array de Datas das referências temporais da notícia */
				  var dataDOMArray = xmlRoot.getElementsByTagName("data");
				  if(dataDOMArray != null) {
					  var myDatasNoticias = new Array();
					  for(var j=0; j<dataDOMArray.length;j++) {
							var d = dataDOMArray[j].firstChild.data;
							myDatasNoticias[j] = d;
					  }
					  n.datasNoticias = myDatasNoticias;
				  }
				  //alert(n.datasNoticias.length);
				  /* Array de Clubes das da notícia */
				  var clubeDOMArray = xmlRoot.getElementsByTagName("Clube");
				  var myClubesNoticias = new Array();
				  if(clubeDOMArray != null) {
					 
					  for(var j=0; j<clubeDOMArray.length;j++) {
							var c = new Clube();
							c.idclube = clubeDOMArray[j].getElementsByTagName("idclube").item(0).firstChild.data;
							c.nome_oficial = clubeDOMArray[j].getElementsByTagName("nome_oficial").item(0).firstChild.data;
							n.qualificacao += Number(clubeDOMArray[j].getElementsByTagName("qualificacao").item(0).firstChild.data);
							myClubesNoticias[j] = c;
							
					  }
				  }
				  n.clubesNoticias = myClubesNoticias;
				  //alert(n.clubesNoticias.length);
				  /* Array de Integrantes das da notícia */
				  var integranteDOMArray = xmlRoot.getElementsByTagName("Integrante");
				  if(integranteDOMArray != null) {
					  var myIntegrantesNoticias = new Array();
					  for(var j=0; j<integranteDOMArray.length;j++) {
							var int = new Integrante();
							int.idintegrante = integranteDOMArray[j].getElementsByTagName("idintegrante").item(0).firstChild.data;
							int.nome_integrante = integranteDOMArray[j].getElementsByTagName("nome_integrante").item(0).firstChild.data;
							n.qualificacao += Number(integranteDOMArray[j].getElementsByTagName("qualificacao").item(0).firstChild.data);
							myIntegrantesNoticias[j] = int;
							
					  }
					  n.integrantesNoticias = myIntegrantesNoticias;
				  }
				  //alert(n.integrantesNoticias.length);
				  /* Retorno do objecto usando função callback passada como parametro */
				  cb(n);
			},
			/* Tratamento de Falhas */
		    onFailure: function(){ cb(null); }
		});
	};
}

var baseurlNoticias = "http://localhost/AW3/webservice/noticias.php/";

function atualizarComentarios(id) {
	
	var url = baseurlNoticias + id;
	var urlComentario = url + "/comentarios";
	new Ajax.Request(urlComentario,
			{
				method: 'get',
				asynchronous: true,
				onSuccess: function (transport) {
					/* Recebimento da resposta */
				      var response = transport.responseXML;
				      var xmlRoot = response.documentElement;
				      
				      /* Recupera arrays com tags do XML retornado */
				      var comentarioDOMArray = xmlRoot.getElementsByTagName("Comentario");
				      $("countComentarios").innerHTML = "(" + comentarioDOMArray.length + ")";
				      
					  for(var i=0; i<comentarioDOMArray.length; i++){
						  var time = comentarioDOMArray[i].getElementsByTagName("time").item(0).firstChild.data;
						  
						  if(comentarioDOMArray[i].getElementsByTagName("user").item(0).firstChild == null) {
							  var user = "Anonymous";
						  }
						  else{
							  var user = comentarioDOMArray[i].getElementsByTagName("user").item(0).firstChild.data;
						  }
						  
						  if(comentarioDOMArray[i].getElementsByTagName("texto").item(0).firstChild == null) {
							  var texto = "Oops!";
						  }
						  else{
							  var texto = comentarioDOMArray[i].getElementsByTagName("texto").item(0).firstChild.data;
						  }
						  
						  var h4 = document.createElement("h4");
						  h4.innerHTML = user + ", em " + time + ": ";
						  var p = document.createElement("p");
						  p.setAttribute("class","textoComentario");
						  p.innerHTML = texto;
						  var br_1 = document.createElement("br");
						  var hr = document.createElement("hr");
						  hr.setAttribute("width","50%");
						  var br_2 = document.createElement("br");
						  
						 
						  $("todosComentarios").appendChild(h4);
						  $("todosComentarios").appendChild(p);
						  $("todosComentarios").appendChild(br_1);
						  $("todosComentarios").appendChild(hr);
						  $("todosComentarios").appendChild(br_2);
						  
					  }
				},
				/* Tratamento de Falhas */
				on404: function() {
					$("countComentarios").innerHTML = "(0)";
					$("todosComentarios").innerHTML = "";
				},
			    onFailure: function(){ alert("Erro ao retornar notícia por id") }
			});
}

function getNoticiaById(id)
{
	var url = baseurlNoticias + id;
	
	atualizarComentarios(id);
	
	new Ajax.Request(url,
	{
		method: 'get',
		asynchronous: true,
		onSuccess: function(transport){
			/* Recebimento da resposta */
		      var response = transport.responseXML;
		      var xmlRoot = response.documentElement;
		      
		      /* Recupera arrays com tags do XML retornado */
		      var idnoticiaDOMArray = xmlRoot.getElementsByTagName("idnoticia");
			  var data_pubDOMArray = xmlRoot.getElementsByTagName("data_pub");
			  var assuntoDOMArray = xmlRoot.getElementsByTagName("assunto");
			  var descricaoDOMArray = xmlRoot.getElementsByTagName("descricao");
			  var urlDOMArray = xmlRoot.getElementsByTagName("url");
			  var aboutDOMArray = xmlRoot.getElementsByTagName("about");
			  
			  var idnoticia = idnoticiaDOMArray.item(0).firstChild.data;
			  var data_pub = data_pubDOMArray.item(0).firstChild.data;
			  var assunto = assuntoDOMArray.item(0).firstChild.data;
			  var descricao = descricaoDOMArray.item(0).firstChild.data;
			  var url = urlDOMArray.item(0).firstChild.data;
			  var about = aboutDOMArray.item(0).firstChild.data;
			  
			  var localDOMArray = xmlRoot.getElementsByTagName("Local");
			  var myLocaisNoticias = new Array();
			  //alert(localDOMArray.length);
			  if(localDOMArray != null) {
				  for(var j=0; j<localDOMArray.length;j++) {
						var l = new Local();
						l.idlocal = localDOMArray[j].getElementsByTagName("idlocal").item(0).firstChild.data;
						l.nome_local = localDOMArray[j].getElementsByTagName("nome_local").item(0).firstChild.data;
						l.lat = localDOMArray[j].getElementsByTagName("lat").item(0).firstChild.data;
						l.log = localDOMArray[j].getElementsByTagName("log").item(0).firstChild.data;
						myLocaisNoticias[j] = l;
				  }
			  }
			  //alert(n.locaisNoticias.length);
			  
			  var dataDOMArray = xmlRoot.getElementsByTagName("data");
			  var myDatasNoticias = new Array();
			  if(dataDOMArray != null) {
				  for(var j=0; j<dataDOMArray.length;j++) {
						var d = dataDOMArray[j].firstChild.data;
						myDatasNoticias[j] = d;
				  }
			  }
			  //alert(n.datasNoticias.length);
			  var qualificacao = 0;
			  var clubeDOMArray = xmlRoot.getElementsByTagName("Clube");
			  var myClubesNoticias = new Array();
			  if(clubeDOMArray != null) { 
				  for(var j=0; j<clubeDOMArray.length;j++) {
						var c = new Clube();
						c.idclube = clubeDOMArray[j].getElementsByTagName("idclube").item(0).firstChild.data;
						c.nome_oficial = clubeDOMArray[j].getElementsByTagName("nome_oficial").item(0).firstChild.data;
						qualificacao += Number(clubeDOMArray[j].getElementsByTagName("qualificacao").item(0).firstChild.data);
						if(clubeDOMArray[j].getElementsByTagName("url_img").item(0).firstChild != null) {
							  c.url_img = clubeDOMArray[j].getElementsByTagName("url_img").item(0).firstChild.data;
						  }
						  else{
							  c.url_img = "css/images/escudo_default.JPG";
						  }
						myClubesNoticias[j] = c;
						
				  }
			  }
			  //alert(n.clubesNoticias.length);
			  
			  var integranteDOMArray = xmlRoot.getElementsByTagName("Integrante");
			  var myIntegrantesNoticias = new Array();
			  if(integranteDOMArray != null) {
				  var myIntegrantesNoticias = new Array();
				  for(var j=0; j<integranteDOMArray.length;j++) {
						var int = new Integrante();
						int.idintegrante = integranteDOMArray[j].getElementsByTagName("idintegrante").item(0).firstChild.data;
						int.nome_integrante = integranteDOMArray[j].getElementsByTagName("nome_integrante").item(0).firstChild.data;
						qualificacao += Number(integranteDOMArray[j].getElementsByTagName("qualificacao").item(0).firstChild.data);
						if(integranteDOMArray[j].getElementsByTagName("url_img").item(0).firstChild != null) {
				    		  int.url_img = integranteDOMArray[j].getElementsByTagName("url_img").item(0).firstChild.data;
						  }
						  else{
							  int.url_img = "css/images/jogador_default.jpg";
						  }
						myIntegrantesNoticias[j] = int;		
				  }
			  }
			  //alert(n.integrantesNoticias.length);
			 
			  $("assuntoNoticiaEscolhida").innerHTML = assunto;
			  $("descricaoNoticiaEscolhida").innerHTML = descricao;
			  //$("qualificacaoNoticiaEscolhida").innerHTML = "(" + qualificacao + ")&nbsp;&nbsp;&nbsp;";
			  $("linkNoticiaEscolhida").href = url;
			  $("aboutTexto").innerHTML = "Pesquisada por: " + about;
			  $("botaoComentario").href = "javascript:inserirComentario(" + idnoticia + ")";

			  /* Mostra clubes associados à notícia */
			  var imageClubes = "<table>";
			  if(myClubesNoticias.length == 0) {
				  imageClubes += "<tr><td>Sem clubes associados a esta noticia.</td></tr>";
			  }
			  else {
				  for(var i=0; i<myClubesNoticias.length; i++) {
					  imageClubes += "<tr>";
					  imageClubes += "<td><img src='" + myClubesNoticias[i].url_img + "' alt='" + myClubesNoticias[i].nome_oficial + "' width='48' height='48'></td>" ;
					  imageClubes += "<td>" + myClubesNoticias[i].nome_oficial + "</td>";
					  imageClubes += "<td align='left'><a href='javascript: excluirClubeNoticia("+ myClubesNoticias[i].idclube +", " + id + ")'><img src='css/images/trash.jpg' alt='Excluir' width='16' height='16'/></a></td></tr>";
				  }
			  }
			  imageClubes += "</table>";
			  $("clubesNoticiaEscolhida").innerHTML = imageClubes;
			  
			  /* Alterar href dos clubes listados */
			  for(var i=0; i<img_clubes.length; i++) {
				  var link = $("addClube_" + i);
				  link.href = "javascript: addClubeNoticia(" + id_clubes[i] + ", " + idnoticia + ")";
			  }

			  /* Mostra integrantes associados à notícia */
			  var imageIntegrantes = "<table>";
			  if(myIntegrantesNoticias.length == 0) {
				  imageIntegrantes += "<tr><td>Sem integrantes associados a esta noticia.</td></tr>";
			  }
			  else {
				  for(var i=0; i<myIntegrantesNoticias.length; i++) {
					  imageIntegrantes += "<tr>";
					  imageIntegrantes += "<td><img src='" + myIntegrantesNoticias[i].url_img + "' alt='" + myIntegrantesNoticias[i].nome_integrante + "' width='48' height='48'></td>" ;
					  imageIntegrantes += "<td>" + myIntegrantesNoticias[i].nome_integrante + "</td>";
					  imageIntegrantes += "<td align='left'><a href='javascript: excluirIntegranteNoticia("+ myIntegrantesNoticias[i].idintegrante +", " + id + ")'><img src='css/images/trash.jpg' alt='Excluir' width='16' height='16'/></td></tr>";
				  }
			  }
			  imageIntegrantes += "</table>";
			  $("integrantesNoticiaEscolhida").innerHTML = imageIntegrantes;
			  
			  /* Alterar href dos integrantes listados */
			  for(var i=0; i<img_integrantes.length; i++) {
				  var link = $("addIntegrante_" + i);
				  link.href = "javascript: addIntegranteNoticia(" + id_integrantes[i] + ", " + idnoticia + ")";
			  }
			  
			  /* Mostra Referências Espaciais da notícia escolhida */
			  var locaisNoticia = "<ul>";
			  //locaisNoticia += "<li><br /><input type='text' size='30' id='pesquisaLocal' autoComplete='mygroup2' /></li>";
			  if(myLocaisNoticias.length == 0) {
				  locaisNoticia += "<li>Não existem locais associados a esta notícia.</li>";
			  }
			  else {
				  for(var i=0; i<myLocaisNoticias.length; i++) {
					  locaisNoticia += "<li>" + myLocaisNoticias[i].nome_local;
					  locaisNoticia += "&nbsp;&nbsp;&nbsp;<a href='javascript: excluirLocalNoticia("+ myLocaisNoticias[i].idlocal +", " + id + ")'><img src='css/images/trash.jpg' alt='Excluir' width='16' height='16'/></a></li>";
				  }
			  }
			  locaisNoticia += "</ul>";
			  locaisNoticia += "<br /><input type='text' size='10' id='pesquisaLocal' style='z-index:3;' autoComplete='mygroup2' />";
			  locaisNoticia += "&nbsp;&nbsp;&nbsp;<a href=\"javascript: addLocalNoticia(" + id + ")\"><img src='css/images/plus.png' alt='Adicionar' width='16' height='16'/></a>";
			   
			  $("locaisNoticiaEscolhida").innerHTML = locaisNoticia;

			  /* Mostra Referências Temporais da notícia escolhida */
			  var datasNoticia = "<ul>";
			  if(myDatasNoticias.length == 0) {
				  datasNoticia += "<li>Não existem datas associadas a esta notícia.</li>";
			  }
			  else {
				  for(var i=0; i<myDatasNoticias.length; i++) {
					  datasNoticia += "<li>" + myDatasNoticias[i];
					  datasNoticia += "&nbsp;<a href=\"javascript: excluirDataNoticia('"+ myDatasNoticias[i] +"', " + id + ")\"><img src='css/images/trash.jpg' alt='Excluir' width='16' height='16'/></a></li>";
				  }
			  } 			
			  datasNoticia += "</ul>";
			  datasNoticia += "<br /><input type='text' size='10' id='pesquisaData' style='z-index:3;'/>";
			  datasNoticia += "&nbsp;&nbsp;&nbsp;<a href=\"javascript: addDataNoticia(" + id + ")\"><img src='css/images/plus.png' alt='Adicionar' width='16' height='16'/></a>";
			  $("datasNoticiaEscolhida").innerHTML = datasNoticia;
			  
			  
		},
		/* Tratamento de Falhas */
	    onFailure: function(){ alert("Erro ao retornar notícia por id") }
	});
}	


function inserirComentarioNoticia(id, xml) {
		var url = baseurlNoticias + id;
		new Ajax.Request(url,
		{
			method: 'post',
			asynchronous: false,
			postBody: xml,
			onSuccess: function(transport){
				atualizarComentarios(id);
			},
			onFailure: function(){ alert("Erro ao inserir comentario") }
		});
}

var xmlHttp = new XMLHttpRequest();

function excluirClubeNoticia(idclube, idnoticia) {
	
	var url = baseurlNoticias + idnoticia;
	var responseGET = null;
	var xmlNoticia;
	
	new Ajax.Request(url,
			{
				method: 'get',
				asynchronous: false,
				onSuccess: function(transport){
					/* Recebimento da resposta */
				      responseGET = transport.responseXML;
				      xmlNoticia = responseGET.documentElement;
				      
				      
				},
				/* Tratamento de Falhas */
			    onFailure: function(){ alert("Erro ao retornar notícia por id") }
			});
	
	var clubeDOMArray = xmlNoticia.getElementsByTagName("Clube");
	//alert(xmlNoticia.getElementsByTagName("Clube").length);
	  if(clubeDOMArray != null) { 
		  for(var j=0; j<clubeDOMArray.length;j++) {
				var idc = clubeDOMArray[j].getElementsByTagName("idclube").item(0).firstChild.data;
				if(idc == idclube) {
					//alert("Achei");
					var node = xmlNoticia.getElementsByTagName("Clube")[j];
					node.parentNode.removeChild(node);
				}
		  }
	  }
	  
	  if(responseGET != null) {
		  alterarRelacoesNoticia(idnoticia, responseGET);
	  }
	  else {
		  alert("Erro ao excluir clube de notícias")
	  }
}

function excluirIntegranteNoticia(idintegrante, idnoticia) {
	
	var url = baseurlNoticias + idnoticia;
	var responseGET = null;
	var xmlNoticia;
	
	new Ajax.Request(url,
			{
				method: 'get',
				asynchronous: false,
				onSuccess: function(transport){
					/* Recebimento da resposta */
				      responseGET = transport.responseXML;
				      xmlNoticia = responseGET.documentElement;
				      
				      
				},
				/* Tratamento de Falhas */
			    onFailure: function(){ alert("Erro ao retornar notícia por id") }
			});
	
	var integranteDOMArray = xmlNoticia.getElementsByTagName("Integrante");
	//alert(xmlNoticia.getElementsByTagName("Clube").length);
	  if(integranteDOMArray.length != 0) { 
		  for(var j=0; j<integranteDOMArray.length;j++) {
				var idi = integranteDOMArray[j].getElementsByTagName("idintegrante").item(0).firstChild.data;
				if(idi == idintegrante) {
					//alert("Achei");
					var node = xmlNoticia.getElementsByTagName("Integrante")[j];
					node.parentNode.removeChild(node);
				}
		  }
	  }
	  
	  if(responseGET != null) {
		  alterarRelacoesNoticia(idnoticia, responseGET);
	  }
	  else {
		  alert("Erro ao excluir clube de notícias")
	  }
}

function excluirLocalNoticia(idlocal, idnoticia) {
	
	var url = baseurlNoticias + idnoticia;
	var responseGET = null;
	var xmlNoticia;
	
	new Ajax.Request(url,
			{
				method: 'get',
				asynchronous: false,
				onSuccess: function(transport){
					/* Recebimento da resposta */
				      responseGET = transport.responseXML;
				      xmlNoticia = responseGET.documentElement;
				      
				      
				},
				/* Tratamento de Falhas */
			    onFailure: function(){ alert("Erro ao retornar notícia por id") }
			});
	
	var localDOMArray = xmlNoticia.getElementsByTagName("Local");
	//alert(xmlNoticia.getElementsByTagName("Local").length);
	  if(localDOMArray.length != 0) { 
		  for(var j=0; j<localDOMArray.length;j++) {
				var idl = localDOMArray[j].getElementsByTagName("idlocal").item(0).firstChild.data;
				if(idl == idlocal) {
					//alert("Achei");
					var node = xmlNoticia.getElementsByTagName("Local")[j];
					node.parentNode.removeChild(node);
				}
		  }
	  }
	  //alert(xmlNoticia.getElementsByTagName("Local").length);
	  if(responseGET != null) {
		  alterarRelacoesNoticia(idnoticia, responseGET);
	  }
	  else {
		  alert("Erro ao excluir clube de notícias")
	  }
}

function excluirDataNoticia(data, idnoticia) {
	
	var url = baseurlNoticias + idnoticia;
	var responseGET = null;
	var xmlNoticia;
	
	new Ajax.Request(url,
			{
				method: 'get',
				asynchronous: false,
				onSuccess: function(transport){
					/* Recebimento da resposta */
				      responseGET = transport.responseXML;
				      xmlNoticia = responseGET.documentElement;
				      
				      
				},
				/* Tratamento de Falhas */
			    onFailure: function(){ alert("Erro ao retornar notícia por id") }
			});
	var dataDOMArray = xmlNoticia.getElementsByTagName("data");
	//alert(xmlNoticia.getElementsByTagName("data").length);
	  if(dataDOMArray.length != 0) { 
		  for(var j=0; j<dataDOMArray.length;j++) {
				var idd = dataDOMArray[j].firstChild.data;
				if(idd == data) {
					//alert("Achei");
					var node = xmlNoticia.getElementsByTagName("data")[j];
					node.parentNode.removeChild(node);
				}
		  }
	  }
	  //alert(xmlNoticia.getElementsByTagName("data").length);
	  if(responseGET != null) {
		  alterarRelacoesNoticia(idnoticia, responseGET);
	  }
	  else {
		  alert("Erro ao excluir clube de notícias")
	  }
}

function addClubeNoticia(idc, idn) {
	//alert("Inserir Clube  " + idc + " em Noticia " + idn);
	
	var url = baseurlNoticias + idn;
	var responseGET = null;
	var xmlNoticia;
	
	new Ajax.Request(url,
			{
		method: 'get',
		asynchronous: false,
		onSuccess: function(transport){
			/* Recebimento da resposta */
			responseGET = transport.responseXML;
			xmlNoticia = responseGET.documentElement;


		},
		/* Tratamento de Falhas */
		onFailure: function(){ alert("Erro ao retornar notícia por id em AddClubeNoticia") }
		});
	
	//alert(xmlNoticia.getElementsByTagName("Clube").length);
	var clubeDOMArray = xmlNoticia.getElementsByTagName("clubes");
	 
		var clube = responseGET.createElement("Clube");
		var idclube = responseGET.createElement("idclube");
		var idclube_value = responseGET.createTextNode(idc);
		idclube.appendChild(idclube_value);
		clube.appendChild(idclube);
	
		if(clubeDOMArray.length != 0) {
			responseGET.getElementsByTagName("clubes")[0].appendChild(clube);
		}
		else{
			var clubes = responseGET.createElement("clubes");
			clubes.appendChild(clube);
			responseGET.documentElement.appendChild(clubes);
		}
	
	//alert(xmlNoticia.getElementsByTagName("Clube").length);
	
	if(responseGET != null) {
		  alterarRelacoesNoticia(idn, responseGET);
	  }
	  else {
		  alert("Erro ao incluir clube de notícias");
	  }
	
}

function addIntegranteNoticia(idi, idn) {
	var url = baseurlNoticias + idn;
	var responseGET = null;
	var xmlNoticia;
	
	new Ajax.Request(url,
			{
		method: 'get',
		asynchronous: false,
		onSuccess: function(transport){
			/* Recebimento da resposta */
			responseGET = transport.responseXML;
			xmlNoticia = responseGET.documentElement;


		},
		/* Tratamento de Falhas */
		onFailure: function(){ alert("Erro ao retornar notícia por id em AddIntegranteNoticia") }
		});
	
	//alert(xmlNoticia.getElementsByTagName("Clube").length);
	var integranteDOMArray = xmlNoticia.getElementsByTagName("integrantes");
	 
		var integrante = responseGET.createElement("Integrante");
		var idintegrante = responseGET.createElement("idintegrante");
		var idintegrante_value = responseGET.createTextNode(idi);
		idintegrante.appendChild(idintegrante_value);
		integrante.appendChild(idintegrante);
	
	if(integranteDOMArray.length != 0) {	
		responseGET.getElementsByTagName("integrantes")[0].appendChild(integrante);
	}
	else{
		var integrantes = responseGET.createElement("integrantes");
		integrantes.appendChild(integrante);
		responseGET.documentElement.appendChild(integrantes);
	}
	//alert(xmlNoticia.getElementsByTagName("Clube").length);
	
	if(responseGET != null) {
		  alterarRelacoesNoticia(idn, responseGET);
	  }
	  else {
		  alert("Erro ao incluir integrante em notícia");
	  }
}

function addLocalNoticia(idn) {
	var url = baseurlNoticias +idn;
	var responseGET = null;
	var xmlNoticia;
	
	var nomeLocalEscolhido = $("pesquisaLocal").value;
	var idLocalEscolhido = 0;
	
	for(var i=0; i<nome_localArray.length; i++) {
		if(nome_localArray[i] == nomeLocalEscolhido) {
			idLocalEscolhido = id_localArray[i];
		}
	}
	
	
		//alert(idLocalEscolhido);
	new Ajax.Request(url,
			{
		method: 'get',
		asynchronous: false,
		onSuccess: function(transport){
			/* Recebimento da resposta */
			responseGET = transport.responseXML;
			xmlNoticia = responseGET.documentElement;


		},
		/* Tratamento de Falhas */
		onFailure: function(){ alert("Erro ao retornar notícia por id em AddIntegranteNoticia") }
		});
	//alert(localDOMArray.length);
	
	
	//alert(idLocalEscolhido);
	//alert(xmlNoticia.getElementsByTagName("Local").length);
	var localDOMArray = xmlNoticia.getElementsByTagName("locais");
	 
		var local = responseGET.createElement("Local");
		var idlocal = responseGET.createElement("idlocal");
		var idlocal_value = responseGET.createTextNode(idLocalEscolhido);
		idlocal.appendChild(idlocal_value);
		local.appendChild(idlocal);
	
	if(localDOMArray.length != 0) {	
		responseGET.getElementsByTagName("locais")[0].appendChild(local);
	}
	else{
		var locais = responseGET.createElement("locais");
		locais.appendChild(local);
		responseGET.documentElement.appendChild(locais);
	}
	//alert(xmlNoticia.getElementsByTagName("Local").length);
	
	if(responseGET != null) {
		  alterarRelacoesNoticia(idn, responseGET);
	  }
	  else {
		  alert("Erro ao incluir integrante em notícia");
	  }
}

function addDataNoticia(idn) {
	var url = baseurlNoticias + idn;
	var responseGET = null;
	var xmlNoticia;
	
	var dataEscolhida = $("pesquisaData").value;
	
	if(dataEscolhida == "") {
		alert("Data incorreta.");
		return;
	}
	
	new Ajax.Request(url,
			{
		method: 'get',
		asynchronous: false,
		onSuccess: function(transport){
			/* Recebimento da resposta */
			responseGET = transport.responseXML;
			xmlNoticia = responseGET.documentElement;


		},
		/* Tratamento de Falhas */
		onFailure: function(){ alert("Erro ao retornar notícia por id em AddIntegranteNoticia") }
		});
	
		//alert(xmlNoticia.getElementsByTagName("data").length);
		var dataDOMArray = xmlNoticia.getElementsByTagName("data");
	 
		var data = responseGET.createElement("data");
		var data_value = responseGET.createTextNode(dataEscolhida);
		data.appendChild(data_value);
		
		
		
	if(dataDOMArray.length != 0) {	
		responseGET.getElementsByTagName("datas")[0].appendChild(data);
	}
	else{
		var locais = responseGET.createElement("datas");
		locais.appendChild(data);
		responseGET.documentElement.appendChild(datas);
	}
	//alert(xmlNoticia.getElementsByTagName("data").length);
	
	if(responseGET != null) {
		  alterarRelacoesNoticia(idn, responseGET);
	  }
	  else {
		  alert("Erro ao incluir integrante em notícia");
	  }
}

function alterarRelacoesNoticia(idNoticia, xml) {
		
	var url = baseurlNoticias + idNoticia;
	//só continua se xmlHttp não é void
	if (xmlHttp)
	{
		xmlHttp.onreadystatechange= function trataResposta() {
			if (xmlHttp.readyState==4) {
				handleRequestStateChange(idNoticia);
			}
		}
		//tenta ligar ao servidor
		try
		
		{
			xmlHttp.open("PUT",url,true); //Abre um Request ao servidor
			//define o nome do event handler que deve ser chamado quando o valor da propriedade readyState muda
			
			xmlHttp.send(xml);
			//Para o browser obter os dados do URL configurado
		}
		//apresenta o erro em caso de falha
		catch (e)
		{
			alert("Não é possível comunicar com o servidor alterar relação de noticia \n " + e.toString());
		}
	}
	else{
		alert("XMLHttp error");
	}
}

function handleRequestStateChange(id)
{
	
	if (xmlHttp.status <= 500)
		{
			try
			{
			//Utilizar a resposta do servidor
			alert("OK");
			refreshQuadroNoticia(id);
			}
			catch (e)
			{
			//Apresentar mensagem de erro
			alert("Erro PUT noticias : "  + e.toString());
			}
		}
		else
		{
			//Apresenta a mensagem de estado
			alert("Houve um problema na obtenção dos dados:\n" + xmlHttp.statusText);
		}
}



