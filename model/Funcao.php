<?php

require_once "Model.php"; 

/**
  * Classe que representa uma funcao de um integrante em um clube
  * (Ex: Presidente, Treinador, Jogador, etc.)
  */
class Funcao extends Model{
	
	public function checkValidity(){
		return true; 
	}
	 
	/**
	 * Identificador da Função
	 * @var int
	 */
	var $idfuncao;
	
	/**
	 * Nome da Função
	 * @var String
	 */
	var $funcao;
	
	/**
	 * Construtor da Classe
	 * Chama o construtor da classe pai
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Retorna o identificador da função
	* @return int {@link $idfuncao}
	*/
	function getIdfuncao() {
		return $this->idfuncao;
	}
	
	/**
	* Altera o valor do identificador da função {@link $idfuncao}
	* @param int $id
	*/
	function setIdFuncao($id) {
		$this->idfuncao = $id;
	}
	
	/**
	* Retorna o nome da função
	* @return String {@link $funcao}
	*/
	function getFuncao() {
		return $this->funcao();
	}
	
	/**
	* Altera o valor do nome da funcao {@link $funcao}
	* @param String $f
	*/
	function setFuncao($f) {
		$this->funcao = $f;
	}
}