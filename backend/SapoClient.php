<?php

require "lib/rss_php.php";
include "lib/Util.php";
include "lib/simple_html_dom.php";
include "./classes/DAO.php";
include "./classes/Noticia.php";
include "./classes/Fonte.php";

//ini_set('default_charset','UTF-8');

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
		parent::__construct("RSS Sapo Notícias", "http://noticias.sapo.pt/rss/news/");
		$this->rss = new rss_php();
	}
	
	/**
	 * 
	 * Busca das notícias publicadas no RSS com palavras presentes no RSS Feed
	 * @param String[] $parameters
	 * 			Array com palavras a serem pesquisadas nos itens RSS
	 */ 
	public function search($parameters) {
		//carrega RSS
		$this->rss->load($this->main_url);
		
		//Cria array com itens presentes no RSS consultado
		$items = $this->rss->getItems();
		
		$records = array();
		
		//Busca das palavras presentes em $parameters nos itens do RSS
		
		for($i = 0; $i < count($items); $i++) {
			$news = $items[$i];
			for($j = 0; $j < count($parameters); $j ++) {
				$pos_title = strpos($news["title"], $parameters[$j]);
				$pos_description = strpos($news["description"], $parameters[$j]);
				if(!($pos_title === false) || !($pos_description === false)) {
					$myNew = new Noticia(); 
	 				$myNew->setIdfonte($thi->idfonte);
	 				$myNew->setIdLocal(1); 
	 				$myNew->setData_pub(Util::formatDateToDB($news["pubDate"]));
	 				$myNew->setData_noticia(""); //@todo buscar ref temporal
					$myNew->setAssunto(addslashes($news["title"]));
					$myNew->setDescricao(addslashes($news["description"]));
					$myNew->setTexto( addslashes(file_get_contents($news["link"])));							//@todo buscar texto da noticia 
					$myNew->setUrl($news['link']); 
					//$myNew["entidade"] = $parameters[$j];			//@todo inserir identidicador da identidade
					$records[] = $myNew;
				}
			}
		}
		return $records;
	}
}

$sapo = new SapoClient();
$clubes = array("Benfica", "Porto", "Sporting");
$news = $sapo->search($clubes);
$n = new Noticia();
$msg = $n->insert($news);
echo $msg;
