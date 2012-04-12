<?php
/*
 * Created on Mar 19, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Integrantes_Lexico extends Model{
	
	/**
	* Identificador do integrante
	* @var int
	*/
	var $idintegrante; 
	
	/**
 	 * Identificador do lexico
 	 * @var int
 	 */
	var $idlexico; 
	
		public function checkValidity(){
		return true; 
	}
	 
	 public function getKeyFields(){
		return array ('idintegrante', 'idlexico'); 
	}
	 
	/**
	* Retorna o identificador do integrante
	* @return int {@link $idintegrante}
	*/
	public function getIdIntegrante(){
		return $this->idintegrante;
	}
	
	/**
	* Altera o valor do identificador do integrante {@link $idintegrante}
	* @param int $id
	*/
	public function setIdIntegrante($id) {
		$this->idintegrante = $id;
	}
	
	/**
	* Retorna o identificador do lexico
	* @return int {@link $idlexico}
	*/
	public function getIdLexico() {
		return $this->idlexico;
	}
	
	/**
	* Altera o valor do identificador do lexico {@link $idlexico}
	* @param int $id
	*/
	public function setIdLexico($v) {
		$this->idlexico = $v;
	}
	
	/**
	* Retorna o objeto em forma de String. Usado para depuração.
	* @return String $res
	*/
	public function __toString(){
			$res = "IntegrantesLexicos : "; 
		if ($this->idintegrante)  $res .= "ID Integrante :" . $this->idintegrante . " |"; 
		if ($this->idlexico)  $res .= "ID Lexico:" . $this->idlexico ;
		return $res; 
	}	
}
?>
