<?php


require_once('../model/Clube.php');
require_once('../model/Integrante.php');

require_once('../backend/GNewsClient.php');
require_once('../backend/dbpedia.php');
require_once('../backend/lib/HttpClient.php');
require_once('../webservice/Util/RestUtils.php');

function getUrl(){
	$v = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	$r = $v['scheme'] . '://' . $v['host'] . $v['path'];
	$pos = strpos($r, 'noticias.php') ;
	$val = substr($r, 0, $pos );

	return $val;
}

$req  = RestUtils::processRequest();  // The request made by the client.
//checkRequest($req);   // check that the request is valid. Dies otherwise.

//Dispatching according to the path info.
$path_parameters = $req->getPathInfo();
$path_parameters_count = count($path_parameters);


if (!($path_parameters_count >= 1   && $path_parameters_count <= 4)){
	RestUtils::sendResponse(404);
}

switch ($req->getMethod()){
	case 'GET':
		break;  
	case 'POST': 
		createNewFonte($req); 
		break; 
	default : 
		RestUtils::sendResponse(405, array('allow' =>"GET "));
		break; 
}

$fonte = new Fonte();
switch($path_parameters[1]){
	case 'dbpedia':
		treatdbpedia($req); 
		break;
	case 'gnews': 
		$fonte = new GNewsClient(); 
		break; 	
	default :
		try{
			$fonte = $fonte->findFirst(array("webname" => $path_parameters[1]));
		}catch(Exception $e){
			RestUtils::sendResponse(500);
		}
		if (!isset($fonte)){
			RestUtils::sendResponse(404);
		}
	}
	$searches = null;
	$clube = new Clube();
	$integrante = new Integrante();
	
	switch($path_parameters_count){
		case 1: 
			//get default search keywords
			$searches = $clube->getAll(array("nome_oficial"));
			$searches = array_merge($searches, $integrante->getAll(array("nome_integrante")));
			break; 
		case 2:
			switch($path_parameters[2]){
				case 'clube':
					$searches = $clube->getAll(array("nome_oficial"));
					break;
				case 'integrante':
					$searches = $integrante->getAll(array("nome_integrante"));
					break;
				default :
					RestUtils::sendResponse(404);
				}
			break; 
		case 3: 
			$id = $path_parameters[3]; 
			if (!is_numeric($id)){
				RestUtils::sendResponse(404);
			}
			$pes = null; 
			switch($path_parameters[2]){
				case 'clube':
					$pes =  $clube->getObjectById($id, array("nome_oficial"));
							break;
				case 'integrante':
					$pes = $integrante->getObjectById($id, array("nome_integrante")); 
							break;
				default :
					RestUtils::sendResponse(404);
			}
			if (!isset($pes)){
		
				RestUtils::sendResponse(404); 
			}
			$searches[] = $pes; 
			
			break;
	}
		
	$pes = array(); 
	foreach($searches as $s){
		if (isset($s->nome_integrante)){
			$pes[] = $s->nome_integrante; 
		}
		else 
			$pes[] = $s->nome_oficial; 
	}
	$searches = $pes; 
	try{
		
		$n = $fonte->search($searches);

	}catch(Exception $e){
		RestUtils::sendResponse(500); 
	}
	
	switch($fonte->type){
		case 1:
			$parser = new ParserNoticias();
			$parser->parseSeveral($n);
			//noticias
			break;
		case 2:
			$b = new Bitaites();
			$i =0;
			foreach ($n as $bitai){
								
				$exi =$b->findFirst(array("url" => $bitai->url));
				if (isset($exi)) continue;
				if (isset($bitai->user)){
					$b->user = $bitai->user;
				}
				else{
					$b->user = 'anonymous'; 
				} 
				$b->texto = $bitai->descricao;
				$b->about = $bitai->about;  
				$b->url = $bitai->url;
				$b->data_pub = isset($bitai->data_pub) ? $bitai->data_pub : null; 
				try{
					$b->add();
					$i++; 
				}catch(Exception $e){
					continue; 
				} 
			}
			RestUtils::sendResponse(204, null, $i, 'text');
			break;  
			//bitaites
		case 3:

			$v = new Video(); 
			foreach($n as $video){
				try{
					
					$exists =$v->findFirst(array("url" => $video->url));
					if (isset($exists)) continue;
					
					$v->descricao = isset($video->descricao) ? $video->descricao : null;
					
					if (!isset($video->assunto)) continue;
					
					$v->titulo = $video->assunto;
					$v->about = $video->about; 
					$v->url = $video->url;
					$v->add(); 
				}catch(Exception $e){
					continue; 
				}
			} 
	}
	RestUtils::sendResponse(201, null, $n,'text/html');
	function treatdbpedia($req){
		$path_info = $req->getHttp_accept_original(); 
		$path_info_count = count($path_info);
		if ($path_info_count != 2){
			RestUtils::sendResponse(404); 
		}
		$resource = $path_info[2];
		$result = isUrlClube($resource);
		if (!isset($result)){
			RestUtils::sendResponse(400); 
		}
		else{
			fetch_and_insert_clube('http://dbpedia.org/resource/' . $resource); 
		}
	}
	
	function createNewFonte($req){
		$path_info = $req->getPathInfo(); 
		if (count($path_info) !=1){
			RestUtils::sendResponse(404);
		}
		$name = $path_info[1];
		try{
			$fonte = new Fonte(); 
			$fonte = $fonte->findFirst(array("webname" => $name));
			if (isset($fonte)){
				RestUtils::sendResponse(400);
			}
		}catch(Exception $e){
			RestUtils::sendResponse(500);
		}
		$fonte = new Fonte(); 
		$data = $req->getData(); 
		$fonte = $fonte->fromXml($data); 
		$f = new Fonte(); 
		$f->ligado = 1; 
		$f->webname = $name;
		$f->xml = $data;  
		$f->type = $fonte->type; 
		try{
			$f->add(); 
		}catch(Exception $e){
			RestUtils::sendResponse(500); 
		}
		RestUtils::sendResponse(201);
	} 
	
?>