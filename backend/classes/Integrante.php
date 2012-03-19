<?php

require_once "DAO.php";

class Integrante extends DAO {
	
	var $idintegrante='';
	var $idclube;
	var $idfuncao;
	var $nome_integrante;
	
	public function __construct() {
		parent::__construct(); 
	}
	
	public function getIdintegrante(){
		return $this->idintegrante;
	}
	
	public function setIdintegrante($id) {
		$this->idintegrante = $id;
	}
	
	public function getIdclube() {
		return $this->idclube;
	}
	
	public function setIdclube($id) {
		$this->idclube = $id;
	}
	
	public function getIdfuncao() {
		return $this->idfuncao;
	}
	
	public function setIdfuncao($id) {
		$this->idfuncao = $id;
	}
	
	public function getNome_integrante() {
		return $this->nome_integrante;
	}
	
	public function setNome_integrante($nome) {
		$this->nome_integrante = $nome;
	}
	
	public function retrieveIntegrante($param) {

		/** Query para busca do integrante pelo nome **/
		$sql = "SELECT * FROM integrante WHERE ";
		if(is_int($param)) {
			$sql .= "idintegrante = ".$param;
		}
		else {
			$sql .= "nome_integrante = '".$param."'";
		}
				
		/** Execuчуo da Query **/
		$dao = new DAO();
		$rs = $dao->execute($sql);
		//$rs = $dao->db->Execute($sql) or die($dao->$db->ErrorMsg());
		
		/** Construчуo do Objeto Integrante usando resposta da consulta **/
		$this->mountIntegrante($rs->fields);
	}
	
	/*public function getIntegranteById($id) {

		$sql = "SELECT * FROM integrante WHERE id = " . $this->nome_integrante;
		

		$dao = new DAO();
		$rs = $dao->execute($sql);
		//$rs = $dao->db->Execute($sql) or die($dao->$db->ErrorMsg());
		
		 //Construчуo do Objeto Integrante usando resposta da consulta 
		$this->mountIntegrante($rs->fields);
	}
	*/
	
}

?>