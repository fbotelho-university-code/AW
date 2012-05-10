<?php

require_once ('Util/RestUtils.php');
require_once ('Util/RestRequest.php');
require_once ('Util/XML/Serializer.php');
require_once ('../model/Noticia.php');
require_once ('../model/Noticia_Bin.php');
require_once ('./Util.php');

$req  = RestUtils::processRequest();  // The request made by the client.
checkRequest($req);   // check that the request is valid. Dies otherwise.

//Dispatching according to the path info.
$path_parameters = $req->getPathInfo();
$path_parameters_count = count($path_parameters);

switch($path_parameters_count){
	case 0:
		processRoot($req);
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
		default:
			RestUtils::sendResponse(405, array('allow' =>"GET"));
			exit;
	}
}

function getRoot($req){
	$l = new Video();
	try{
		$res = $l->getAll();
		if (count($res) == 0){
			RestUtils::sendResponse(404);
		}
	}catch(Exception $e){
		RestUtils::sendResponse(500);
	}
	RestUtils::webResponse($res, $req, 'videos', 'Videos.xsd');
}

/*
 * Checks if the request is valid through whitelistening of the possible request types.
* Deals with query variables, path info, method types, etc.
*/
function checkRequest($req){
	//Variables that should be defined for checkRequest. Ideally this would be defined in a abstact/general form.
	$methods_supported = array("GET", "POST", "HEAD", "DELETE", "PUT");
	$request_vars = array("start", "count", );

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

?>