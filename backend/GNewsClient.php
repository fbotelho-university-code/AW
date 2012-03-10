<?php

include "lib/Util.php";
include "./classes/DAO.php";
include "./classes/Noticia.php";
include "./classes/Fonte.php";
ini_set('default_charset','UTF-8');

/**
* Classe responsável pelo leitura e consulta dos RSS do Google News
* 
* @author Anderson Barretto - Nr 42541
* @author Fábio Botelho 	 - Nr 41625
* @author José Lopes		 - Nr 42437
* @author Nuno Marques		 - Nr 42809
* @package backend
* @version 1.0 20120305
*/

class GNewsClient extends Fonte {
	
	/**
	* Contrutor da Classe GNewsClient. Inicializa os atributos do objecto.
	* Chama construtor da superclasse para inicializar:
	*  - Nome da fonte: {@link $nome}
	*  - URL principal da fonte {@link $main_url}
	*/
	public function __construct() {
		parent::__construct("RSS Google News", "https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=");
		//parent::__construct("RSS Google News", "https://ajax.googleapis.com/ajax/services/feed/find?v=1.0&output=json&q=");
	}
	
	public function search($parameters) {
		foreach($parameters as $searchWord) {
			$encode = urlencode($searchWord);
			$url_search = $this->main_url.$encode;
			$result_json = $this->execSearch($url_search);
			$output = json_decode($result_json);
			print_r($output);
			$results = array();
			
			foreach($output->responseData->entries as $news) {
				$myNew = new Noticia(); 
				//$myNew["idnoticia"] = null;						//campo auto increment
				$myNew->setIdfonte($this->idfonte);				//identificador da Sapo News
				$myNew->setIdLocal(1);							//@todo buscar ref espacial
				$myNew->setData_pub(Util::formatDateToDB($news->publishedDate)); 
				$myNew->setData_noticia(""); 
				$myNew->setAssunto(addslashes($news->titleNoFormatting));
				$myNew->setDescricao(addslashes($news->content));
				$myNew->setTexto(file_get_contents($news->unescapedUrl));  //@todo buscar texto da noticia
				$myNew->setUrl($news->unescapedUrl); 
				
				//$myNew["entidade"] = $parameters[$j];			//@todo inserir identidicador da identidade
				$results[] = $myNew;
			}
		}
		return $results;
	}
	
	private function execSearch($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, "http://localhost/aw002/backend/");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result= curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}
$gn = new GNewsClient();
$clubes = array("Benfica", "Porto", "Sporting");
$news = $gn->search($clubes);
//print_r($news);
$n = new Noticia();
$msg = $n->insert($news);
echo $msg;
?>