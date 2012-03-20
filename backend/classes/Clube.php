<?php

require_once "DAO.php";

/**
 * Classe que representa um clube de futebol
 *  (Ex: Benfica, Porto, Sporting, etc.)
 */
class Clube extends DAO {
	
	/**
	* Identificador do clube
	* @var int
	*/
	var $idclube;
	
	/**
	 * Identificador do local do clube
	 * @var int
	 */
	var $idlocal;
	
	/**
	 * Identificador da competiчуo que o clube participa
	 * @var int
	 */
	var $idcompeticao;
	
	/**
	 * Nome do clube
	 * @var String
	 */
	var $nome_clube;
	
	/**
	 * Construtor da classe. Inicializa o nome do clube, se houver {@link $nome_clube}
	 * @param String $n
	 */	
	public function __construct($n ='') {
		parent::__construct();
		if ($n != '' ){
			$this->nome_clube = $n;
		}
	}
	
	/**
	* Retorna o identificador do clube
	* @return int {@link $idclube}
	*/
	public function getIdclube() {
		return $this->idclube;
	}
	
	/**
	* Altera o valor do identificador do clube {@link $idclube}
	* @param int $id
	*/
	public function setIdclube($id) {
		$this->idclube = $id;
	}
	
	/**
	* Retorna o identificador do local do clube
	* @return int {@link $idlocal}
	*/
	public function getIdlocal() {
		return $this->idlocal;
	}
	
	/**
	* Altera o valor do identificador do local do clube {@link $idlocal}
	* @param int $id
	*/
	public function setIdlocal($id) {
		$this->idlocal = $id;
	}
	
	/**
	* Retorna o identificador da competicao do clube
	* @return int {@link $idcompeticao}
	*/
	public function getIdcompeticao() {
		return $this->idcompeticao;
	}
	
	/**
	* Altera o valor do identificador da competicao do clube {@link $idcompeticao}
	* @param int $id
	*/
	public function setIdcompeticao($id) {
		$this->idcompeticao = $id;
	}
	
	/**
	* Retorna o nome do clube
	* @return String {@link $nome_competicao}
	*/
	public function getNome_clube() {
		return $this->nome_clube;
	}
	
	/**
	* Altera o valor do nome do clube {@link $nome_competicao}
	* @param String $n
	*/
	public function setNome_clube($n) {
		$this->nome_clube = $n;
	}
}

?>