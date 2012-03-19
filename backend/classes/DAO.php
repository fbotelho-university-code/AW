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
	public  function getAll(){
		$table = get_class($this);
		$sql = "SELECT  * FROM ". $table;
		$rs = $this->execute($sql);
		$objects = array();
		while(!$rs->EOF) {
			$arrayAssoc = $rs->fields;
			$obj = new $table;
			$this->setObj($arrayAssoc, $obj); 
			$objects[] = $obj;
			$rs->MoveNext();
		}
		return $objects;
	}
	
	/**
	 * Retorna o primeiro objecto resultante do find. Ou null
	 */
	public function findFirst($fields){
		$res = $this->find ($fields);

		foreach ($res as $r){
			echo '<br/>' . $r . '<br/>'; 			
		}
		
		if (count($res) > 0 ) return $res[0]; 
		return null;  
	}
	/* 
	 * Retorna um array de objectos que satisfazem um dado criterio. 
	 * @fields O array associativo com os atributos e valores pelo qual desejam filtrar a pesquisa. Os campos apenas podem ser strings ou numericos. sen‹o d‡ asneira. 
	 */
	public  function find ($fields){
			$table = get_class($this); 
			$sql = 'select * from ' . $table; 
			$sql .= $this->createWhereClause($fields);
			
			$sql .= ';'; 

			echo $sql; 
			$dao = new DAO(); 
			$dao->connect(); 
			$rs = $dao->execute($sql);

			if (!$rs){
				
				die ($dao->db->ErrorMsg());
				//return null; 
			}
			 
			$values = array();
			
			while (!$rs->EOF){
				$ob = new $table;
				$this->setObj($rs->fields, $ob);
				$values[] = $ob; 
				$rs->MoveNext(); 
			}
			return $values;  
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
	
	/**
	 * Cria uma clausula where bem formada a partir de um ArrayAssociativo com ANDS 
	 * S— suporta strings e numericos. Datas e outros que tais t‡ no mato. 
	 * @returns a String a dizer where key0 = $arrayAssoc[key0] AND $key1 = 'arrayAssoc[key1]' ou entao a string vazia caso o array esteja vazio.
	 */
	private function createWhereClause($arrayAssoc){
		$sql = '';
		$sql .= (count(fields) > 0 ) ? ' where ' : ''; //check to see if they are where clausules 

		$i = 0;  
		foreach ($arrayAssoc as $key=>$value){
			$sql .= ' '  . $key . '='; 
			$sql .= (gettype($value) == "string") ?  '\'' . $value  . '\' ': $value; 
			$i +=1;
			//se for ultimo adicionar and para proxima clausula 
			if ($i < count($arrayAssoc)){
				$sql .=  'AND '; 
			}  
		}
		return $sql; 
	}
	
	// Simple function alters objs attributes.
	private function setObj($arrayAssoc, $obj){

	 foreach($arrayAssoc as $key => $value) {
			$obj->$key = $value;
		}
	}
	
}

