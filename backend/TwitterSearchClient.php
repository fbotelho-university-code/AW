<?php

require_once "includes.php";
require_once "ParserNoticias.php";

/**
* Classe responsável pela consulta do Serviço do Twitter
*/
class TwitterSearchClient extends Fonte{
	
	/**
	 * Contrutor da Classe
	 */	
	public function __construct(){  
		 parent::__construct("TwitterSearch");
	}
	
	/**
	* Busca dos comentários publicadas no Twitter com palavras presentes no parametro de pesquisa
	* @param String[] $parameters
	* 			Array com palavras a serem pesquisadas
	*/
	public function search($parameters){
		$noticias = array();
		 
		foreach ($parameters as  $searchWord){
			$url_search = $this->main_url . '?q='; 
			$encode = urlencode($searchWord);
			$url_search .= $encode;    
			$url_search .= '&include_entities=true&result_type=mixed';
			  
			$ch = curl_init($url_search);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$data = curl_exec($ch);
			curl_close($ch);
			
			
			$doc = new SimpleXmlElement($data, LIBXML_NOCDATA);
			if ($doc){
				foreach ($doc as $tag){
					foreach($tag as $key => $value){
						if ($key == "item"){
							$noticia = new Noticia(); 
							$noticia->setIdFonte($this->idfonte);
							
							foreach($value as $keyy => $valuee){
								$this->readNewAsRssItem($keyy, $valuee, $noticia);
							}
							
							ParserNoticias::parseNoticia($noticia);
							 
						}
					}
				}
			}
			else{
				die ("error reading rss "); 
			}
		}
		echo "Foram inseridas notícias da Fonte ".$this->getNome()." com sucesso.";
  }

	
	/**
	 * Associa os valores retornados pela consulta ao WebService da Fonte com os atributos do objecto
	 * @param String $key - nome do atributo
	 * @param String $value - valor do atributo
	 * @param Noticia $noticia - Objecto Notícia
	 */
	private function readNewAsRssItem($key, $value, $noticia){
	if ($value != ""){
			switch($key){
				case "pubDate":
					$noticia->setData_pub(Util::formatDateToDB($value));
					break;  
				case "title": 
					$noticia->setAssunto(addslashes($value)); 
					break; 
				case "description":
					$noticia->setDescricao(addslashes($value));
					$noticia->setTexto(addslashes($value));
					break; 
				case "link":
					$noticia->setUrl($value);
					break;    
				}
		}
	}
}


$myself = new TwitterSearchClient(); 
$parameters = Util::getSearchParameters();
$myself->search($parameters);

?>
