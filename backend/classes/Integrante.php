<?php


class Integrante {
	
	private $idintegrante;
	
	private $idclube;
	
	private $idfuncao;
	
	private $nome_integrante;
	
	public function __construct() {
		
	}
	
	public function getIdintegrante() {
		return $this->$idintegrante;
	}
	
	public function setIdintegrante($id) {
		$this->idclube = $idintegrante;
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
			$sql .= "idintegrante = ".$idintegrante;
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
	
	public function getIntegranteById($id) {
		/** Query para busca do integrante pelo nome **/
		$sql = "SELECT * FROM integrante WHERE id = ".$nome;
		
		/** Execuчуo da Query **/
		$dao = new DAO();
		$rs = $dao->execute($sql);
		//$rs = $dao->db->Execute($sql) or die($dao->$db->ErrorMsg());
		
		/** Construчуo do Objeto Integrante usando resposta da consulta **/
		$this->mountIntegrante($rs->fields);
	}
	
	private function mountIntegrante($fields) {
		$this->idintegrante = $fields["idintegrante"];
		$this->idclube = $fields["idclube"];
		$this->idfuncao = $fields["idfuncao"];
		$this->nome_integrante = $fields["nome_integrante"];
	}
}


?>