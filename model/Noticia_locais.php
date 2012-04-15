<?php

require_once "Model.php";
require_once "includes.php";  

 /**
  * Classe que representa a rela�‹o Noticias Locais
  */
  class Noticia_locais extends Model{
  
  	public function checkValidity(){
		return true; 
	}
	
	public function getKeyFields(){
		return array ('idnoticia', 'idlocal' ); 
	}
	 
  	/**
  	* Identificador da noticia
  	* @var int
  	*/
  	var $idnoticia;
	
  	/**
  	* Identificador do local
  	* @var int
  	*/
  	var $idlocal;
  	
  	/**
  	 * Construtor da Classe
  	 */
  	public function __construct($idnoticia='', $idlocal='') {
  		parent::__construct();
  		$this->idnoticia = $idnoticia; 
  		$this->idlocal = $idlocal; 
  	}
  	
  	/**
  	* Retorna o identificador do local
  	* @return int {@link $idlocal}
  	*/
  	public function getIdlocal() {
  		return $this->idlocal;
  	}
  	
  	/**
  	 * Altera o valor do identificador do local {@link $idlocal}
  	 * @param int $id
  	 */
  	public function setIdlocal($id) {
  		$this->idlocal = $id;
  	}
  	
  	/**
  	* Retorna o identificador da notícia
  	* @return int {@link $idnoticia}
  	*/
  	public function getIdnoticia() {
  		return $this->idnoticia;
  	}
  	
  	/**
  	 * Altera o valor do identificador da notícia {@link $idnoticia}
  	 * @param int $id
  	 */
  	public function setIdnoticia($id) {
  		$this->idnoticia = $id;
  	}
	
  	public static function getAllLocais($locais_noticias, $baseurl){
  		$class_locais = new Local(); 
  		if (!$locais_noticias){
			return null; 
		}else{
			//Apanhar todos os locais atraves das referencias de locais_noticias: 
			$locais = array(); 
			foreach ($locais_noticias as $ln){
				$local = $class_locais->getObjectById($ln->getIdLocal());
				$local->follow = $baseurl . 'espaco.php/' . $local->idlocal ; 
				$locais[] = $local;  
			}
		}
		return $locais; 
  	}
  	
  	public static function getAllNoticias($idlocal){
			$class_this = new Noticia_Locais(); 
			$rel = $class_this->find(array("idlocal" => $idlocal)); 
			if (!$rel) return null; 
			$noticias = array();
			$clube_class = new Noticia();
			foreach($rel as $rl){
				$n =$clube_class->getObjectById($rl->getIdNoticia()); 
				$n->visivel = null; 
				$clubes[] = $n; 
			}
		return $clubes; 
	}
  }
	
	
?>
