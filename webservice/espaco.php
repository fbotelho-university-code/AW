<?php
@header('Content-Type: text/html; charset=utf-8');

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
	  	case 4:
	  		processCoordenadas($req);
	  		break; 
	  	default: 
	  		RestUtils::sendResponse(); 
	  } 
	       
	  function processCoordenadas($req){
	  	$result = $req->getPathInfo();
	  	for ($i = 1 ; $i < 5 ; $i++){
	  		if (!is_numeric($result[$i])){
	  			RestUtils::sendResponse(404);
	  		}
	  	}
	  	
	  	$local = new Local();
	  	$results = $local->getBetween($result[1], $result[2], $result[3], $result[4]);
	  	getCompleteNewsLocaisSmallNews($results, $req); 
	  }
	  
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
				$locais =$local->getAll();
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
		
		RestUtils::webResponse($locais, $req, 'locais', 'Locais.xsd',  'local'); 
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
				$n->visivel = null; // we do not want this to show on the result.
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
			getCompleteNewsLocais($locais, $req); 
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
			$l->del(); 
		}catch(Exception $e){
			RestUtils::sendResponse(500); 
		}
		RestUtils::sendResponse(204, null, '', 'text');
	}
	
	/**
	 * 
	 * @param unknown_type $locais array de locais
	 */
	function getCompleteNewsLocaisSmallNews($locais, $req){
		foreach ($locais as $l){
			$l->noticia = Noticia_locais::getAllNoticias($l->idlocal, getUrl()); 
		}
		RestUtils::webResponse($locais, $req, 'locais', 'Locais.xsd', 'data'); 
	}
	
	function getCompleteNewsLocais($locais, $req){
		
		$rel = new Noticia_locais();
		foreach ($locais as $l){
			$l->noticias = $rel->getAllNews($l->idlocal, getUrl());
		}
		RestUtils::webResponse($locais, $req, 'locais', 'Locais.xsd', 'data');
		
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
		$rel = new Noticia_locais(); 
		try{
			$n->noticias =  $rel->getAllNews($l->idlocal, getUrl());
		}catch(Exception $e){
			RestUtils::sendResponse(500);
		}
		RestUtils::webResponse($n, $req, 'locais', 'Locais.xsd', 'data');

	}

	function getLocal($req, $id, $n){
		RestUtils::webResponse($n, $req, 'Local', "Local.xsd"); 
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
    }
?>
