<?php

include ("./adodb/adodb.inc.php");

class DAO extends ADOConnection {
	
	private $mysgbd = "mysql";
	private $myserver = "localhost";
	private $myuser = "root";
	private $mypassword = "pcdamf06";
	private $mydbName = "aw";
	
	public $db;
	
	function __construct() {
		
		$this->db = &ADONewConnection($this->mysgbd);
		
		/* Ativa Associação dos nomes das colunas das tabelas da BD com as chaves dos arrays de retorno de consulta */
		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
	}
	
	function connect() {
		//parent::Connect($this->$myserver, $this->myuser, $this->mypassword, $this->mydbName);
		$this->db->Connect($this->myserver, $this->myuser, $this->mypassword, $this->mydbName) or die($this->db->ErrorMsg());
	}
	
	function disconnect() {
		//parent::Close();
		$this->db->Close();
	}

	function execute($sql) {
		$this->connect();
		$rs = $this->db->Execute($sql) or die(ErrorMsg());
		$this->disconnect();
		return $rs;
	}
}

