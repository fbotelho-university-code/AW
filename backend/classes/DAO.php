<?php

include ("./adodb/adodb.inc.php");

/**
 * Classe que representa uma abstracao para acesso a base de dados.
 * Usada com superclasse de todas as classes do Modelo
 */
class DAO extends ADOConnection {
	
	/**
	 * SGBD utilizado pela aplicacao
	 * @var String
	 */
	private $mysgbd = "mysql";
	
	/**
	 * Nome ou IP do servidor na qual encontra-se instalada a Base de Dados
	 * @var String
	 */
	private $myserver = "localhost";
	
	/**
	 * Nome do usuario para acesso à Base de Dados
	 * @var String
	 */
	private $myuser = "root";
	
	/**
	 * 
	 * Palavra-passe para acesso à Base de Dados
	 * @var String
	 */
	private $mypassword = "pcdamf06";
	
	/**
	 * Nome da Base de Dados a ser utilizada
	 * @var String
	 */
	private $mydbName = "aw";
	
	/**
	 * Objeto para acesso à Base de Dados
	 * @var ADONewConnection
	 */
	public $db;
	
	/**
	 * Construtor da Classe
	 * Configura o SGBD a ser utilizado
	 * @uses {@link $mysgbd}
	 */
	function __construct() {
		
		$this->db = &ADONewConnection($this->mysgbd);
		
		/* Ativa Associação dos nomes das colunas das tabelas da BD com as chaves dos arrays de retorno de consulta */
		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
	}
	
	/**
	 * Conecta com a base de dados
	 * Usa os atributos da classe para estabelecar uma ligação com o SGBD
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
		$rs = $this->db->Execute($sql) or die($this->db->ErrorMsg() . "<br>SQL: ".$sql);
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
		$rs = $this->db->AutoExecute($table, $fields, "INSERT") or die($this->db->ErrorMsg() . "<br>SQL: ".var_dump($fields). " - Table: ".$table);
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
	 * Retorna o primeiro objecto resultante da pesquisa à Base de Dados.
	 * @param String[] $fields - O array associativo com os atributos e valores pelo qual desejam filtrar a pesquisa. 
	 *                           Os campos apenas podem ser strings ou numericos.
	 * @return Object $res[0] - Objecto da classe chamadora refletindo resultado da pesquisa à Base de Dados 
	 */
	public function findFirst($fields){
		$table = get_class($this);
		$res = $this->find ($fields);
		if (count($res) > 0) return $res[0]; 
		return null;  
	}
	
	/**
	 * Retorna um array de objectos que satisfazem um dado criterio. 
	 * @param String[] $fields - O array associativo com os atributos e valores pelo qual desejam filtrar a pesquisa. 
	 *                           Os campos apenas podem ser strings ou numericos.
	 * @return Object[] $values - Array com objectos da classe chamadora refletindo resultado da pesquisa à Base de Dados
	 */
	public  function find ($fields){
		
		//Subclasses de Fonte devem usar tabela da classe pai (fonte)	
		if(is_subclass_of($this, "fonte")) {
			$table = "fonte";
		}
		else {
			$table = get_class($this);
		}
		
		$sql = 'select * from ' . $table;
		$sql .= $this->createWhereClause($fields) . ';';
		
		//echo $sql; 
		$rs = $this->execute($sql);
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
	 * S— suporta strings e numericos. 
	 * @returns a String a dizer where key0 = $arrayAssoc[key0] AND $key1 = 'arrayAssoc[key1]' ou entao a string vazia caso o array esteja vazio.
	 */
	 //TODO is_string not working. 
	private function createWhereClause($arrayAssoc){
		
		$sql = '';
		$sql .= (count($arrayAssoc) > 0 ) ? ' where ' : ''; //check to see if they are where clausules 

		$i = 0;  
		foreach ($arrayAssoc as $key=>$value){
			$sql .= ' '  . $key . '='; 
			$sql .= '\'' . $value  . '\''; 
			//$sql .= (is_string($value)) ?  '\'' . $value  . '\' ': $value;
			$i +=1;
			//se for ultimo adicionar and para proxima clausula 
			if ($i < count($arrayAssoc)){
				$sql .=  'AND '; 
			}  
		}
		return $sql; 
	}
	
	/**
	 * Transforma Array associaticvo em Objeto, de acordo com a subclasse chamadora
	 * @param String[] $arrayAssoc
	 * @param Object $obj - Objecto da subclasse chamadora
	 */
	private function setObj($arrayAssoc, $obj){

	 foreach($arrayAssoc as $key => $value) {
			$obj->$key = $value;
		}
	}
	
}