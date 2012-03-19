<?php

include "lib/Util.php";
include "./classes/DAO.php";
include "./classes/Noticia.php";
include "./classes/Fonte.php";

/**
* Classe responsбvel pelo leitura e consulta dos RSS do Google News
* 
* @author Anderson Barretto - Nr 42541
* @author Fбbio Botelho 	 - Nr 41625
* @author Josй Lopes		 - Nr 42437
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
		parent::__construct("RSS Google News");
	}
	
	public function search($parameters) {
		foreach($parameters as $searchWord) {
			$encode = urlencode($searchWord);
			$url_search = $this->main_url.$encode;
			$result_json = $this->execSearch($url_search);
			$output = json_decode($result_json);
			//var_dump($output);
			$results = array();
			
			foreach($output->responseData->results as $news) {
				$myNew = new Noticia(); 
				$myNew->setIdfonte($this->idfonte);
				$myNew->setData_pub(isset($news->publishedDate) ?
									Util::formatDateToDB($news->publishedDate)
									: "");
				$myNew->setAssunto(isset($news->titleNoFormatting) ?
									addslashes($news->titleNoFormatting)
									: "");
				$myNew->setDescricao(isset($news->content) ?
									addslashes($news->content)
									: "");
				@$myNew->setTexto(isset($news->unescapedUrl) ?
									addslashes(file_get_contents($news->unescapedUrl))
									: "");
				$myNew->setUrl(isset($news->unescapedUrl) ?
									addslashes($news->unescapedUrl)
									: ""); 
				//TODO Caracterizaзгo Semantica da Notнcia
				//ParserNoticia::parseNoticia($myNew);
				var_dump($myNew);
			}
		}
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

$gnc = new GNewsClient();
$parameters = Util::getSearchParameters();
$gnc->search($parameters);

?>