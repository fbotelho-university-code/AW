<?php

require_once('DAO.php'); 


/**
 * Classe que representa o relacionamento de Clubes com o Lexico
 */
class Integrantes_Lexico extends DAO{
	
	/**
	* Identificador do integrante
	* @var int
	*/
	var $idintegrante; 
	
	/**
 	 * Identificador do lexico
 	 * @var int
 	 */
	var $idlexico; 
	
	/**
	* Retorna o identificador do integrante
	* @return int {@link $idintegrante}
	*/
	public function getIdIntegrante(){
		return $this->idintegrante;
	}
	
	/**
	* Altera o valor do identificador do integrante {@link $idintegrante}
	* @param int $id
	*/
	public function setIdIntegrante($id) {
		$this->idintegrante = $id;
	}
	
	/**
	* Retorna o identificador do lexico
	* @return int {@link $idlexico}
	*/
	public function getIdLexico() {
		return $this->idlexico;
	}
	
	/**
	* Altera o valor do identificador do lexico {@link $idlexico}
	* @param int $id
	*/
	public function setIdLexico($v) {
		$this->idlexico = $v;
	}
	
	/**
	* Retorna o objeto em forma de String. Usado para depura��o.
	* @return String $res
	*/
	public function __toString(){
			$res = "IntegrantesLexicos : "; 
		if ($this->idintegrante)  $res .= "ID Integrante :" . $this->idintegrante . " |"; 
		if ($this->idlexico)  $res .= "ID Lexico:" . $this->idlexico ;
		return $res; 
	}	
}
?>
