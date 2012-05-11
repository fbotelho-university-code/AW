<?php
require_once ('lib/HttpClient.php');
require_once ('../model/includes.php');

 /**
  * Querys DBpedia to find all players belonging to the clube 
  * pass as argument. 
  * @param $clube Must be a dbpedia:resource! 
  */
  function execute_sparql_query($query, $format='json'){
 	$dpbedia_uri = 'http://dbpedia.org/sparql?'; 
 	$uri = $dpbedia_uri . 'query=' . urlencode($query) . '&format=' . $format;
 	
 	return  getUrlContent($uri);
 }
 
   /**
  * Gets the abstract section of a dbpedia resource uri. 
  */
  function getAbstractInPortugueseOrEnglish($db_uri, $lang='pt'){
 	$query = "SELECT distinct ?abstract  WHERE { {<" . $db_uri . "> <http://dbpedia.org/ontology/abstract> ?abstract . FILTER langMatches(lang(?abstract),'" . $lang."') } }"; 
	
	$result =execute_sparql_query($query);

	$result = toJsonResults($result);
		if (isset($result) && isset($result[0])){
			return $result[0]->{'abstract'}->value; 			
		}
		else if ($lang == 'pt') return getAbstractInPortugueseOrEnglish($db_uri, 'en'); 
		else return null; 
 }
 
 function getPresidente($clube_uri){
 	$query = "SELECT ?presidente  WHERE { {<" . $clube_uri . "> <http://dbpedia.org/ontology/chairman> ?presidente .  } }"; 
	
	$result =execute_sparql_query($query);

	$result = toJsonResults($result);
		if (isset($result) && isset($result[0])){
			return $result[0]->presidente->value; 			
		}
		else return null; 
 }

 function getTreinador($clube_uri){
 	$query = "SELECT distinct ?manager  WHERE { {<" . $clube_uri . "> <http://dbpedia.org/ontology/manager> ?manager .  } }"; 
	$result =execute_sparql_query($query);
	$result = toJsonResults($result);
		if (isset($result) && isset($result[0])){
			return $result[0]->manager->value; 			
		}
		else return null; 
 }
 
  /**
  * Get the thumbnail image associative array from a dpbedia uri. 
  */
function getThumbnailUrlClube($clube_uri){
	$query = "SELECT distinct ?url WHERE { { <" . $clube_uri . "> <http://dbpedia.org/ontology/thumbnail> ?url } } ";
	$result = execute_sparql_query($query);
	if (isset($result)){
		$result = toJsonResults($result);
		if (isset($result) && isset($result[0])){
			$url = $result[0]->url->value;
			$url = str_replace("/commons/thumb/", "/en/", $url);
			$pos = strpos($url, "/200px"); 
			$url = substr($url, 0, $pos);
			// Get image : 
			return getImage($url); 
		} 
	}  
}

function getThumbnailUrlInt($clube_uri){
	$query = "SELECT distinct ?url WHERE { { <" . $clube_uri . "> <http://dbpedia.org/ontology/thumbnail> ?url } } ";
	$result = execute_sparql_query($query);
	if (isset($result)){
		$result = toJsonResults($result);
		if (isset($result) && isset($result[0])){
			$url = $result[0]->url->value;
			// Get image :
			return getImage($url);
		}
	}
}

/**
 * Get full name of resource 
 * Full name should alwas appear as it makes part of the infobox. 
 */
function getFullNameClube($p_uri){
	$query = "
		SELECT distinct * WHERE {<". $p_uri . "> ?key ?value .
  		FILTER (?key = <http://dbpedia.org/property/fullname>   
	)
	}";

	$result = execute_sparql_query($query, 'json');
	$result = json_decode($result);
	if (isset($result) && isset($result->results) && isset($result->results->bindings)){
		$result = $result->results->bindings;
		if (isset($result[0]->value->value)){
			return $result[0]->value->value; 
		}
	}
}

/**
 * Get full name of resource 
 * Full name should alwas appear as it makes part of the infobox. 
 */
function getFullName($p_uri){
	$query = "
		SELECT distinct * WHERE {<". $p_uri . "> ?key ?value .
  		FILTER (?key = <http://dbpedia.org/property/fullname>   
	)
	}";

	$result = execute_sparql_query($query, 'json');
	$result = json_decode($result);
	
	if (isset($result) && isset($result->results) && isset($result->results->bindings)){
		$result = $result->results->bindings;
		if (isset($result[0]->value->value)){
			return $result[0]->value->value; 
		}
	}

	$query = $query = "
		SELECT distinct * WHERE {<". $p_uri . "> ?key ?value .
  		FILTER (?key = <http://dbpedia.org/property/name>   
	)}"; 

	$result = execute_sparql_query($query, 'json');
	$result = json_decode($result);
	
	if (isset($result) && isset($result->results) && isset($result->results->bindings)){
		$result = $result->results->bindings;
		if (isset($result[0]->value->value)){
			return $result[0]->value->value; 
		}
	}
	return null; 
}

/**
 * Deal with names of entities for the lexico.
 * Returns an array of strings with all names it found.  
 */ 
 function getNamesClubes($uri){
 	return getNames("
	SELECT distinct * WHERE {<". $uri . "> ?key ?value .
  	FILTER ( 
  		 ?key = <http://dbpedia.org/property/clubname> ||
         ?key = <http://dbpedia.org/property/fullname> || 
         ?key = <http://dbpedia.org/property/nickname> || 
         ?key = <http://dbpedia.org/property/shortName> 		 
)
}");
 }
 
 function getNamesIntegrante($uri){
 	return getnames("
	SELECT distinct * WHERE {<". $uri . "> ?key ?value .
  	FILTER ( 
	  		 ?key = <http://dbpedia.org/property/fullname> ||
	         ?key = <http://dbpedia.org/property/name> || 
	         ?key = <http://dbpedia.org/property/playername> || 
	         ?key = <http://dbpedia.org/property/alternativeNames>  ||  
	         ?key = <http://dbpedia.org/property/nickname>" .
         		"
	)
	}");
 }

function isUrlClube($resource){
	$query  = "SELECT distinct ?clube
	{
		?clube a <http://dbpedia.org/ontology/SportsTeam> .
		FILTER ( ?clube = <http://dbpedia.org/resource/" . $resource. ">)
	}";
	var_dump($query); 
	$result = execute_sparql_query($query);
	$result = toJsonResults($result);
	if (isset($result[0]->clube)){
		return true; 
	}
	else return false; 
}

function getNames($query){
	$result = execute_sparql_query($query);
	
	$nomes = array();
	if (isset($result)){
		$result = toJsonResults($result);
		
		if (isset($result)){
		  foreach ($result as $entry){
		  	$nome = $entry->value->value; 
	  	//	$nomes_explode = explode(",", $nome);
	  		//foreach ($nomes_explode  as $nome){
	  			if (array_search($nome, $nomes)===false){
	  				$nomes[] = trim($nome); 
		  }
		}
	}
	}
	return $nomes; 
}

/**
 * Actualizar relações no léxico. Para poder fazer pesquisas depois. 
 */
function addClubeLexico($clube_uri, $idclube){
	$names = getNamesClubes($clube_uri);
	$rel = new Clubes_Lexico();
	$rel->idclube = $idclube;
	echo '<br/> Inserindo para ' . $clube_uri . "Nomes : <br/>" ;
	var_dump($names);
	updateLexico($names , $rel); 
}

function addIntegranteLexico($integrante_uri, $idintegrante){
	$integrante_uri; 
	$names = getNamesIntegrante($integrante_uri);
	$rel = new Integrantes_Lexico();
	$rel->idintegrante = $idintegrante;
	echo '<br/> Inserindo para ' . $integrante_uri . "Nomes : <br/>" ;
	var_dump($names); 
	updateLexico($names , $rel);
}

function updateLexico($nomes,$rel){

	$Lexico = new Lexico(); 
	$Lexico->pol = $Lexico->ambiguidade = 0;
	$strings = array(); 
	foreach ($nomes as $nome){
			if (array_search($nome, $strings) === false){
				$strings[] = $nome;
			} else
				continue;
	        $Lexico->contexto = $nome;
	        echo '<br/> Adding : ' . $Lexico->contexto . '<br/>'; 
		  	$strings[] = $Lexico->contexto;
			$Lexico->tipo = 'dbpedia_name';
			try{
				$id = $Lexico->add();
				echo '<br> Adicionei ao lexico ; '; 
				$rel->idlexico = $id; 
				$rel->add(); 
				echo ' Adicionei a rela��es <br/>'; 
			}catch(Exception $e){
				var_dump($e); 
				continue; 
			}
		}
}

 /**
  * Routine check of json decoding results from the dbpedia. 
  */
  function toJsonResults($data){
  	$j_result = json_decode($data); 
	if (isset($j_result) && isset($j_result->results) && isset($j_result->results->bindings)){
		$j_result = $j_result->results->bindings;
		return $j_result;  
	} 
  }
  
 /*******************************CLUBES*************************/
  /**
   * Esta funcção insere todos os clubes da primeira liga de futebol. 
   */
  function insertClubesOfPrimeiraLiga(){
//  	fetch_and_insert_clube("http://dbpedia.org/resource/S.L._Benfica");
	$query ="SELECT distinct ?clube
	{
  	?clube a <http://dbpedia.org/ontology/SportsTeam> .
        ?clube dbpedia-owl:league <http://dbpedia.org/resource/Primeira_Liga>
	}";
	
	$result = execute_sparql_query($query);
			
	if (isset($result)){
		$result = toJsonResults($result);
		if (isset($result)){
			foreach ($result as $r){
				fetch_and_insert_clube($r->clube->value); 
			}
			echo 'Done inserting clubes<br/>';
			return;  
		}
	} 
	echo 'Could not insert clubes <br/>';

}
   

/**
 * This function allows the insertion of a club through a dbpedia resource uri of that club. 
 */
function fetch_and_insert_clube($clube_uri){
	$clube = new Clube();
	$clube->resumo = addslashes(getAbstractInPortugueseOrEnglish($clube_uri));
	$clube->nome_oficial = addslashes(getFullNameClube($clube_uri));
	if (isset($clube->nome_oficial)){
		$rs = $clube->findFirst(array("nome_oficial" => $clube->nome_oficial));
		if (isset($rs)) return ;  
	try{
		$id = $clube->add(); 
		$clube->idclube = $id; 
		addClubeLexico($clube_uri, $id);
		$img = getThumbnailUrlClube($clube_uri);
		if (isset($img)){
			echo 'vou inserir uma imagem<br/>'; 
			$Img = new Clube_Imagem();
			$Img->idclube = $id; 
			$Img->content_type = $img['type']; 
			$Img->imagem = $img['image']; 
			$id_img = $Img->add();
			$clube->url_img = 'true'; 
			$clube->update(); 
		}
	}catch(Exception $e){
		return; 
		//echo $e; 
	}
	}
//	echo "Vou inserir integrantes para o clube : " . $clube->nome_oficial . "<br/>"; 	
	fetch_and_insert_players_belonging_to_clube($clube_uri, $id);
}

/**
 * Insere na bd a imagem do clube. 
 */
function insert_image($clube_uri, $id){

}

  /*******************************END OF CLUBES ******************/

 function fetch_and_insert_players_belonging_to_clube($clube, $id){
 	$clube_uri = $clube;
 	$clube = strrchr($clube, "/");
 	$clube = substr($clube, 1);
 	
 	$result = execute_sparql_query( "SELECT distinct ?player 
		{
    		?player a dbpedia-owl:SoccerPlayer .
    		?player dbpprop:currentclub	dbpedia:" . $clube . 
		"}");
	
 	echo "SELECT distinct ?player 
		{
    		?player a dbpedia-owl:SoccerPlayer .
    		?player dbpprop:currentclub	dbpedia:" . $clube . 
		"}"; 
 	
 	if (isset($result)){
 		$result = toJsonResults($result);
 		if (isset($result)){
 			//Grab each player url and feed the database with it. 
 			//echo "Tenho " . count($result) . " jogadores para o clube " . $clube . "<br/>";
 			foreach ($result  as $p){
 				if (isset($p->player) && isset($p->player->value)) {
 				    fetch_and_insert_player($p->player->value, $id); 
 				}
  			}
 		}
 	}
 	//Fetch and Inser Presidente and Manager
 	$presidente_uri = getPresidente($clube_uri);
 	
 	if (isset($presidente_uri)){
 		fetch_and_insert_player($presidente_uri, $id, 'Presidente');	
 	} 
 	$treinador_uri = getTreinador($clube_uri); 
 	if (isset($presidente_uri)){
 		fetch_and_insert_player($treinador_uri, $id, 'Treinador');	
 	}
 }
 
  /**
  * Fetches the player info from the dbpedia uri. 
  * @param $p_uri The dbpedia uri of the player. 
  * @param $clube_id The clube_id to insert in the database.  
  */
 function fetch_and_insert_player($p_uri, $clube_id, $funcao='Jogador'){
	$player = new Integrante(); 

	$player->resumo = addslashes(getAbstractInPortugueseOrEnglish($p_uri));
	$player->nome_integrante = addslashes(getFullName($p_uri));
	
	if (isset($player->nome_integrante) && $player->nome_integrante != null){
		$res = $player->find(array("nome_integrante" => $player->nome_integrante));  
		if (count($res) > 0) return false; 
		$player->idclube = $clube_id; 
		$player->funcao = $funcao;
		 
		try{
			$id = $player->add();
			$player->idintegrante = $id; 
			addIntegranteLexico($p_uri, $id);
			$img = getThumbnailUrlInt($p_uri);
			if (isset($img)){
				echo 'vou inserir uma imagem<br/>';
				$Img = new Integrante_Imagem();
				$Img->idintegrante = $id;
				$Img->content_type = $img['type'];
				$Img->imagem = $img['image'];
				$id_img = $Img->add();

					$player->url_img = 'true';
					$player->update();  

			}
		}catch(Exception $e){
			return false; 
		}
	}
 }
	
?>
