<?php

require_once "DAO.php";

/**
  * Classe que representa um Integrante de um clube
  */
class Integrante extends DAO {
	
	/**
	* Identificador do integrante
	* @var int
	*/
	var $idintegrante;
	
	/**
	* Identificador do clube do integrante
	* @var int
	*/
	var $idclube;
	
	/**
	* Identificador da funчуo do integrante
	* @var int
	*/
	var $idfuncao;
	
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
	* Retorna o identificador da funчуo do integrante
	* @return int {@link $idfuncao}
	*/
	public function getIdfuncao() {
		return $this->idfuncao;
	}
	
	/**
	* Altera o valor do identificador da funчуo do integrante {@link $idfuncao}
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
	
}

?>