<?php
/*
 * Created on Mar 21, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 require_once("Model.php");
  
/**
* Classe que representa as referï¿½ncias temporais das noticias
*/
class Noticia_data extends Model{
	/**
	* Identificador da notï¿½cia
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
	 * @var String - Data presente no texto da notï¿½cia
	 */
	var $tempo;
	
	/**
	 * Interpretação da data encontrada na notícia em formato 0000-00-00
	 * @var String
	 */
	var $data_interpretada;
 
	/**
	 * Construtor da classe
	 * @param int $idnoticia - Identificador da noticia {@link $idnoticia}
	 * @param unknown_type $tempo - Referencia Temporal {@link $tempo}
	 */
<<<<<<< HEAD
	
	
	public function __construct($idnoticia = 0, $tempo = 0, $dt = 0){
=======
	public function __construct($idnoticia='', $tempo=''){
>>>>>>> origin/master
		parent::__construct();
		$this->idnoticia = $idnoticia;
		$this->tempo = $tempo;
		$this->data_interpretada = $dt;
	}
	
	/**
	* Retorna o identificador da notï¿½cia
	* @return int {@link $idnoticia}
	*/
	public function getIdNoticia() {
		return $this->idnoticia;
	}
	
	/**
	* Altera o valor do identificador da notï¿½cia {@link $idnoticia}
	* @param int $id
	*/
	public function setIdNoticia($v) {
		$this->idnoticia = $v;
	}
	
	/**
	 * Retorna a referencia temporal da noticia
	 * @return String {@link $tempo} - Data presente no texto da notï¿½cia
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
	
<<<<<<< HEAD
	/**
	* Retorna uma data presente na noticia, interpretada como AAAA-MM-DD
	* @return String {@link $data_interpretada}
	*/
	public function getData_interpretada() {
		return $this->data_interpretada;
	}
	
	/**
	 * Altera uma data presente na noticia, interpretada como AAAA-MM-DD
	 * @param String $v
	 */
	public function setData_interpretada($v) {
		$this->data_interpretada = $v;
=======
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
>>>>>>> origin/master
	}
 }
?>
