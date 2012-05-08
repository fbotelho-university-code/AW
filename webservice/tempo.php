<?php
@header('Content-Type: text/html; charset=utf-8');
/*
 * Created on Mar 29, 2012
 * No class, top-down flux ...
*/
require_once ('../model/includes.php'); 
require_once ('Util/RestUtils.php'); 
require_once ('Util/RestRequest.php'); 
require_once ('Util/XML/Serializer.php');
 
function getUrl(){
	$v = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		
	$r = $v['scheme'] . '://' . $v['host'] . $v['path'];
	$pos = strpos($r, 'tempo.php') ;
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
      "rootAttributes"  => array("xmlns" => "localhost", "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance", "xsi:schemaLocation" => "localhost Datas.xsd "),
      "namespace" 		=> "localhost", 
      "ignoreNull"      => true,
 	);
 	$xmlSerializer = new XML_Serializer($options);
 	
 	  //Dispatching according to the path info. 
/**
 * The ideia is to have a path url like this:  /ano/mes/dia
 * We can also have /, /ano, /mes, /dia.
 * It is also possible to have something like /2010/mes/13. 
 * We need to process the path given and comeout with some regex/ sql LIKE expression that will allows us to
 * sql the Noticia_DATA table.    
 * To the SQL MOBILE! : 
 */
 
 //Let us find this variables: 
 
 $ano = $mes = $dia = '%'; //associativity to the right. 
 
  
 	/**
 	 * Dispatch the code according to parameters : 
 	 */
 		$req = RestUtils::processRequest();
 		checkRequest($req); 
 		//TODO - processRequest can fail? 
	    $path_parameters = $req->getPathInfo();


	  switch(count($path_parameters)){
		case 0:
			$ano = $mes = $dia = '%'; //associativity to the right. 
	  		break;
	  		//Do all at the same time:  
		case 3 :
			$dia = (strcmp($path_parameters[3], 'dia') == 0 ) ? '%' : $path_parameters[3];
		case 2 :
			$mes = (strcmp($path_parameters[2], 'mes') == 0 ) ? '%' : $path_parameters[2];
	  	case 1:
	  		$ano = (strcmp($path_parameters[1], 'ano') == 0 ) ? '%' : $path_parameters[1];
	  }
	  
	  if ($dia < 10){
	  	$dia = '0'. $dia; 
	  }
	  if ($mes < 10){
	  	$mes = '0' . $mes; 
	  }
	  
	//var_dump($path_parameters); 	
	$data_needle = $ano . '-' . $mes . '-' . $dia;

	// We only have one resource :time .
	
	/**
	 * The methods allowed: 
	 * 
	 */
	switch ($req->getMethod()){
		case 'GET': 
		break;
		default: 
		RestUtils::sendResponse(405, array('allow' => "GET"));
	}
	
	$n = new Noticia_Data();
	//$results = $n->find(array('tempo' => $data_needle), ' LIKE ' );
	try{
		$results = Noticia_Data::getAllNoticias($data_needle, getUrl());
	}catch(Exception $e){
		RestUtils::sendResponse(500); 
	}
	
	if (count($results) == 0){
		RestUtils::sendResponse(404); 
	}
	
	RestUtils::webResponse($results, $req, 'datas', null,'data'); 
	
	 function checkRequest($req){
    //Variables that should be defined for checkRequest. Ideally this would be defined in a abstact/general form. 
 	
 	$request_vars = array("start", "count", "texto");
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
