<?php

/*
 * Created on Mar 11, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 require_once "includes.php";
 
 //ini_set('default_charset','UTF-8');
 
 try{
 $lines = file( "./static/lexico.futebol.txt", FILE_IGNORE_NEW_LINES);
 }catch(Exception $e){
 	echo "Exception : " . $e->getMessage() . "\n";  
 }

 
 $ado = new DAO(); 
 $ado->connect();
 $ado->execute("truncate table lexico");
 $ado->execute("truncate table clubes_lexico"); 
 $ado->execute("truncate table integrantes_lexico");
  
 $relacoes  = array(); // Array para guardar actualiza�›es finais de rela�›es .
 
 foreach ($lines as $line ){
 	//Para cada entry da bd 
 	$map = array(); 
 	$fields = explode(",", $line);
 	
 	foreach($fields as $field){
 		$keyValueArray = explode(":", $field);
 		$map[$keyValueArray[0]] = $keyValueArray[1]; 
 	}
 	$val = $ado->AutoExecute("lexico", $map , "INSERT");
 }
 $jogador = new Integrante();
 $jogadores = $jogador->getAll();
 $clube = new Clube();
  $clubes = $clube->getAll();
  //foreach ($clubes as $cl){
 	//echo '<br/>'. $cl . '<br/>';
 //}
 
 $lex = new Lexico();
 $lexicos = $lex->getAll();
 
 foreach ($lexicos as $lexico){
  	
  	//TODO - ser‡ a melhor maneira de comparar? 
  	if ($lexico->getTipo() == "nome"){
  		$tabela_relacao = null ; //indica tabela de rela�ao (lexico_integrantes ou lexico_clubes)
  		$values_lexico = array();
  		$tabela_to_inserir = null;
  		 
  		if (($idint = findPlayer($jogadores, $lexico->getContexto()))){
			//echo '<br/> found player ' . $$idint . '<br/>'; 
			$tabela_to_inserir = "integrantes_lexico";
			$values_lexico["idintegrante"] = $idint->getIdintegrante();  
		}
		
		else{ 
			if (($idclube = findClube($clubes, $lexico->getContexto()))){
			//	echo '<br/> found clube ' . $idclube->getIdclube(). '<br/>'; 
				$tabela_to_inserir = "clubes_lexico";
				$values_lexico["idclube"] =  $idclube->getIdclube();  
			}
		}
		
		if ($tabela_to_inserir != null ){
			//Encontrar todos os lexicos dessa entidade
			$lexicoFind =array('entidade' => $lexico->getEntidade());  
			$lexicosEntidade = $lex->find($lexicoFind);
			//var_dump($lexicosEntidade); 
			foreach ($lexicosEntidade as $lexico2relation){
				//echo 'here'; 
				$values_lexico["idlexico"] = $lexico2relation->getIdlexico();
				$result = $ado->AutoExecute($tabela_to_inserir, $values_lexico, "INSERT");	
			}
		}		
  	}
 }
 
  function findPlayer($array, $needle){
 	foreach ($array as $elem){
 		if (stripos($elem->getNome_integrante(),$needle)  !== false){
 			return $elem; 
 		}
 	}
 	return null; 
 }
 
 function findClube($array, $needle){
 	foreach ($array as $elem){
 		if (stripos($elem->getNome_oficial(),  $needle) !== false){
 			return $elem; 
 		}
 	}
 	return null; 
 }
?>
