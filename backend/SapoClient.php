<?php

require_once "includes.php";
require_once "ParserNoticias.php";
require_once "lib/rss_php.php"; 

/**
 * Classe respons�vel pelo leitura e consulta dos RSS do Servi�o Sapo News
 */
class SapoClient extends Fonte {
	
	/**
	* Objeto da classe rss_php
	* @var rss_php
	*/
	private $rss;
	
	/**
	 * Contrutor da Classe
	 */	
	public function __construct() {
		parent::__construct("RSS Sapo Noticias");
		$this->rss = new rss_php();
	}
	
	/**
	 * Busca das not�cias publicadas no RSS com palavras presentes no parametro de pesquisa
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
	 			$myNew->setIdfonte($this->idfonte);
	 			$myNew->setData_pub(isset($news["pubDate"]) ?
	 									Util::formatDateToDB($news["pubDate"])
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
				ParserNoticias::parseNoticia($myNew);
			}
		}
		echo "Foram inseridas not�cias da Fonte ".$this->getNome()." com sucesso.";
	}
}

$sapo = new SapoClient();
$parameters = Util::getSearchParameters();
$sapo->search($parameters);

