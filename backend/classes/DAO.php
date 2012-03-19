<?php

include ("./adodb/adodb.inc.php");

class DAO extends ADOConnection {
	
	private $mysgbd = "mysql";
	private $myserver = "localhost";
	private $myuser = "root";
	private $mypassword = "fabiim";
	private $mydbName = "aw";
	
	public $db;
	
	function __construct() {
		
		$this->db = &ADONewConnection($this->mysgbd);
		
		/* Ativa Associação dos nomes das colunas das tabelas da BD com as chaves dos arrays de retorno de consulta */
		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
	}
	
	/**
	 * Conecta com a base de dados
	 */
	function connect() {
		$this->db->Connect($this->myserver, $this->myuser, $this->mypassword, $this->mydbName) or die($this->db->ErrorMsg());
	}
	
	/**
	 * Disconecta com a base de dados
	 */
	function disconnect() {
		$this->db->Close();
	}

	/**
	 * Executa uma SQL
	 * @param String $sql
	 * @return ResultSet $rs Resultado da SQL executada
	 */
	function execute($sql) {
		$this->connect();
		$rs = $this->db->Execute($sql) or die($this->db->ErrorMsg());
		$this->disconnect();
		return $rs;
	}
	
	/**
	 * Insere um objeto na base de dados
	 * @return int $id Identificador do registo inserido
	 */
	
	public function add(){
		$this->connect();
		$table = get_class($this);
		$fields = get_object_vars($this);
		$rs = $this->db->AutoExecute($table, $fields, "INSERT") or die($this->db->ErrorMsg());
		$id = $this->db->Insert_ID();
		$this->disconnect();
		return $id;
	}
	
	/**
	 * Apaga todos os registos de uma tabela na base de dados
	 * @return boolean
	 */
	public function clear() {
		$table = get_class($this);
		$sql = "TRUNCATE TABLE ". $table;
		$rs = $this->execute($sql);
		if($rs) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Retorna todos os registos da base de dados de uma tabela
	 * @return Object[] $objects Array de Objectos com atributos da base de dados
	 */
	public function getAll(){
		$table = get_class($this);
		$sql = "SELECT  * FROM ". $table;
		$rs = $this->execute($sql);
		$objects = array();
		while(!$rs->EOF) {
			$arrayAssoc = $rs->fields;
			foreach($arrayAssoc as $key => $value) {
				$this->$key = $value;
			}
			$objects[] = $this;
			$rs->MoveNext();
		}
		return $objects;
	}
	
	/**
	 * Recupera um objecto da base de dados pelo seu id
	 * @param int $id Identificador do objecto na base de dados
	 */
	public function getObjectById($id) {
		$table = get_class($this);
		$sql = "SELECT * FROM ".$table. " WHERE id".$table." = ".$id;
		$rs = $this->execute($sql);
		foreach($rs->fields as $key => $value) {
			$this->$key = $value;
		}
	}
}

