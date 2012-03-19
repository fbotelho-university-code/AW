<?php

require "lib/rss_php.php";
include "lib/Util.php";
include "lib/simple_html_dom.php";
include "./classes/DAO.php";
include "./classes/Noticia.php";
include "./classes/Fonte.php";

//ini_set('default_charset','UTF-8');
// $tts = utf8_encode($tts);

/**
 * 
 * Classe responsável pelo leitura e consulta dos RSS do Serviço Sapo News
 */

class SapoClient extends Fonte {
	
	private $rss;		// Objecto da classe rss_php
	
	/**
	 * Contrutor da Classe SapoClient. Inicializa os atributos do objecto.
	 * Chama construtor da superclasse para inicializar:
	 *  - Nome da fonte: {@link $nome}
	 *  - URL principal da fonte {@link $main_url} 
	 */	
	public function __construct() {
		parent::__construct("RSS Sapo Notícias");
		$this->rss = new rss_php();
	}
	
	/**
	 * 
	 * Busca das notícias publicadas no RSS com palavras presentes no RSS Feed
	 * @param String[] $parameters
	 * 			Array com palavras a serem pesquisadas nos itens RSS
	 */ 
	public function search($parameters) {
		//Array com as noticias encontradas
		$results = array();
		
		foreach($parameters as $query) {
			//prepara query
			$encode = urldecode($query);
			$url_search = $this->main_url.$encode;
				
			//carrega RSS
			@$this->rss->load($url_search);
				
			//Cria array com itens presentes no RSS consultado
			$items = $this->rss->getItems();
				
			/** DEBUG **/
			//var_dump($items);
			//echo "<hr>";
				
			foreach($items as $news) {
				$myNew = new Noticia(); 
	 			$myNew->setIdfonte($this->idfonte);
	 			$myNew->setData_pub(isset($news["dataPub"]) ?
	 									Util::formatDateToDB($news["dataPub"])
	 									: "");
	 			$myNew->setAssunto(isset($news["title"]) ?
	 									addslashes($news["title"])
	 									: "");
				$myNew->setDescricao(isset($news["description"]) ?
										addslashes($news["description"])
										: "");
				@$myNew->setTexto(isset($news["link"]) ?
										addslashes(file_get_contents($news["link"]))
										: "");
				$myNew->setUrl(isset($news["link"]) ?
										addslashes($news["link"])
										: ""); 
				
				//ParserNoticia::parseNoticia($myNew);
				var_dump($myNew);
				$results[] = $myNew;
			}
		}
		return $results;
	}
}

$sapo = new SapoClient();
$parameters = Util::getSearchParameters();
$news = $sapo->search($parameters);
//$n = new Noticia();
//$msg = $n->insert($news);
echo(count($news));
