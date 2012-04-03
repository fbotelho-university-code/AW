<?php
 
 require_once ('Util/RestUtils.php'); 
 require_once ('Util/RestRequest.php'); 
 require_once ('Util/XML/Serializer.php'); 
 require_once ('../model/Noticia.php');

  
 /*
  * Documenta‹o dos mŽtodos suportados neste url: 
	/ | GET | Listar todas as noticias. Representa‹o em XML, JSON e XHTML que devem conter apontadores para o recurso de cada noticia.  Por parametro Ž possivel especificar palavras chaves de forma a filtrar os resultados (i.e., permitir escolher noticias que referem o clube X.).

	/ | POST |  Coloca‹o de  uma noticia nova. O corpo do pedido deve  conter a descri‹o da noticia em XML . Ser‡ retornado o identificador œnico da noticia decidido pelo servio.

	/idNoticia | GET | Retorna o conteudo e informa‹o relativa a uma noticia, incluindo rela›es como referencias temporais, referencias espaciais, clubes , etc., A representa‹o ser‡ em XML, JSON e XHTML. 
 **/
 
 	 $options = array(
      "indent"          => "    ",
      "linebreak"       => "\n",
      "typeHints"       => false,
      "addDecl"         => true,
      "encoding"        => "UTF-8",
      XML_SERIALIZER_OPTION_RETURN_RESULT => true, 
      "defaultTagName"  => "noticia",
      "ignoreNull"      => true,
 	); 
 	
 	$xmlSerializer = new XML_Serializer($options); 
 
    
	$req  = RestUtils::processRequest();  // The request made by the client.
	checkRequest($req);   // check that the request is valid. Dies otherwise.  
	  
	  //Dispatching according to the path info. 
	  $path_parameters = $req->getPathInfo(); 
	  $path_parameters_count = count($path_parameters);
	  
	  switch($path_parameters_count){
		case 0: 		  	
	  		processRoot($req);
	  		break; 
	  	case 1:
	  		processNews($req);
	  		break;  
	  	default:
	  	//TODO - send bad content 
	  } 
	  
	// Process resource head (/noticias) requests. Accepts GET/POST/HEAD
	
	/*
	 * TODO: 
	 * POST
	 * HEAD
	 */
	function processRoot($req){
		switch($req->getMethod()){
			case 'GET': 
				getRoot($req);
			break;
			case 'POST': 
				postRoot($req);
			break;
			case 'HEAD': 
				postHead($req);
			break;
			default:
				RestUtils::sendResponse(405, array('allow' => "HEAD", "GET", "POST"));
				exit; 
		}			
	}
	
	/**
	 * Listar todas as noticias. 
	 * Representa‹o em XML, JSON que devem conter apontadores para o recurso de cada noticia.  
	 * Por parametro (search=SEARCH_STRING) Ž possivel especificar palavras chaves de forma a filtrar os resultados (i.e., permitir escolher noticias que referem o clube X.).
	 * TODO : filtrar pesquisa. 
	 **/
	function getRoot($req){
		$noticia = new Noticia(); 
		$news =$noticia->getAll(array("idnoticia","data_pub", "assunto", "descricao", "url"));
		if (!$news){
			RestUtils::sendResponse(500); 
		}
		foreach ($news as $n){
			$n->follow = "myUrl/" . $n->idnoticia; 
		}
		
		if ($req->getHttpAccept() == 'text/xml'){
		
		global $options; $options["rootName"] = "noticias"; 
		
		$xmlSerializer =  new XML_Serializer($options); 
		
		//var_dump($news); 
		$result = $xmlSerializer->serialize($news);
		
		if ($result == true){
			RestUtils::sendResponse(200, null, $xmlSerializer->getSerializedData(), 'text/xml'); 
		}
		else{
			RestUtils::sendResponse(500); 
		}
		}
		else if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null,  json_encode($news)); 
		}
		else{
			RestUtils::sendResponse(406); 
		}
		//TODO - send malformed request response
	}
	
	/**
	 * Post to /noticias . 
	 * Must create new news and return the identifier  of that news  
	 * 
	 */
	function postRoot($req){
		$n = Noticia::fromXml($req->getData());
		if (!$n) { 
			RestUtils::sendResponse(400);
			exit;  
		}
		$id = $n->add();
		if (!$id){
			//database could not
			RestUtils::sendResponse(500);	
		} 
//		if ($id = )
		//RestUtils::sendResponse(200, null, $req->getData()); 
	}
	//Process resource (/noticias/{idnoticia}) requests. Accepts GET/PUT/HEAD/DELETE
/*
 * TODO: 
 * PUT
 * HEAD
 * DELETE
 */
	function processNews($req){
		switch($req->getMethod()){
			case 'GET': 
			getNews($req);
			break; 
			case 'PUT':
			break;
			case 'HEAD':
			break; 
			case 'DELETE':
			break; 
			default: 
			 RestUtils::sendResponse(405, array('allow' => "HEAD", "PUT",  "DELETE", "GET"));
			 exit;  
		}
	}
	
	function getNews($req){
		//TODO : make it safe to access path_info[0]. Prevent sql injection please. 
		$path_info = $req->getPathInfo();
		//var_dump($path_info); 
		$id = $path_info[1]; 
		$noticia = new Noticia(); 
		$n = $noticia->findFirst(array ("idnoticia" => $id));
		if (!$n){
			RestUtils::sendResponse(404);
			exit; 
		}
		if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null, json_encode($n)); 
		}
		else if ($req->getHttpAccept() == 'text/xml'){
			global $options; $options["rootName"] = "noticia"; 
			$xmlSerializer =  new XML_Serializer($options); 
			$n->visivel = null; // we do not want this to show on the result.  
			$result = $xmlSerializer->serialize($n);
			if ($result == true){
				RestUtils::sendResponse(200, null, $xmlSerializer->getSerializedData(), 'text/xml');
			} else {
				RestUtils::sendResponse(500); 
			}
		}else{
			RestUtils::sendResponse(406); 
		}
	}
	
    /*
     * Checks if the request is valid through whitelistening of the possible request types.
     * Deals with query variables, path info, method types, etc. 
     */
    function checkRequest($req){
    //Variables that should be defined for checkRequest. Ideally this would be defined in a abstact/general form. 
 	$methods_supported = array("GET", "POST", "HEAD", "DELETE", "PUT");
 	$request_vars = array();
 	
    	if (array_search($req->getMethod(), $methods_supported ) === FALSE){
    		//405 -> method not supported 
    		RestUtils::sendResponse(405, array('allow' => $methods_supported));
    		exit;  
    	}
    		
    	//check the request variables that are not understood by this resource
    	$dif = array_diff($req->getRequestVars(), $request_vars);
    	//If they are differences then we do not understand the request.  
    	 if ( count($dif)  != 0 ){
    		RestUtils::sendResponse(400, array('unrecognized_req_vars' => $dif));
    		exit; 
    	}
    	    	
    	//TODO - check that path parameters are correct through regulares expressions that validate input types and formats. 
    	//could respond BadRequest also. 
    }
?>
