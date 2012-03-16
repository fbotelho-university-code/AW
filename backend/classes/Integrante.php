<?php


class Integrante {
	
	private $idintegrante='';
	private $idclube;
	private $idfuncao;
	private $nome_integrante;
	public function __construct() {
		
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
				
		/** Execução da Query **/
		$dao = new DAO();
		$rs = $dao->execute($sql);
		//$rs = $dao->db->Execute($sql) or die($dao->$db->ErrorMsg());
		
		/** Construção do Objeto Integrante usando resposta da consulta **/
		$this->mountIntegrante($rs->fields);
	}
	
	public function getIntegranteById($id) {
		/** Query para busca do integrante pelo nome **/
		$sql = "SELECT * FROM integrante WHERE id = " . $this->nome_integrante;
		
		/** Execução da Query **/
		$dao = new DAO();
		$rs = $dao->execute($sql);
		//$rs = $dao->db->Execute($sql) or die($dao->$db->ErrorMsg());
		
		/** Construção do Objeto Integrante usando resposta da consulta **/
		$this->mountIntegrante($rs->fields);
	}
	
	/**
	 * Get all integrantes from the database. 
	 * @returns An array of objects Integrante. 
	 */
	public static function getAll(){
		$dao = new DAO(); 
		$dao->connect(); 
		
		$sql = "SELECT  * FROM integrante";

		//TODO - does not dies ? 
		$rs = $dao->db->execute($sql);
		
		if (!$rs){
		   die ($dao->db->ErrorMsg()); 
		}
		
		$integrantes = array(); // array de locais para retornar
		
		while (!$rs->EOF){
			$integrantes[] = Integrante::fromHash($rs->fields);
			$rs->MoveNext();
		}
		
		$rs->Close(); 
		$dao->disconnect();
		return $integrantes;		
	}

	/**
	 * 	Convert Integrante from Hash Table 
	 * @returns An object Integrante 
 	*/
	public static function fromHash($fields){
		$int = new Integrante();
		//echo '<br/> . id: ' . $fields["idintegrante"] .  $fields["nome_integrante"] . '<br/>' ; 
		$int->setIdintegrante($fields["idintegrante"]);
		$int->setIdclube($fields["idclube"]); 
		$int->setIdfuncao($fields["idfuncao"]); 
		$int->setNome_integrante($fields["nome_integrante"]); 		
		return $int; 
	}
	 
	 
	private function mountIntegrante($fields) {
		$this->idintegrante = $fields["idintegrante"];
		$this->idclube = $fields["idclube"];
		$this->idfuncao = $fields["idfuncao"];
		$this->nome_integrante = $fields["nome_integrante"];
	}
}

?>