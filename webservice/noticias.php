<?php
 
 require_once ('Util/RestUtils.php'); 
 require_once ('Util/RestRequest.php'); 
 require_once ('Util/XML/Serializer.php'); 
 require_once ('../model/Noticia.php');
 require_once ('./Util.php');    
  
 /*
  * Documenta�‹o dos mŽtodos suportados neste url: 
	/ | GET | Listar todas as noticias. Representa�‹o em XML, JSON e XHTML que devem conter apontadores para o recurso de cada noticia.  Por parametro Ž possivel especificar palavras chaves de forma a filtrar os resultados (i.e., permitir escolher noticias que referem o clube X.).

	/ | POST |  Coloca�‹o de  uma noticia nova. O corpo do pedido deve  conter a descri�‹o da noticia em XML . Ser‡ retornado o identificador œnico da noticia decidido pelo servi�o.

	/idNoticia | GET | Retorna o conteudo e informa�‹o relativa a uma noticia, incluindo rela�›es como referencias temporais, referencias espaciais, clubes , etc., A representa�‹o ser‡ em XML, JSON e XHTML.  
 **/
 	
 	
 	
 	function getUrl(){
 	$v = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
 	 

 	$r = $v['scheme'] . '://' . $v['host'] . $v['path'];
 	$pos = strpos($r, 'noticias.php') ;
 	$val = substr($r, 0, $pos );
 	
 	return $val;    		
 	}

    $options = array(
      "indent"          => "    ",
      "linebreak"       => "\n",
      "typeHints"       => false,
      "addDecl"         => true	,
      "encoding"        => "UTF-8",
      XML_SERIALIZER_OPTION_RETURN_RESULT => true,
      XML_SERIALIZER_OPTION_CLASSNAME_AS_TAGNAME => true,  
      "ignoreNull"      => true,
      "rootAttributes"  => array("xmlns" => "localhost", "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance", "xsi:schemaLocation" => "localhost Noticias.xsd "),
      "namespace" 		=> "localhost"
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
			RestUtils::sendResponse(404);
			exit;  
	  } 
	 
	// Process resource head (/noticias) requests. Accepts GET/POST  
	function processRoot($req){
		switch($req->getMethod()){
			case 'GET': 
				getRoot($req);
				break;
			case 'POST': 
				postRoot($req);
			break;
			case 'HEAD':
				//headRoot();
			default:
				RestUtils::sendResponse(405, array('allow' =>"GET POST"));
				exit; 
		}			
	}
	
	function headRoot(){
		$news = getAllNews();
		$hash = md5(var_export($news,true));
		RestUtils::sendResponseHead($hash);
	}
	
	function getAllNews(){
		$noticia = new Noticia();
		try{
			$news =$noticia->getAll(array("idnoticia","data_pub", "assunto", "descricao", "url"));
		}catch(Exception $e){
			RestUtils::sendResponse(500);
			exit;  
		}
		
		foreach ($news as $n){
			$n->follow = getUrl() .'noticias.php/'.   $n->idnoticia;
			$n->visivel = null;  
		}
		
		return $news;
	}
	
	function getHashObject($ob){
		$hash = md5(var_export($ob, true)); 
	}
	
	/**
	 * Listar todas as noticias. 
	 * Representação em XML, JSON que devem conter apontadores para o recurso de cada noticia.  
	 * Por parametro (search=SEARCH_STRING) é possivel especificar palavras chaves de forma a filtrar os resultados (i.e., permitir escolher noticias que referem o clube X.).
	 * TODO : filtrar pesquisa. 
	 **/
	function getRoot($req){
		$news = getAllNews($req); 
		
		$news = getAllNews($req);
		 //TODO - HEAD
		//if ($req->getEtag() != null && $req->getEtag() == getHashObject($news)){
			//RestUtils::sendResponse(304); 	
		//}
		
		foreach ($news as $n){
			//$n->follow = "myUrl/" . $n->idnoticia;
			$n->visivel = null; 
		}
		
		if ($req->getHttpAccept() == 'text/xml'){
				global $options; $options["rootName"] = "noticias";
				$xmlSerializer =  new XML_Serializer($options);
			//$xmlSerializer->setOption("namespace",array("localhost", "localhost"));
				$result = $xmlSerializer->serialize($news);

		if ($result == true){
			$xmlResponse = $xmlSerializer->getSerializedData();
			$noticia = new Noticia();
						
			//RestUtils::sendResponse(200, null,$xmlResponse , 'text/xml');
			
			if($noticia->validateXMLbyXSD($xmlResponse, "Noticias.xsd")) {
				RestUtils::sendResponse(200, null,$xmlResponse , 'text/xml');
			}
			else {
				RestUtils::sendResponse(500);
			}
		}
		else{
				RestUtils::sendResponse(500); 
			}
		}
		else if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null,  json_encode($news)); 
		}
		else{
			//Not Acceptable. 
			RestUtils::sendResponse(406); 
		}
		RestUtils::sendResponse(400); 
	}
	}
	
	
	
	
	//Process resource (/noticias/{idnoticia}) requests. Accepts GET/PUT/HEAD/DELETE

/*
 * TODO: 
 * PUT
 * HEAD
 * DELETE
 */
	function processNews($req){
	//TODO : make it safe to access path_info[0]. Prevent sql injection please.
	$path_info = $req->getPathInfo();
	  
	$id = $path_info[1];
	
	if (!is_numeric($id)){
		RestUtils::sendResponse(400);
	}
	
		switch($req->getMethod()){
			case 'GET': 
			getNews($req, $id);
			break; 
			case 'PUT':
			putNews($req, $id); 
			break;
			case 'HEAD':
			break; 
			case 'DELETE':
			break; 
			default: 
			 RestUtils::sendResponse(405, array('allow' => "PUT DELETE GET"));
			 exit;  
		}
	}
	
	
	/**
	 * Post to /noticias . 
	 * Must create new news and return the identifier  of that news  
	 * Similiar to putNews
	 */
	function postRoot($req){
		$noticia = new Noticia(); 

		$n = $noticia->fromXml($req->getData());
		
		if (!isset($n) || checkRelations($n)  === false || isset($n->idnoticia)){
			RestUtils::sendResponse(400);
			exit; 
		}
		
		$n->texto =  Noticia::fetchTexto($n->url);
		$n->idfonte = Utill::getIdWebServiceAsFonte();

		try{
			$id = addNoticia($n, 'add');
		}catch(Exception $e){
			RestUtils::sendResponse(500);
		} 		
		
		if (isset($id)){
			RestUtils::sendResponse(201, null, $id, 'text');
	
		}else{
			RestUtils::sendResponse(500);
		}
	}
	
		
	function putNews($req, $id){
		$noticia = new Noticia();
		
		try{ 
			$n = $noticia->getObjectById($id);
		}catch(Exception $e){
			RestUtils::sendResponse(500); 
		}
		
		if (!isset($n)) {
			RestUtils::sendResponse(404); 	
		}
		
		$nova_noticia = $noticia->fromXml($req->getData());
		if ($nova_noticia === null || checkRelations($nova_noticia)===false ||
			// se existir id de noticia no gajo nao pode ir.  
			(isset($nova_noticia->idnoticia) && ($nova_noticia->idnoticia !=  $id))){ 
			RestUtils::sendResponse(400);
			exit;
		}
		
		$nova_noticia->idnoticia =$id; 
		addNoticia($nova_noticia, "update");
		RestUtils::sendResponse(200);
		exit;   
	}
	
	function addNoticia($nova_noticia, $foo){
		if (isset($nova_noticia->locais )) {
			$locais = $nova_noticia->locais ;
			unset($nova_noticia->locais); 
		}
		if (isset($nova_noticia->clubes )) {
			$clubes = $nova_noticia->clubes;
			unset($nova_noticia->clubes); 
		}
		if (isset($nova_noticia->integrantes)) {
			$integrantes = $nova_noticia->integrantes ;
			unset($nova_noticia->integrantes); 
		}   
		if (isset($nova_noticia->datas)){
		 	$datas = $nova_noticia->datas;
		 	unset($nova_noticia->datas);  	
		}
		
		if ($nova_noticia){
		$nova_noticia->texto = Noticia::fetchTexto($nova_noticia->url);
		$nova_noticia->idfonte = Utill::getIdWebServiceAsFonte();
		
			try{
				$r = $nova_noticia->$foo();
				if (isset($r)){
					$nova_noticia->idnoticia = $r; 
				} 
			}catch(Exception $e){
				RestUtils::sendResponse(500);
				exit;  
			}
		if (isset($locais )) {
			$nova_noticia->locais = $locais; 
		}
		if (isset($clubes )) {
			$nova_noticia->clubes = $clubes; 
		}
		if (isset($integrantes)) {
			$nova_noticia->integrantes = $integrantes ;
		}   
		if (isset($datas)){
		 	$nova_noticia->datas = $datas;
		}
		
		updateRelations($nova_noticia);
		return $r; 
		}
	}
	
	function checkRelations($noticia){
		if (isset($noticia->locais)){
			foreach ($noticia->locais as $l){
				if (!isset($l->idlocal) ) {
					return false; 
				}
			}
		}
		
		if (isset($noticia->clubes)){
			foreach ($noticia->clubes as $l){
				if (!isset($l->idclube)) 
					return false; 
			}		
		}
		if (isset($noticia->integrantes)) {
			foreach($noticia->integrantes as $l)
				if (!isset($l->idintegrante))	
					return false;
		}
	}
	
	function updateRelations($noticia){
		$locais_classe = new Noticia_locais();
		$integrantes_classe = new Noticia_Data(); 
		$clubes_classe = new Noticia_Has_Clube();
		$datas_classe = new Noticia_Data();
		 
		try{ 
			$locais_classe->deleteById($noticia->getIdNoticia());
			$clubes_classe->deleteById($noticia->getIdNoticia());
			$integrantes_classe->deleteById($noticia->getIdNoticia());
			$datas_classe->deleteById($noticia->getIdNoticia());
		}catch (Exception $e){
			RestUtils::sendResponse(500);
			exit;  
		}
		
		if (isset($noticia->locais)){
			foreach ($noticia->locais as $l){
				
				$rel = new Noticia_Locais($noticia->idnoticia, $l->idlocal);
				try{
					$rel->add();
				}catch(Exception $e){
					RestUtils::sendResponse(500);
					exit;  
				}
			}
		}
		
		if (isset($noticia->clubes)){
			foreach($noticia->clubes as $l){
				try{
					$rel = new Noticia_Has_Clube($noticia->idnoticia, $l->idclube , $l->qualificacao );
					$rel->add();
				}catch(Exception $e){
					RestUtils::sendResponse(500);
					exit;  
				}
			}	
		}
		
		
		if (isset($noticia->integrantes)){
			foreach($noticia->integrantes as $l){
				try{
					$rel = new Noticia_Has_Integrante($noticia->idnoticia, $l->idintegrante , $l->qualificacao );
					$rel->add();
				}catch(Exception $e){
					RestUtils::sendResponse(500);
					exit;  
				}
			}	
		}
		
		
		 
		if (isset($noticia->datas)){
			foreach($noticia->datas as $l){
				 try{
//				 	echo $l->__toString();
					$rel = new Noticia_Data($noticia->idnoticia, '' ,$l->__toString());
					$rel->add();
				}catch(Exception $e){
					RestUtils::sendResponse(500);
					exit;  
				}
			}	
		}
		
	}
	
	function getNews($req, $id){
		$noticia = new Noticia();
		
		try{
		$n = $noticia->getRelationArray($id, getUrl()); 
		}catch(Exception $e){
			RestUtils::sendResponse(500);
		}
		
		if ($n == null){
			RestUtils::sendResponse(404); 
		}
		
		if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null, json_encode($n)); 
		}
		else if ($req->getHttpAccept() == 'text/xml'){
			global $options; $options["rootName"] = "noticia";
			$options['defaultTagName'] = 'data';
			$xmlSerializer =  new XML_Serializer($options); 
			
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
