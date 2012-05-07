<?php
@header('Content-Type: text/html; charset=utf-8'); 
 require_once ('Util/RestUtils.php'); 
 require_once ('Util/RestRequest.php'); 
 require_once ('Util/XML/Serializer.php'); 
 require_once ('../model/Noticia.php');
 require_once ('../model/Noticia_Bin.php');
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
	  	case 2: 
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
	
/*	function headRoot(){
		$news = getAllNews();
		$hash = md5(var_export($news,true));
		RestUtils::sendResponseHead($hash);
	}
	*/
	function getAllNews(){
		$noticia = new Noticia();
		try{
			$news =$noticia->getAll(array("idnoticia","data_pub", "assunto", "descricao", "url"));
		}catch(Exception $e){
			RestUtils::sendResponse(500);
			exit;  
		}
		if (count($news) == 0){
			RestUtils::sendResponse(404); 
		}
	
		foreach ($news as $n){
			$n->follow = getUrl() .'noticias.php/'.   $n->idnoticia;
		}
		
		return $news;
	}

	
	/**
	 * Listar todas as noticias. 
	 * Representação em XML, JSON que devem conter apontadores para o recurso de cada noticia.  
	 * Por parametro (search=SEARCH_STRING) é possivel especificar palavras chaves de forma a filtrar os resultados (i.e., permitir escolher noticias que referem o clube X.).
	 * TODO : filtrar pesquisa. 
	 **/
	function getRoot($req){
		$news = getAllNews($req);
		RestUtils::webResponse($news, $req, 'noticias', 'Noticias.xsd');
	}
	
	//Process resource (/noticias/{idnoticia}) requests. Accepts GET/PUT/HEAD/DELETE

 /* TODO: 
 * PUT
 * HEAD
 * DELETE
 */
	function processNews($req){
	//TODO : make it safe to access path_info[0]. Prevent sql injection please.
	$path_info = $req->getPathInfo();
	$id = $path_info[1];

	//Valid id : numeric. Check if it exists in the database. 

	if (is_numeric($id)){
		$n = new Noticia(); 
		try{
			$n = $n->getObjectById($id);
		}catch (Exception $e){
			RestUtils::sendResponse(500); 
		}
		if (!isset($n)){
			RestUtils::sendResponse(404); 
		}
	}else{
		RestUtils::sendResponse(404); 
	}

	
	// >= no futuro
	if (count($path_info) == 2){
		$keyword = $path_info[2]; 
		if (strcmp($keyword, 'comentarios') != 0){
			RestUtils::sendResponse(404); 
		}
		switch($req->getMethod()){
			case 'GET':
				getComments($req, $n);  
			break; 
			default: 			
			RestUtils::sendResponse(405, array('allow' => "GET"));
		}
	}
		switch($req->getMethod()){
			case 'GET':
			getNews($req, $id, $n);
			break; 
			case 'PUT':
			putNews($req, $id,$n); 
			break;
			case 'POST': 
			postComment($req,$n);
			break; 
			case 'HEAD':
				getHeadNew($req, $id, $n); 
			break; 
			case 'DELETE':
				deleteNewsFingir($id,$n);
			break; 
			default: 
				RestUtils::sendResponse(405, array('allow' => "PUT DELETE GET POST"));
			 
		}
	}
	
	function getHeadNew($req, $id, $n){
			RestUtils::sendResponseHead(); 
	}
	
	function postComment($req, $n){
		$Comment = new Comentario();

		$xmlHttpContent = $req->getData();
		
		
		 /*if(!$Comment->validateXMLbyXSD($xmlHttpContent, "Comentario.xsd")) {
			RestUtils::sendResponse(400, null, "XML mal formado!", "text/plain");
		 }
		 */
		 
		$comment = $Comment->fromXml($xmlHttpContent);
		if ($comment->idnoticia != $n->idnoticia){
			RestUtils::sendResponse(400); 
		}
		try{
			$r = $comment->add();
			
		}catch(Exception $e){
			echo $e; 
			RestUtils::sendResponse(500); 
		}
		
		//Created. 
		RestUtils::sendResponse(201, null, $r, 'text'); 
	}
	
	function getComments($req, $n){
		$Comment = new Comentario();
		try{
			$res = $Comment->find(array("idnoticia" => $n->idnoticia), ' = ', array("comentario", "user","time"));
		}catch(Exception $e){
			RestUtils::sendResponse(404); 
		}
		if (count($res) == 0){
			RestUtils::sendResponse(404); 
		}
		RestUtils::webResponse($res, $req, "Comentarios", null, "comentario");
	}
	
	function deleteNewsFingir($id, $n){
		// Criar noticia_bin
		$noticia_bin = new Noticia_Bin($n);
		try{
			$noticia_bin->add();
			//Apagar noticia
			$n->del();
		}catch(Exception $e){
			RestUtils::sendResponse(500);
		}
		RestUtils::sendResponse(204);
	}
	
	/**
	 * Post to /noticias . 
	 * Must create new news and return the identifier  of that news  
	 * Similiar to putNews
	 */
	function postRoot($req){
		$noticia = new Noticia();
		$xmlHttpContent = $req->getData();

		if(!$noticia->validateXMLbyXSD($xmlHttpContent, "Noticia.xsd")) {
			RestUtils::sendResponse(400, null, "XML mal formado!", "text/plain");
		}
		
		$n = $noticia->fromXml($xmlHttpContent);
		
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
	
	function putNews($req, $id, $n){
		$noticia = new Noticia();
		$xmlHttpContent = $req->getData();
		if(!$noticia->validateXMLbyXSD($xmlHttpContent, "Noticia.xsd")) {
		 RestUtils::sendResponse(400, null, "XML mal formado!", "text/plain");
		}
		$nova_noticia = $noticia->fromXml($xmlHttpContent);
		if ($nova_noticia === null || checkRelations($nova_noticia)===false ||
			// se existir id de noticia no gajo nao pode ir.  
			(isset($nova_noticia->idnoticia) && ($nova_noticia->idnoticia !=  $id))){ 
			RestUtils::sendResponse(400);

		}
		
		$nova_noticia->idnoticia =$id; 
		addNoticia($nova_noticia, "update");
		RestUtils::sendResponse(204);
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
		$integrantes_classe = new Noticia_Has_Integrante(); 
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
					echo $e; 	
										
					RestUtils::sendResponse(500);
					exit;  
				}
			}	
		}
	}
	
	function getNews($req, $id, $n){
		$n = $n->getRelationArray($id, getUrl());
		$noticia = new Noticia();
		RestUtils::webResponse($n, $req, 'noticia', 'Noticia.xsd', 'data'); 
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
    	RestUtils::sendResponse(405, array('allow' => $methods_supported));
    }
    	if($req->getMethod() == "GET") {
    	//check the request variables that are not understood by this resource
    	$dif = array_diff(array_keys($req->getRequestVars()), $request_vars);
    	//If they are differences then we do not understand the request.  
    	 if ( count($dif)  != 0 ){
    	 	RestUtils::sendResponse(400, array('unrecognized_req_vars' => $dif));
    		exit; 
    	}
    	}
    	//TODO - check that path parameters are correct through regulares expressions that validate input types and formats. 
    	//could respond BadRequest also. 
    }
    
	
?>
