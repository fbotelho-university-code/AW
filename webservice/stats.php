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
require_once ('Util.php'); 

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
 		
 		//TODO - processRequest can fail? 
	    $path_parameters = $req->getPathInfo();

	if (count($path_parameters) != 1){
		RestUtils::sendResponse(404);
	}
	
	  switch($path_parameters[1]){
		case 'noticiasporclube':
			$ent = new Noticia_x_clube(); 
			break; 
		case 'noticiaspordata': 
			$ent = new Nr_noticia_data(); 
			break; 
		case 'noticiasporintegrante': 
			$ent = new Nr_noticia_integrante(); 
			break;
		case 'noticiasporlocalporclube': 
			$ent = new Nr_noticia_local_clube();
			break; 
		case 'noticiaspordataporclube': 
			$ent = new Noticia_data_clube(); 
			break;
		case 'noticiasporlocal': 
			$ent = new Nr_noticia_local(); 
			break;
		default: 
			RestUtils::sendResponse(404);  
	  }
	  try{
	  	$resultados = $ent->getAll();
	  }catch(Exception $e){
	  	RestUtils::sendResponse(500); 
	  }
		  
	   if (!isset($resultados) || count($resultados) == 0){
	   	RestUtils::sendResponse(404); 
	   }
	   Utill::checkEtag($req, $resultados);
	   
	   if ($req->getHttpAccept() == 'text/xml'){
			global $options; $options["rootName"] = "statistics";
			$xmlSerializer =  new XML_Serializer($options);
			//$xmlSerializer->setOption("namespace",array("localhost", "localhost"));
			
			$result = $xmlSerializer->serialize($resultados);
			
			if ($result == true){
				
				$xmlResponse = $xmlSerializer->getSerializedData();	
				RestUtils::sendResponse(200, null,$xmlResponse , 'text/xml');
				
				/*if($noticia->validateXMLbyXSD($xmlResponse, "Noticias.xsd")) {
					RestUtils::sendResponse(200, null,$xmlResponse , 'text/xml');
				}
				else {
					RestUtils::sendResponse(500);
				}*/
			}
			else{
				RestUtils::sendResponse(500); 
			}
		}
		else if ($req->getHttpAccept() == 'json'){
			RestUtils::sendResponse(200, null,  json_encode($resultados)); 
		}
		else{
			//Not Acceptable. 
			RestUtils::sendResponse(406); 
		}
		RestUtils::sendResponse(400);
		 
?>
