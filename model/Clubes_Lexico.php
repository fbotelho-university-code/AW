<?php
require_once("Model.php"); 
/*
 * Created on Mar 15, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Clubes_Lexico extends Model{
	/**
	 * Identificador do clube
	 * @var int
	 */
 	var $idclube; 
	
	public function checkValidity(){
		return true; 
	}
	 
 	/**
 	 * Identificador do lexico
 	 * @var int
 	 */
 	var $idlexico; 
 	
 	/**
 	* Retorna o identificador do clube
 	* @return int {@link $idclube}
 	*/
	public function getIdClube(){
		return $this->idclube;
	}  
	
	/**
	* Altera o valor do identificador do clube {@link $idclube}
	* @param int $id
	*/
	public function setIdClube($id) {
		$this->idclube = $id;
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
	public function setIdLexico($id) {
		$this->idlexico = $id;
	}
	
	/**
	* Retorna o objeto em forma de String. Usado para depuração.
	* @return String $res
	*/
	public function __toString(){
		$res = "ClubesLexicos : "; 
		if ($this->idclube)  $res .= "ID CLUBE :" . $this->idclube . " |"; 
		if ($this->idlexico)  $res .= "ID Lexico:" . $this->idlexico ;
		return $res; 
	}
 }	
?>
