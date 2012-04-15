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
	 
	 public function getKeyFields(){
		return array ('idfuncao'); 
	}
		
	/**
	 * Identificador da Fun��o
	 * @var int
	 */
	var $idfuncao;
	
	/**
	 * Nome da Fun��o
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
	* Retorna o identificador da fun��o
	* @return int {@link $idfuncao}
	*/
	function getIdfuncao() {
		return $this->idfuncao;
	}
	
	/**
	* Altera o valor do identificador da fun��o {@link $idfuncao}
	* @param int $id
	*/
	function setIdFuncao($id) {
		$this->idfuncao = $id;
	}
	
	/**
	* Retorna o nome da fun��o
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