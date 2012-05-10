<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "Model.php";

/**
  * Classe que representa um Integrante de um clube
  */
class Integrante extends Model{
	
	/**
	* Identificador do integrante
	* @var int
	*/
	var $idintegrante;
	
	public function checkValidity(){
		return true; 
	}
	 
	 	 
	public function getKeyFields(){
		return array ('idintegrante'); 
	}
	 
	
	/**
	* Identificador do clube do integrante
	* @var int
	*/
	var $idclube;
	
	/**
	* Identificador da fun��o do integrante
	* @var int
	*/
	
	/**
	* Nome do integrante
	* @var String
	*/
	var $nome_integrante;
	
	/**
	 * Construtor da classe
	 */
	public function __construct() {
		parent::__construct(); 
	}
	
	/**
	* Retorna o identificador do integrante
	* @return int {@link $idintegrante}
	*/
	public function getIdintegrante(){
		return $this->idintegrante;
	}
	
	/**
	* Altera o valor do identificador do integrante {@link $idintegrante}
	* @param int $id
	*/
	public function setIdintegrante($id) {
		$this->idintegrante = $id;
	}
	
	/**
	* Retorna o identificador do clube do integrante
	* @return int {@link $idclube}
	*/
	public function getIdclube() {
		return $this->idclube;
	}
	
	/**
	* Altera o valor do identificador do clube do integrante {@link $idclube}
	* @param int $id
	*/
	public function setIdclube($id) {
		$this->idclube = $id;
	}
	
	/**
	* Retorna o identificador da fun��o do integrante
	* @return int {@link $idfuncao}
	*/
	public function getIdfuncao() {
		return $this->idfuncao;
	}
	
	/**
	* Altera o valor do identificador da fun��o do integrante {@link $idfuncao}
	* @param int $id
	*/
	public function setIdfuncao($id) {
		$this->idfuncao = $id;
	}
	
	/**
	* Retorna o nome do integrante
	* @return String {@link $nome_integrante}
	*/
	public function getNome_integrante() {
		return $this->nome_integrante;
	}
	
	/**
	* Altera o valor do nome do integrante {@link $nome_integrante}
	* @param String $nome
	*/
	public function setNome_integrante($nome) {
		$this->nome_integrante = $nome;
	}
	public function __toString(){
		$res = 'Integrante'; 
		if ($this->idclube) $res .= ' ID CLUBE : ' . $this->idclube . ' |';
		if ($this->idfuncao) $res .= ' ID FUNCAO : ' . $this->idfuncao . ' |';
		if ($this->nome_integrante) $res .= ' NOME: ' . $this->nome_integrante . ' | ' ;
		if ($this->idintegrante) $rs .= 'ID  : ' . $this->idintegrante;
		return $res; 
	}
	
	public function getUrl2(){
		$v = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		$r = $v['scheme'] . '://' . $v['host'] . $v['path'];
		$pos = strpos($r, 'webservice/') ;
		$val = substr($r, 0, $pos );
		return $val;
	}
	
	public function setObj($arrayAssoc, $obj){
		foreach($arrayAssoc as $key => $value){
			$obj->$key = $value;
		}
		if (isset($obj->url_img)){
			$obj->url_img =  $this->getUrl2() . 'webservice/entidades.php/integrante/' . $obj->idintegrante  . '/thumbnail';
		}
		else {
			$obj->url_img = ""; 
		}
	}
}

?>