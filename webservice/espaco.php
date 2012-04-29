<?php
@header('Content-Type: text/html; charset=utf-8');
/*
 * Created on Mar 29, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require_once ('Util/RestUtils.php'); 
 require_once ('Util/RestRequest.php'); 
 require_once ('Util/XML/Serializer.php'); 
 require_once ('../model/Local.php');
 require_once ('../model/Noticia_locais.php');
  
 	function getUrl(){
 		$v = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
 		
 		$r = $v['scheme'] . '://' . $v['host'] . $v['path'];
 		$pos = strpos($r, 'espaco.php') ;
 		$val = substr($r, 0, $pos );
 		return $val; 
 	}
 	
 $options = array(
      "indent"          => "    ",
      "linebreak"       => "\n",
      "typeHints"       => false,
      "addDecl"         => true,
      "encoding"        => "UTF-8",
      XML_SERIALIZER_OPTION_RETURN_RESULT => true,
      XML_SERIALIZER_OPTION_CLASSNAME_AS_TAGNAME => true,  
       "rootAttributes"  => array("xmlns" => "localhost", "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance", "xsi:schemaLocation" => "localhost Locais.xsd "),
      "namespace" 		=> "localhost", 
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
	  	case 2:  
	  	case 1:
	  		processLocal($req);
	  		break;  
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
				//postHead($req);
			default:
				RestUtils::sendResponse(405, array('allow' => "GET POST"));
				exit; 
		}			
	}
	
	function postRoot($req){
		$espaco = new Local();
		
		if (!$espaco->validateXMLbyXSD($req->getData(), "Local.xsd")){
			RestUtils::sendResponse(400); 
		}
		
		$result = $espaco->fromXml($req->getData());
		
		if ($result->checkValidity() == true ){
			if (isset($result->idlocal)){
				RestUtils::sendResponse(406); 
			}
			try{
				$id = $result->add();
			}catch(Exception $e){
				RestUtils::sendResponse(500); 
			} 
			RestUtils::sendResponse(201, null, $id, 'text'); 
		}
		else{
			RestUtils::sendResponse(406); 
		} 		 
	}

	/**
	 * Listar todas os espa�os 
	 * Representa��o em XML, JSON que devem conter apontadores para o recurso de cada local.  
	 * TODO : filtrar pesquisa. 
	 **/
	function getRoot($req, $ll=null){
		$local = new Local();
		if (!isset($ll)){
			try{
				$locais =$local->getAll(null);
			}catch(Exception $e){
				RestUtils::sendResponse(500); 
			}
			if (count($locais) == 0){
				RestUtils::sendResponse(404); 
			}
		}
		else{
			$locais = $ll;  
		}
		foreach ($locais as $n){ $n->follow = getUrl() . 'espaco.php/' . $n->idlocal; }
		if ($req->getHttpAccept() == 'text/xml'){
		
			global $options; $options["rootName"] = "locais";  $options["defaultTagName"] = "local";   
			$xmlSerializer =  new XML_Serializer($options); 
			$result = $xmlSerializer->serialize($locais);
			
			if ($result == true){
				$xmlResponse = $xmlSerializer->getSerializedData();
				//RestUtils::sendResponse(200, null,$xmlResponse , 'text/xml');
				if($local->validateXMLbyXSD($xmlResponse, "Locais.xsd")) {
					RestUtils::sendResponse(200, null,$xmlResponse , 'text/xml');
				}
				else {
					RestUtils::sendResponse(400);
				} 
			}
			else{
				RestUtils::sendResponse(500); 
			}
		}
		else if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null,  json_encode($locais)); 
		}
		else{
			RestUtils::sendResponse(406); 
		}
	}
	
	//Process resource (/local/{idlocal}) requests. Accepts GET/PUT/HEAD/DELETE
/*
 * TODO: 
 * PUT
 * HEAD
 * DELETE
 */
 
	function processLocal($req){
		$path_info = $req->getPathInfo();
		$id = $path_info[1];
		
		$Local = new Local();
		if (is_numeric($id)){
			try{ 
				$l = $Local->getObjectById($id);
			}catch(Exception $e){
				RestUtils::sendResponse(500); 
			}
			if (!isset($l)){
				RestUtils::sendResponse(404); 
			}
		}else{
			if ($req->getMethod() != 'GET'){
				RestUtils::sendResponse(405, array('allow' =>  "GET"));
			}
			$id = '%' . mysql_real_escape_string($id) . '%';
			try{			
				$locais = $Local->find(array("nome_local" => $id), ' LIKE ');
			}catch(Exception $e){
				RestUtils::sendResponse(500); 
			}
			if (count($locais) == 0){
				RestUtils::sendResponse(404); 
			}
			getRoot($req, $locais); 
		}
		
		switch(count($path_info)){
			case 1 :
		switch($req->getMethod()){
			case 'GET': 
				getLocal($req, $id, $l);
			break;
			case 'PUT':
				putLocal($req, $id, $l); 
			break;
			case 'DELETE':
				deleteLocal($id, $l);
			break;
			case 'HEAD': 
			default: 
			 RestUtils::sendResponse(405, array('allow' =>  "PUT DELETE GET"));
		}
		break;
		case 2: 
			if ($req->getMethod()){
				if (strcmp($path_info[2], 'noticias' )!==false){
					getLocalNoticia($req,$id, $l);
				}else{
					RestUtils::sendResponse(404); 
				}
			}else{
				RestUtils::sendResponse(405, array('allow' =>  "GET"));
			}
		}
	}
	
	function deleteLocal($id,$l){
		try{
			$l-del(); 
		}catch(Exception $e){
			RestUtils::sendResponse(500); 
		}
		RestUtils::sendResponse(204, null, '', 'text');
	}
	
	function putLocal($req, $id, $l){
		$local = new Local();
		$xmlHttpContent = $req->getData();
		if(!$local->validateXMLbyXSD($xmlHttpContent, "Local.xsd")) {
		 	RestUtils::sendResponse(400, null, "XML mal formado!", "text/plain");
		}
		
		$new_local = $local->fromXml($xmlHttpContent);

		if (isset($new_local->idlocal) && $new_local->idlocal != $l->idlocal){
			RestUtils::respond(400); 
		}
		
		if ($new_local  && $new_local->checkValidity() ){
				$new_local->idlocal = $id;
				try{
					$new_local->update();
					RestUtils::sendResponse(204); 
				}catch(Exception $e){
					RestUtils::sendResponse(500); 
				}
		}
		else{
			RestUtils::sendResponse(400); 
		}
	}

	function getLocalNoticia($req,$id, $l){
		$n = $l; 
		
		try{
			$n->noticias = Noticia_Locais::getAllNoticias($id);
		}catch(Exception $e){
			RestUtils::sendResponse(500);
		}
		respond($n, $req); 
	}
		
	function getLocal($req, $id, $n){
		respond($n, $req); 
	}

	function respond($n, $req){
		if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null, json_encode($n)); 
		}
		else if ($req->getHttpAccept() == 'text/xml'){
			global $options; $options["rootName"] = "Local"; 
	       	$options["rootAttributes"] = array("xmlns" => "localhost", "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance", "xsi:schemaLocation" => "localhost Local.xsd "); 

			$xmlSerializer =  new XML_Serializer($options); 
			$n->visivel = null; // we do not want this to show on the result.  
			$result = $xmlSerializer->serialize($n);
			if ($result == true){
				$xmlResponse = $xmlSerializer->getSerializedData();
				RestUtils::sendResponse(200, null,$xmlResponse , 'text/xml');
				/*if($n->validateXMLbyXSD($xmlResponse, "Local.xsd")) {
					RestUtils::sendResponse(200, null,$xmlResponse , 'text/xml');
				}
				else {
					RestUtils::sendResponse(500);
				}*/
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
 	$request_vars = array("start", "count", "texto");
 	
    	if (array_search($req->getMethod(), $methods_supported ) === FALSE){
    		//405 -> method not supported 
    		RestUtils::sendResponse(405, array('allow' => $methods_supported));
    		exit;  
    	}
    	
    	//check the request variables that are not understood by this resource
    	$dif = array_diff(array_keys($req->getRequestVars()), $request_vars);
    	//If they are differences then we do not understand the request.  
    	 if ( count($dif)  != 0 ){
    		RestUtils::sendResponse(400, array('unrecognized_req_vars' => $dif));
    		exit; 
    	}
    	
    	//TODO - check that path parameters are correct through regulares expressions that validate input types and formats. 
    	//could respond BadRequest also. 
    }
?>
