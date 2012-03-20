<?php

require_once "includes.php";
require_once "ParserNoticias.php";

/**
 * Classe responsável pelo leitura e consulta no Arquivo da Web Portuguesa
 */

class WebPortClient extends Fonte {
	
	/**
	 * Objeto da classe rss_php
	 * @var rss_php
	 */
	private $rss;
	
	/**
	 * Contrutor da Classe
	 */	
	public function __construct() {
		parent::__construct("Arquivo da Web Portuguesa");
		$this->rss = new rss_php();
	}
	
	/**
	 * Busca das notícias publicadas no RSS com palavras presentes no prametro de pesquisa
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
			
			//Insere na Base de Dados e caracteriza semanticamente cada noticia encontrada
			foreach($items as $news) {
				$myNew = new Noticia(); 
				$myNew->setIdFonte($this->idfonte); 
				$myNew->setData_pub(isset($news["title"]) ?
									Util::formatTstampToDb($news["pwa:tstamp"])
									: "");
				$myNew->setAssunto(isset($news["title"]) ?
									addslashes($news["title"])
									: "");
				$myNew->setDescricao(isset($news["pwa:digest"]) ?
									addslashes($news["pwa:digest"])
									: "");
				@$myNew->setTexto(isset($news["link"]) ?
										addslashes(file_get_contents($news["link"]))
										: "");
				$myNew->setUrl(isset($news["link"]) ?
										addslashes($news["link"])
										: ""); 
				ParserNoticias::parseNoticia($myNew);
			}
		}
	}
}

$arq = new WebPortClient();
$parameters = Util::getSearchParameters();
$arq->search($parameters);

?>