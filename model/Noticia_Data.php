<?php
/*
 * Created on Mar 21, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 require_once("Model.php");

class data {
	
}  

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
	 * Interpreta��o da data encontrada na not�cia em formato 0000-00-00
	 * @var String
	 */
	var $data_interpretada;
 
	/**
	 * Construtor da classe
	 * @param int $idnoticia - Identificador da noticia {@link $idnoticia}
	 * @param unknown_type $tempo - Referencia Temporal {@link $tempo}
	 */
	 
	public function __construct($idnoticia='', $tempo='', $dt =''){
		parent::__construct();
		$this->idnoticia = $idnoticia;
		$this->tempo = $tempo;
		$this->data_interpretada = $dt;
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
	}
	
	public static function getAllDatas($idNoticia){
		$class_Noticia_Locais = new Noticia_data(); 
		$rel = $class_Noticia_Locais->find(array("idnoticia" =>  $idNoticia));
		if (!$rel) return null;
		//Apanhar todos os locais atraves das referencias de locais_noticias: 
		$datas = array();
		foreach ($rel as $ln){
			//$data = new data(); 
			//$data->data =
			$n = $ln->getData_interpretada();   
			$datas[] =  $n; 
		}
		return $datas; 
	}
	
	public static function getAllNoticias($data){
		$class_Noticia_Locais = new Noticia_Data();
		$rel = $class_Noticia_Locais->find(array("data_interpretada" => $data), ' LIKE ');
		if (!$rel) return null;
		
		//var_dump($rel); 
		$noticias = array(); 
		$class_noticia = new Noticia();
		
		foreach($rel as $ln){
			$idnoticia = $ln->getIdNoticia();
			$bol = true;
			foreach($noticias as $k){
				if ($k->getIdNoticia() == $idnoticia) {
					$bol = false; 
					break; 
				}
			}
			if ($bol){
				$n = $class_noticia->getObjectById($idnoticia); 
				$n->visivel = null; 
				$noticias[] = $n; 
			}
		}
		return $noticias; 
	}
 }
?>
