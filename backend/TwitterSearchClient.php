<?php

require_once 'classes/Fonte.php'; 
require_once 'lib/rss_php.php'; 
require_once 'classes/Noticia.php'; 
require_once 'lib/Util.php'; 
/*
 * Created on Mar 7, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

ini_set('default_charset','UTF-8');

class TwitterSearchClient extends Fonte{
	/**
	 * Construtor 
	 */	
	public function __construct(){  
		 parent::__construct("TwitterSearch", "http://search.twitter.com/search.rss");
	}
	
	public function search($parameters){
		$noticias = array();
		 
		foreach ($parameters as  $searchWord){
			$url_search = $this->main_url . '?q='; 
			$encode = urlencode($searchWord);
			$url_search .= $encode;    
			$url_search .= '&include_entities=true&result_type=mixed';
			  
			echo $url_search;
			
			$ch = curl_init($url_search);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$data = curl_exec($ch);
			curl_close($ch);
			if (!$data){
				//TODO ERROR
			}
			
			
			$doc = new SimpleXmlElement($data, LIBXML_NOCDATA);
			if ($doc){
				foreach ($doc as $tag){
					foreach($tag as $key => $value){
						if ($key == "item"){
							$noticia = new Noticia(); 
							$noticia->setIdnoticia(null); 
							$noticia->setIdFonte($this->idfonte);
							
							//TODO referencia espacial;  
							$noticia->setIdlocal(1);  
							foreach($value as $keyy => $valuee){
								$this->readNewAsRssItem($keyy, $valuee, $noticia);
							}
							$noticias[] = $noticia; 
						}
					}
				}
			}
			else{
				die ("error reading rss "); 
			}
		}
	return $noticias; 
  }

	
	
function readNewAsRssItem($key, $value, $noticia){
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
					break; 
				case "link":
					$noticia->setUrl($value);
					break;    
				}
		}	
	//echo $noticia . ' @readNewAsRss <br/>'; 
	}
}

/*
$myself = new TwitterSearchClient(); 
$clubes = array("Benfica", "Porto", "Sporting");
$noticias = $myself->search($clubes);

 foreach ($noticias as $n){
	$n->add(); 
  }
*/
?>
