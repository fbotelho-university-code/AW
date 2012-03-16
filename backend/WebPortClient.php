<?php

require "lib/rss_php.php";
include "lib/Util.php";
include "./classes/DAO.php";
include "./classes/Noticia.php";
include "./classes/Fonte.php";

ini_set('default_charset','UTF-8');

/**
 * 
 * Classe responsável pelo leitura e consulta no Arquivo da Web Portuguesa
 */

class WebPortClientClient extends Fonte {
	
	private $rss;		// Objecto da classe rss_php
	
	/**
	 * Contrutor da Classe WebPortClientClient. Inicializa os atributos do objecto.
	 * Chama construtor da superclasse para inicializar:
	 *  - Nome da fonte: {@link $nome}
	 *  - URL principal da fonte {@link $main_url} 
	 */	
	public function __construct() {
		parent::__construct("Arquivo da Web Portuguesa", "http://arquivo.pt/opensearch?query=");
		$this->rss = new rss_php();
	}
	
	/**
	 * 
	 * Busca das notícias publicadas no RSS com palavras presentes no RSS Feed
	 * @param String[] $parameters
	 * 			Array com palavras a serem pesquisadas nos itens RSS
	 */ 
	public function search($parameters) {
		foreach($parameters as $query) {
			//prepara query
			$encode = urldecode($query);
			$url_search = $this->main_url.$encode;
			
			//carrega RSS
			@$this->rss->load($url_search);
			
			//Cria array com itens presentes no RSS consultado
			$items = $this->rss->getItems();
			
			//Array com as noticias encontradas
			$results = array();
			
			/** DEBUG **/
			//print_r($items);
			//echo "<hr>";
			
			foreach($items as $news) {
				$myNew = new Notica(); 
				$myNew->setIdFonte($this->idfonte); 				//identificador da fonte
				$myNew->setIdLocal(1);							//@todo buscar ref espacial
				$myNew->setData_pub(Util::formatTstampToDb($news["pwa:tstamp"]));
				$myNew->setData_noticia("");					//@todo buscar ref temporal
				$myNew->setAssunto(addslashes($news["title"]));
				$myNew->setDescricao(addslashes($news["pwa:digest"]));
				$myNew->setTexto("");							//@todo buscar texto da noticia
				$myNew->setUrl($news["link"]);
				
				
				//ParserNoticia::parserNoticia($myNew);			//@todo
				///$myNew["entidade"] = $parameters[$j];			//@todo inserir identidicador da identidade
				$results[] = $myNew;
			}
		}
		return $results;
	}
}
/*
$arq = new WebPortClientClient();
$clubes = array("Benfica", "Porto", "Sporting");
$news = $arq->search($clubes);
$n = new Noticia();
$msg = $n->insert($news);
echo $msg;
*/
?>