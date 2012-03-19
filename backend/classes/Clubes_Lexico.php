<?php
require_once("DAO.php"); 
/*
 * Created on Mar 15, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Clubes_Lexico extends DAO{
	var $idclube; 
	var $idlexico; 

	public function getIdClube(){return $this->idclube;}  
	public function getIdLexico() {return $this->idlexico; }
	public function setIdClube($p) {$this->idclube = $p; }
	public function setIdLexico($p) {$this->idlexico = $p; }

	public function __toString(){
		$res = "ClubesLexicos : "; 
		if ($this->idclube)  $res .= "ID CLUBE :" . $this->idclube . " |"; 
		if ($this->idlexico)  $res .= "ID Lexico:" . $this->idlexico ;
		return $res; 
	}
 }	
?>
