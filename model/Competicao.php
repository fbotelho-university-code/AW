<?php

require_once "Model.php";

/**
 * Classe que representa uma Competiчуo do Futebol Portuguъs
 */
class Competicao extends Model {
	
	public function checkValidity(){
		return true; 
	}
	 
	/**
	 * Identificador da Competicao
	 * @var int
	 */
	var $idcompeticao;
	
	/**
	 * Nome da Competicao
	 * @var String
	 */
	var $nome_competicao;
	
	/**
	 * Construtor da Classe
	 * Chama o construtor da classe pai
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Retorna o identificador da Competicao
	 * @return int {@link $idcompeticao}
	 */
	public function getIdcompeticao() {
		return $this->idcompeticao;
	}
	
	/**
	* Altera o valor do identificador da Competicao {@link $idcompeticao}
	* @param int $id
	*/
	public function setIdcompeticao($id) {
		$this->idcompeticao = $id;
	}
	
	/**
	* Retorna o nome da Competicao
	* @return String {@link $nome_competicao}
	*/
	public function getNome_competicao() {
		return $this->nome_competicao;
	}
	
	/**
	* Altera o valor da Competicao {@link $nome_competicao}
	* @param String $n
	*/
	public function setNome_competicao($n) {
		$this->nome_competicao = $n;
	}
		
}

?>