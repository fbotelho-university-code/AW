<?php

require_once "classes/DAO.php";

/**
* Classe que representa um local. Pode ser um Distrito, Ilha ou Concelho de Portugal
* @author Anderson Barretto - Nr 42541
* @author Fábio Botelho 	 - Nr 41625
* @author José Lopes		 - Nr 42437
* @author Nuno Marques		 - Nr 42809
* @package backend.classes
* @version 1.0 20120305
*/
class Local extends DAO{
	
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
	var $coordenadas;
	
	/**
	* Contrutor da classe.
	*/
	public function __construct() {
		parent::__construct();
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
	
	/**
	* Retorna as coordenadas do local no formato lat;long
	* @return String {@link $coordenadas}
	*/
	public function getCoordenadas() {
		return $this->coordenadas;
	}
	
	/**
	* Altera o valor das coordenadas do local {@link $coordenadas}
	* @param String $c
	*/
	public function setCoordenadas($c) {
		$this->coordenadas = $c;
	}
	
	
	public function __toString(){
		$str = 'Local - ';
		if ($this->idlocal) $str .=  ' IdLocal : ' . $this->idlocal;  
		if ($this->nome_local) $str .= ' Nome : ' . $this->nome_local;  
		if ($this->coordenadas) $str .= ' Coordenadas : ' . $this->coordenadas;
		return $str; 
	}
}
/*
$l= new Local();
$rs = $l->getAll(); 

foreach($rs as $ll){
	echo $ll . '<br/>'; 
}
*/
?>