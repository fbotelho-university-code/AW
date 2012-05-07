<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "Model.php";

/**
  * Classe que representa um local.
  * Pode ser um Distrito, Ilha ou Concelho de Portugal
  */
class Local extends Model{
	
	public function checkValidity(){
		
		if (
				preg_match('/\-?\d+\.?\d*/', $this->lat ) == 1 &&
				preg_match('/\-?\d+\.?\d*/', $this->long ) == 1
		)
	    return true; 
	}
	 
	public function getKeyFields(){
		return array ('idlocal'); 
	}
	 
	/**
	* Identificador do local
	* @var int
	*/
	var $idlocal;
	
	/**
	* Nome do local
	* @var String
	*/
	var $nome_local;
	
	/**
	* Coordenadas do local
	* @var String
	*/
	
	/**
	* Contrutor da classe.
	*/
	public function __construct() {
		parent::__construct();
	}
	
	public function getBetween($lat_low, $lat_up, $long_low, $long_up){
		$sql = "select idlocal from Local where lat between ". $long_low . " AND " . $lat_up . " AND log between " . $long_low . " AND " . $long_up ;
				
		echo $sql; 
		$rs = $this->dao->execute($sql); 
		if (!isset($rs) ) return; 
		$objects = array();

		while(!$rs->EOF) {
			$arrayAssoc = $rs->fields;
			$obj = new Local();
			$this->setObj($arrayAssoc, $obj);
			$objects[] = $obj;
			$rs->MoveNext();
		}
		return $objects;
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
	* Retorna o nome do local
	* @return String {@link $nome_local}
	*/
	public function getNome_local() {
		return $this->nome_local;
	}
	
	/**
	* Altera o valor do nome do local {@link $nome_local}
	* @param String $n
	*/
	public function setNome_local($n) {
		$this->nome_local = $n;
	}

}
?>