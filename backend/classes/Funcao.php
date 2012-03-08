<?php

class Funcao {
	
	private $id;
	private $funcao;
	
	function __construct() {
		$this->id = 0;
		$this->funcao = "";
	}
	
	function __construct($i, $f) {
		$this->id = $i;
		$this->funcao = $f;
	}
	
	function getId() {
		return $this->id;
	}
	
	function setId($i) {
		$this->id = $i;
	}
	
	function getFuncao() {
		return $this->funcao();
	}
	
	function setFuncao($f) {
		$this->funcao = $f;
	}
}