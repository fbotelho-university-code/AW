<?php
/*
 * Created on Mar 29, 2012
 * No class, top-down flux ...
*/
require ('../model/includes.php'); 
require_once ('Util/RestUtils.php'); 
require_once ('Util/RestRequest.php'); 
require_once ('Util/XML/Serializer.php');

 
 
   $options = array(
      "indent"          => "    ",
      "linebreak"       => "\n",
      "typeHints"       => false,
      "addDecl"         => true,
      "encoding"        => "UTF-8",
      XML_SERIALIZER_OPTION_RETURN_RESULT => true, 
      "defaultTagName"  => "noticia",
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
 $ano ; $mes; $dia;  
 //did not give yet? ... ok : 
 
 	/**
 	 * Dispatch the code according to parameters : 
 	 */
 		$req = RestUtils::processRequest();
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
	  	  
	$data_needle = $ano . '-' . $mes . '-' . $dia;
	
	echo $data_needle; 
	// We only have one resource :time .
	
	/**
	 * The methods allowed: 
	 * 
	 */
	switch ($req->getMethod()){
		case 'GET': 
		break;
		default: 
		//TODO unsopurted method.  
	}
	
	$n = new Noticia_Data();
	$results = $n->find(array('tempo' => $data_needle), ' LIKE ' ); 
	foreach ($results as $r){
		echo $r->getTempo() . ' </br>'; 
	}
				
?>
