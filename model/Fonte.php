<?php

require_once "Model.php";

/**
 * Classe que representa uma fonte de informações da Web
 *  (Google News, Sapo News, Twitter, etc.)
 */
class Fonte extends Model {
	
	/**
	* Identificador da fonte
	* @var int
	*/
	var $idfonte;
	
	/**
	* Nome da fonte
	* @var String
	*/
	var $nome;
	
	/**
	* URL principal da fonte
	* @var String
	*/
	var $main_url;
	
	/**
	* Visibilidade das notícias recolhidas da fonte
	* @var boolean
	*/
	var $ligado;
	
	/**
	 * Contrutor da classe.
	 */
	public function __construct($n = "") {
		parent::__construct();
		if($n != "") {
			$this->nome = $n; 
			$where = array("nome" => $this->nome);
			$obj = $this->findFirst($where);
			$this->setIdfonte($obj->idfonte);
			$this->setMain_url($obj->main_url);
			$this->setLigado($obj->ligado);
		}
	}
	
	/**
	* Retorna o identificador da fonte
	* @return int {@link $idfonte}
	*/
	public function getIdfonte() {
		return $this->idfonte;
	}
	
	/**
	* Altera o valor do identificador da fonte {@link $idfonte}
	* @param int $id
	*/
	public function setIdfonte($id) {
		$this->idfonte =$id;
	}
	
	/**
	* Retorna o nome da fonte
	* @return String {@link $nome}
	*/
	public function getNome() {
		return $this->nome;
	}
	
	/**
	* Altera o valor do nome da fonte {@link $nome}
	* @param String $n Novo nome da fonte
	*/
	public function setNome($n) {
		$this->nome = $n;
	}
	
	/**
	* Retorna a URL principal da fonte
	* @return String {@link $url}
	*/
	public function getMain_url() {
		return $this->main_url;
	}
	
	/**
	* Altera o valor da URL principal da fonte {@link $main_url}
	* @param String $u Nova URL da fonte
	*/
	public function setMain_url($u) {
		$this->main_url = $u;
	}
	
	/**
	* Retorna a visibilidade da fonte
	* @return Boolean {@link $ligado}
	*/
	public function getLigado() {
		return $this->ligado;
	}
	
	/**
	 * Altera o valor da visibilidade da fonte {@link $ligado}
	 * @param Boolean $l Nova visibilidade da fonte
	 */
	public function setLigado($l) {
		$this->ligado = $l;
	}
}

?>