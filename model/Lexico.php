<?php

require_once "Model.php"; 

/**
  * Classe que representa o lexico utilizado na aplicacao
  */
class Lexico extends Model{
		
	var $nucleo; 
	var $contexto; 
	var $entidade; 
	var $tipo; 
	var $pol; // int 
	var $ambiguidade; //int
	var $idlexico ; //int  
	
	public function checkValidity(){
		return true; 
	}
	
	public function getKeyFields(){
		return array ('idlexico'); 
	}
	 
	 
	public function getNucleo() { return $this->nucleo; }
	public function getContexto() { return $this->contexto; }
	public function getEntidade() { return $this->entidade; }
	public function getTipo() { return $this->tipo; }
	public function getPol() { return $this->pol; }
	public function getAmbiguidade() { return $this->amgibuidade; }
	public function getIdlexico() { return $this->idlexico; }
	
	
	public function setNucleo($p) { $this->nucleo = $p; }
	public function setContexto($p) { $this->contexto = $p; }
	public function setEntidade($p) { $this->entidade = $p;  }
	public function setTipo($p) { $this->tipo = $p;  }
	public function setPol($p) { $this->pol = $p; }
	public function setAmbiguidade($p) { $this->ambiguidade = $p; }
	public function setIdlexico($p) { $this->idlexico = $p;  }

}
?>
