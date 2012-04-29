<?php
require_once ('../model/includes.php');

insertClubesOfPrimeiraLiga(); 

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
 	$query = "SELECT ?abstract  WHERE { {<" . $db_uri . "> <http://dbpedia.org/ontology/abstract> ?abstract . FILTER langMatches(lang(?abstract),'" . $lang."') } }"; 
	$result =execute_sparql_query($query);
	$result = json_decode($result); 

		if (isset($result) && isset($result->results) && isset($result->results->bindings)){
			return $result->results->bindings[0]->{'abstract'}->value;   
		}
		else{
			if ($lang == 'pt') return getAbstractInPortugueseOrEnglish($db_uri, 'en');
			else return null;  
		}
 }
 /**
  * Get the thumbnail image associative array from a dpbedia uri. 
  */
  
function getThumbnailUrl($clube_uri){
//	var_dump($clube_uri); 
	$query = "SELECT ?url WHERE { { <" . $clube_uri . "> <http://dbpedia.org/ontology/thumbnail> ?url } } ";
	$result = execute_sparql_query($query);
	if (isset($result)){
		$result = toJsonResults($result);
		if (isset($result)){
			$url = $result[0]->url->value;
			
			$url = str_replace("/commons/thumb/", "/en/", $url);
			$pos = strpos($url, "/200px"); 
			$url = substr($url, 0, $pos);
			// Get image : 
			return getImage($url); 
		} 
	}  
}

/**
 * Get full name of resource 
 * Full name should alwas appear as it makes part of the infobox. 
 */
function getFullName($p_uri){
	$query = "
		SELECT * WHERE {<". $p_uri . "> ?key ?value .
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
	return null; 
}

/**
 * Deal with names of entities for the lexico.
 * Returns an array of strings with all names it found.  
 */ 
 function getNamesClubes($uri){
 	return getNames("
	SELECT * WHERE {<". $uri . "> ?key ?value .
  	FILTER ( 
  		 ?key = <http://dbpedia.org/property/clubname> ||
         ?key = <http://dbpedia.org/property/fullname> || 
         ?key = <http://dbpedia.org/property/nickname> || 
         ?key = <http://dbpedia.org/property/shortName> 		 
)
}");
 }
  
 function getNamesIntegrante($uri){
  return ; 	
 }
  
function getNames($query){
	$result = execute_sparql_query($query);
	
	$nomes = array();
	if (isset($result)){
		$result = toJsonResults($result);
		
		if (isset($result)){
		  foreach ($result as $entry){
		  	$nome = $entry->value->value; 
	  		$nomes_explode = explode(",", $nome);
	  		foreach ($nomes_explode  as $nome){
	  			if (array_search($nome, $nomes)===false){
	  				$nomes[] = $nome; 
	  			}	
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
	updateLexico($names , $rel); 
}

function addIntegranteLexico($integrante_uri, $idintegrante){
	$names = getNamesIntegrante($integrante_uri);
	$rel = new Clubes_Lexico();
	$rel->idclube = $idintegrante; 
	updateLexico($names , $rel); 
}

function updateLexico($nomes,$rel){
	$Lexico = new Lexico(); 
	$Lexico->pol = $Lexico->ambiguidade = 0; 
		foreach ($nomes as $nome){
	        $Lexico->contexto = $nome;
		  	$strings[] = $Lexico->contexto; 
			$Lexico->tipo = 'dbpedia_name';
			try{
				$id = $Lexico->add();
				$rel->idlexico = $id; 
				$rel->add(); 
			}catch(Exception $e){
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
	$query ="SELECT ?clube
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
	$clube->resumo = getAbstractInPortugueseOrEnglish($clube_uri);
	$clube->nome_oficial = getFullName($clube_uri);
	try{
		$id = $clube->add(); 
		addClubeLexico($clube_uri, $id);
		$img = getThumbnailUrl($clube_uri);
		if (isset($img)){
			echo 'vou inserir uma imagem<br/>'; 
			$Img = new Clube_Imagem();
			$Img->idclube = $id; 
			$Img->content_type = $img['type']; 
			$Img->imagem = $img['image']; 
			$Img->add(); 
		}
	}catch(Exception $e){
		echo $e; 
	}
	
}

/**
 * Insere na bd a imagem do clube. 
 */
function insert_image($clube_uri, $id){
	
	
}

  /*******************************END OF CLUBES ******************/
 
 function players_belong_to_clube($clube){
 	$result = execute_sparql_query( "SELECT ?player 
		{
    		?player a dbpedia-owl:SoccerPlayer .
    		?player dbpprop:currentclub	dbpedia:" . $clube . 
		"}");
		
 	if (isset($result)){
 		$j_result = json_decode($result);
 		if (isset($j_result) && isset($j_result->results) && isset($j_result->results->bindings)){
 			//Grab each player url and feed the database with it. 
 			foreach ($j_result->results->bindings as $p){
 				if (isset($p->player) && isset($p->player->value)){
 				    fetch_and_insert_player($p->player->value, '1'); 
 				}
  			}
 		}
 	}
 }
 
 /**
  * Fetches the player info from the dbpedia uri. 
  * @param $p_uri The dbpedia uri of the player. 
  * @param $clube_id The clube_id to insert in the database.  
  */
 function fetch_and_insert_player($p_uri, $clube_id){
/* 	 $result = execute_sparql_query( "SELECT * FROM <" . $p_uri . ">  
		WHERE{
			?p ?c ?d . }");*/
			$p_uri_ = str_replace("/resource/", "/data/", $p_uri); 
			$p_uri_ .= '.json';
			
	$result = getUrlContent($p_uri_, array('Accept' => 'application/json'));
	
	$player = new Integrante(); 
	//TODO : set função.
	 
	$player->resumo = getAbstractInPortugueseOrEnglish($p_uri);
	$player->nome_integrante = getFullName("http://dbpedia.org/resource/Diego_Maradona");
	$player->idclube = $clube_id; 
	$player->funcao = 'Jogador'; 
	try{
		$player->add();
		return updateLexicoPlayers("http://dbpedia.org/resource/Diego_Maradona", '1');
	}catch(Exception $e){
		return false; 
	}
 }


/**
 * Fazer update ao léxico dos integrantes.  
 */
function updateLexicoPlayers($p_uri, $player_id){
	$query = "
	SELECT * WHERE {<". $p_uri . "> ?key ?value .
  	FILTER ( 
  		 ?key = <http://dbpedia.org/property/fullname> ||
         ?key = <http://dbpedia.org/property/name> || 
         ?key = <http://dbpedia.org/property/playername> || 
         ?key = <http://dbpedia.org/property/alternativeNames>  ||  
         ?key = <http://dbpedia.org/property/nickname>
)
}";
 
	$result = execute_sparql_query($query, 'json');
	$result = json_decode($result);
	$Lexico = new Lexico();
	$Lexico->ambiguidade = $Lexico->pol  = 0;
	$rel = New Integrantes_Lexico();
	$rel->idintegrante = $player_id;
	$strings = array(); //Nomes já encontrados.
	 
	if (isset($result) && isset($result->results) && isset($result->results->bindings)){
		$result = $result->results->bindings;		
		foreach ($result as $entryLexico){
			 $Lexico->contexto = $result[0]->value->value;
			 if (array_search($Lexico->contexto, $strings) ===false){
			 	$strings[] = $Lexico->contexto; 
			 }
			 else{
			 	continue; //do not add this one. 
			 }
			$Lexico->tipo = $result[0]->key->value; 
			try{
				$id = $Lexico->add();
				$rel->idlexico = $id; 
				$rel->add(); 
			}catch(Exception $e){
				continue; 
			}
		}
	}
	return true; 
 }
 

 /**
  * Testing the reading from the database of imgs. 
  */
  /*$dao = new DAO(); 
  $rs = $dao->execute("select * from teste");
  
  foreach ($rs as $r){
  	header('Content-type: image/jpg'); 
  	echo $r['imagem']; 
  }
   */
   
 //teste_insert_and_read_and_display_img(); 
 
 function teste_insert_and_read_and_display_img(){
 	$result = performQuery("http://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Argentine_-_Portugal_-_Carlos_Jorge_Neto_Martins.jpg/200px-Argentine_-_Portugal_-_Carlos_Jorge_Neto_Martins.jpg"); 
	$result = addslashes($result);

	if (isset($result)){
	 	$dao = new DAO();
	 	try{
	 		$dao->execute("INSERT INTO  teste (imagem) VALUES ('$result')");
	 	}catch(Exception $e){
	 		echo $e; 
	 	}
	}
 }
 
 
 
 /*****************************************************************************************************************/
 /* HTTP related functions TODO:refactor into a module.*/
 
 /**
  * Check a curl response code. If is not a valid response return false. 
  */
 function checkCurlResponse($ch){
 	$info = curl_getinfo($ch);
 	return isset($info['http_code']) && $info['http_code'] == 200;
 	 
 }
function getCurlContentType($ch){
	$info = curl_getinfo($ch);
	if (isset($info['content_type']))
		return $info['content_type']; 	
}

 /**
  * Get a image from an url through curl
  * Returns an associate array with the following : 
  * type : the type of the image. 
  * imagem : the image.
  * Null in case of problems.  
  */
 function getImage($uri){
   $ch= curl_init();
   curl_setopt($ch, 
      CURLOPT_URL, 
      $uri);
 	curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);

   $response = curl_exec($ch);
   
   $info = curl_getinfo($ch);
   
   if (!checkCurlResponse($ch)) return null;
   $result['type'] = getCurlContentType($ch);
   if ($result['type'] == null) return null;
   $result['image'] = addslashes($response);
   return $result;
  }
    

 function getUrlContent($uri, $headers =null){
   // is curl installed?
   if (!function_exists('curl_init')){ 
      die('CURL is not installed!');
   }
   // get curl handle
   $ch= curl_init();
   // set request url
   curl_setopt($ch, 
      CURLOPT_URL, 
      $uri);
	
   curl_setopt($ch, CURLOPT_HEADER, 0); 
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 	
   curl_setopt($ch, 
      CURLOPT_RETURNTRANSFER, 
      true);

   $response = curl_exec($ch);
   
   if (!checkCurlResponse($ch)) return null;  
  
   curl_close($ch);
   return $response;
 }
	
?>
