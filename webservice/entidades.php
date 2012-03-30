<?php

/* 
 * 
 * / | GET | Listar todas as entidades existentes. Representa��o em XML/JSON deve separar 
 * convenientemente nos dois grupos principais (clubes, integrantes). 
 * Representa��o cont�m apontadores para os recursos dentro do servi�o.
 *
 * /clubes |  GET | Listar todos os clubes existentes.
 *
 * /clubes | POST | Adicionar um clube novo. 
 * Conteudo do pedido em XML deve especificar informa��o necess�ria e obrigatoria 
 * (e.g., nome oficial do clube).  Retorna o identificador �nico do clube. 
 * 
 * /clubes/nomeClube , /clubes/idClube |  GET | Representa��o da informa��o do Clube em XML/JSON. 
 *  
 * /integrantes | GET | Listar todos os integrantes existentes.
 * 
 * /integrantes/ |  POST | Adicionar uma entidade nova. Conteudo do pedido em XML. 
 * Retorna o identificador unico de um integrante.
 *  
 * /integrantes/nomeIntegrante  , /integrantes/idIntegrante | GET | Representa��o de uma entidade em XML/
 * 
 */
 
 require_once ('Util/RestUtils.php'); 
 require_once ('Util/RestRequest.php'); 
 require_once ('Util/XML/Serializer.php'); 
 require_once ('../model/Noticia.php'); 
 require_once ('../model/Integrante.php');
 require_once ('../model/Clube.php'); 
 
 	$options = array(
      "indent"          => "    ",
      "linebreak"       => "\n",
      "typeHints"       => false,
      "addDecl"         => true,
      "encoding"        => "UTF-8",
      XML_SERIALIZER_OPTION_RETURN_RESULT => true, 
      "ignoreNull"      => true,
 	); 
 	

	$req  = RestUtils::processRequest();  // The request made by the client.
	checkRequest($req);   // check that the request is valid. Dies otherwise.  
	  
	  //Dispatching according to the path info. 
	  $path_parameters = $req->getPathInfo(); 
	  $path_parameters_count = count($path_parameters);
	  
	  switch($path_parameters_count){
		case 0: 		  	
	  		processRoot($req);
	  		break; 
	  	case 1: // /clubes, /integrantes, ... 
	  		processEntidade($req);
	  		break;
	  	case 2: 
	  		processEntidadeEspecifica($req); 
	  } 

	// Process resource head (/entidades/) requests. Accepts GET/HEAD
	
	/*
	 * TODO: 
	 * HEAD
	 */
	function processRoot($req){
		switch($req->getMethod()){
			case 'GET': 
				getRoot($req);
			break;
			case 'HEAD': 
				postHead($req);
			break;
			default:
				RestUtils::sendResponse(405, array('allow' => "HEAD", "GET"));
				exit; 
		}			
	} 
		
	/**
	 * Listar todas as entidades 
	 * Representa��o em XML, JSON que devem conter apontadores para o recurso de cada entidade.
	 * Representa��o tambem deve saber em grupos de entidade  
	 **/
	function getRoot($req){
/*		$clube = new Clube();
		$clubes =$clube->getAll();
		if (!$clubes) { RestUtil::sendResponse(500); exit; }
		$integrantes = $integrante->getAll();
		if (!$integrantes) {RestUtil::SendResponse(500); exit; }
*/
		$clube = new Clube();

		$clube->setIdclube("Um campo numerico identificando univocamente o clube"); 
		$clube->setIdcompeticao("Um identificador numerico identificando a competicao em que o clube se encontra"); 
		$clube->setIdlocal("Um identificador numerico identificando o local do clube");
		$clube->setNome_clube("O nome do clube"); 
		$clube->setNome_oficial("O nome oficial do clube");
		$clube->follow = "url/follow/clubes"; 
		
		//TODO : follow local, competi�ao, etc. 
		$integrante = new Integrante();
		$integrante->setIdclube("um campo numerico identificando univocamente o clube associado actualmente ao integrante"); 
		$integrante->setIdfuncao("Um campo numerico identificando a funcao do integrante"); 
		$integrante->setIdintegrante("Um campo numerico identificano univocamente o integrante");
		$integrante->setNome_integrante("O nome completo do integrante");
		
		//TODO get current url 
		$integrante->follow = "url/follow/integrantes";
		$result = array($clube, $integrante); 
		if ($req->getHttpAccept() == 'text/xml'){
			global $options; $options["rootName"] = "entidades"; $options["defaultTagName"]  = "entidade";  
			
			$xmlSerializer =  new XML_Serializer($options); 
			//var_dump($news); 
			$result = $xmlSerializer->serialize($result);
		if ($result == true){
			RestUtils::sendResponse(200, null, $xmlSerializer->getSerializedData(), 'text/xml'); 
		}
		else{
			RestUtils::sendResponse(500); 
			}
		}
		else if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null,  json_encode($result)); 
		}
		else{
			RestUtils::sendResponse(406); 
		}
		//TODO - send malformed request response
	}

	
	//Process resource (/entidade/{clubes} , /entidade/{integrantes}) requests. 
	//Accepts GET/PUT/HEAD/DELETE
	
	/*
	 * TODO: 
	 * POST 
	 * HEAD
 	*/
	function processEntidade($req){
		//TODO - make it safe to get here
		$entidade = $req->getPathInfo(); $entidade = $entidade[1];
		switch($req->getMethod()){
			case 'GET': 
				getEntidade($req, $entidade);
			break; 
			case 'POST':
			break;
			case 'HEAD':
			break; 
			default: 
			 RestUtils::sendResponse(405, array('allow' => "HEAD", "POST", "GET"));
			 exit;  
		}
 }
	
	
	function getEntidade($req, $entidade){
		$bdEnt = new $entidade(); 
		$entrys = $bdEnt->getAll(); 
		if (!$entrys){ RestUtils::sendResponse(404);exit; }
		
		foreach ($entrys as $en){
			$id = strtolower($entidade) ==  'clube' ?  $en->getIdClube() : $en->getIdIntegrante(); 
			$en->follow = "url/" . $entidade . "/" . $id;  
		}

		
		
		
		if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null, json_encode($entrys)); 
		}
		else if ($req->getHttpAccept() == 'text/xml'){
			global $options; $options["rootName"] = get_class($bdEnt) .  "s"; $options["defaultTagName"]  = get_class($bdEnt); 
			$xmlSerializer =  new XML_Serializer($options); 
			$n->visivel = null; // we do not want this to show on the result.  
			$result = $xmlSerializer->serialize($entrys);
			if ($result == true){
				RestUtils::sendResponse(200, null, $xmlSerializer->getSerializedData(), 'text/xml');
			} else {
				RestUtils::sendResponse(500); 
			}
		}else{
			RestUtils::sendResponse(406); 
		}
	}
	
	/**
	 * Processa entidade especifica como /clube/idClube ou /integrante/idIntegrante
	 * Suporta 
	 * GET, HEAD, PUT, DELETE
	 */
	function processEntidadeEspecifica($req){
		//TODO - make it safe to access this info
		$path = $req->getPathInfo(); 
		$ent = $path[1]; 
		$id = $path[2]; 
		switch($req->getMethod()){
			case 'GET': 
				getDeEntidade($req, $ent, $id); 
				break;
			case 'HEAD': 
			 	break; 
			 case 'PUT': 
			 	break; 
			 case 'DELETE': 
			 	break; 
			 default :
			 	RestUtils::sendResponse(405, array('allow' => "HEAD", "GET", "PUT", "DELETE"));
		}
	} 
	
	function getDeEntidade($req, $ent, $id){
		$bdEnt = new $ent(); 
		$key = (strtolower($ent) == 'clube') ? "idclube" : "idintegrante";   
		$entry = $bdEnt->findFirst( array($key => $id));
		if (!$entry){ RestUtils::sendResponse(404);exit; }
		
		if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null, json_encode($entry)); 
		}
		else if ($req->getHttpAccept() == 'text/xml'){
			//TODO descricao est� cheio. 
			global $options; $options["rootName"] = $ent ; $options["defaultTagName"]  = "descricao"; 
			$xmlSerializer =  new XML_Serializer($options); 
			$result = $xmlSerializer->serialize($entry);
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