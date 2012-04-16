<?php
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
		$result = $espaco->fromXml($req->getData());
		
		if ($result->checkValidity() == true){
			$id = $result->add(); 
			if (!$id){
				RestUtils::sendResponse(500);
				exit; 
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
	 
	function getRoot($req){
		$local = new Local();
		try{
		$locais =$local->getAll(null);
		}catch(Exception $e){
			RestUtils::sendResponse(500); 
		}
		
		foreach ($locais as $n){ $n->follow = getUrl() . 'espaco.php/' . $n->idlocal; }
		
		if ($req->getHttpAccept() == 'text/xml'){
		
			global $options; $options["rootName"] = "locais";  $options["defaultTagName"] = "local";   
			$xmlSerializer =  new XML_Serializer($options); 
		
			//var_dump($news); 
			$result = $xmlSerializer->serialize($locais);
		
			if ($result == true){
				RestUtils::sendResponse(200, null, $xmlSerializer->getSerializedData(), 'text/xml'); 
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
		//var_dump($path_info); 
		$id = $path_info[1]; 
		switch($req->getMethod()){
			case 'GET': 
				getLocal($req, $id);
			break; 
			case 'PUT':
				putLocal($req, $id); 
			break;
			case 'HEAD':
			break; 
			case 'DELETE':
				deleteLocal($id);
			break; 
			default: 
			 RestUtils::sendResponse(405, array('allow' => "HEAD", "PUT", "DELETE", "GET"));
			 exit;  
		}
	}
	
	function deleteLocal($id){
		$validID = settype($id, "integer");
		$local = new Local(); 
		$local->getObjectById($id);
		if (!$local || !$validID){
			RestUtils::sendResponse(404);
			exit();
		}
		
		$local->del();
		RestUtils::sendResponse(200);
	}
	
	function putLocal($req, $id){
		$local = new Local(); 
		$local->getObjectById($id);
		if (!$local){
			RestUtils::sendResponse(404);
			exit();
		}
		$new_local = $local->fromXml($req->getData());
		if ($new_local  && $new_local->checkValidity() ){
				$new_local->idlocal = $id;
				$new_local->update();   
		}
		else{
			//TODO send bad format 
		}
	}
	
	function getLocal($req, $id){
		//TODO : make it safe to access path_info[0]. Prevent sql injection please. 
		$local = new Local(); 
		$n = $local->findFirst(array ("idlocal" => $id));
		$n->noticias = Noticia_Locais::getAllNoticias($id); 
		if (!$n){
			RestUtils::sendResponse(404);
			exit; 
		}
		if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null, json_encode($n)); 
		}
		else if ($req->getHttpAccept() == 'text/xml'){
			global $options; $options["rootName"] = "local"; 
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
 	$request_vars = array("start", "count");
 
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
