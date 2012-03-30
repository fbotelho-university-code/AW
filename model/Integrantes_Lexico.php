<?php
/*
 * Created on Mar 19, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once('Model.php'); 

class Integrantes_Lexico extends Model{
	var $idintegrante; 
	var $idlexico; 
	
	public function getIdIntegrante(){ return $this->idintegrante; }
	public function setIdIntegrante($v) {$this->idintegrante = $v; }
	public function getIdLexico() { return $this->idlexico; }
	public function setIdLexico($v) {$this->idlexico = $v; }
	
	
	public function __toString(){
			$res = "IntegrantesLexicos : "; 
		if ($this->idintegrante)  $res .= "ID Integrante :" . $this->idintegrante . " |"; 
		if ($this->idlexico)  $res .= "ID Lexico:" . $this->idlexico ;
		return $res; 
	}	
}
?>
