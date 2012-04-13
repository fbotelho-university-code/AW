<?php
/*
 * Created on Mar 21, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 require_once("Model.php");
  
/**
* Classe que representa as refer�ncias temporais das noticias
*/
class Noticia_data extends Model{
	/**
	* Identificador da not�cia
	* @var int
	*/
	var $idnoticia; 
 
 	public function checkValidity(){
		return true; 
	}
	
	public function getKeyFields(){
		return array ('idnoticia', '$data'); 
	}
	
	 
	/**
	 * Referencia temporal da noticia.
	 * @var String - Data presente no texto da not�cia
	 */
	var $tempo; 
 
	/**
	 * Construtor da classe
	 * @param int $idnoticia - Identificador da noticia {@link $idnoticia}
	 * @param unknown_type $tempo - Referencia Temporal {@link $tempo}
	 */
	public function __construct($idnoticia='', $tempo=''){
		parent::__construct();
		$this->idnoticia = $idnoticia;
		$this->tempo = $tempo;
	}
	
	/**
	* Retorna o identificador da not�cia
	* @return int {@link $idnoticia}
	*/
	public function getIdNoticia() {
		return $this->idnoticia;
	}
	
	/**
	* Altera o valor do identificador da not�cia {@link $idnoticia}
	* @param int $id
	*/
	public function setIdNoticia($v) {
		$this->idnoticia = $v;
	}
	
	/**
	 * Retorna a referencia temporal da noticia
	 * @return String {@link $tempo} - Data presente no texto da not�cia
	 */
	public function getTempo() {
		return $this->tempo;
	}
	
	/**
	* Altera a referencia temporal da noticia {@link $tempo}
	* @param String $v
	*/
	public function setTempo($v) {
		$this->tempo = $v;
	}
	
	public static function getAllDatas($idNoticia){
		$class_Noticia_Locais = new Noticia_data(); 
		$rel = $class_Noticia_Locais->find(array("idnoticia" =>  $idNoticia));
		if (!$rel) return null;
		
		//Apanhar todos os locais atraves das referencias de locais_noticias: 
		$datas = array();
		foreach ($rel as $ln){
			$data = $ln->getTempo();
		}
		return $datas; 
	}
 }
?>
