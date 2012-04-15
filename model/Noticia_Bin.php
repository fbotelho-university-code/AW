<?php
require_once "Model.php";
require_once 'includes.php'; 
require_once 'lib/Util.php';

class Noticia_Bin extends Model{

 	/** Identificador da noticia
	 * @var int
	 */
	var $idnoticia = null;
	
	/**
	 * Identificador da fonte da notícia
	 * @var int
	 */
	var $idfonte;
	
	/**
	 * Data de publicação da notícia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	var $data_pub;  
	
	/**
	 * Data presente no corpo da notícia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	
	/**
	 * Assunto da notícia
	 * @var String
	 */
	var $assunto;
	
	/**
	 * Breve resumo da mensagem
	 * @var String
	 */
	var $descricao;
	
	/**
	 * Texto completo da not�cia
	 * @var String
	 */
	var $texto;
	
	/**
	 * URL contendo a íntegra da notícia
	 * @var String
	 */
	var $url;
	
	public function __construct($Noticia) {
		if(!($Noticia instanceof Noticia)) exit();
		parent::__construct();
		
		$this->idnoticia = $Noticia->getIdnoticia();
		$this->idfonte = $Noticia->getIdfonte();
		$this->data_pub = $Noticia->getData_pub();
		$this->assunto = $Noticia->getAssunto();
		$this->descricao = $Noticia->getDescricao();
		$this->texto = $Noticia->getTexto();
		$this->url = $Noticia->getUrl();
	}
	
	public function getKeyFields(){
		return array('idnoticia'); 		
	}
	
	public function checkValidity(){
		return true; 
	}
	
}
?>
