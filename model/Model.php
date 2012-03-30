<?php
/*
 * Created on Mar 29, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require_once ('DAO.php'); 

class Model{
	
	private $dao; 
	
	public function __construct(){
		$this->dao = new DAO(); 
	}
	 
	/**
	 * Executa uma SQL
	 * @param String $sql
	 * @return ResultSet $rs Resultado da SQL executada
	 */
	 
	function execute($sql) {
		$this->dao->connect();
		$rs = $this->dao->db->Execute($sql) or die($this->dao->db->ErrorMsg() . "<br>SQL: ".$sql);
		$this->dao->disconnect();
		return $rs;
	}
	
	/**
	 * Insere um objeto na base de dados
	 * @return int $id Identificador do registo inserido
	 */
	public function add(){
		$this->dao->connect();
		$table = get_class($this);
		$fields = get_object_vars($this);
		$rs = $this->dao->db->AutoExecute($table, $fields, "INSERT") or die($this->dao->db->ErrorMsg() . "<br>SQL: ".var_dump($fields). " - Table: ".$table);
		$id = $this->dao->db->Insert_ID();
		$this->dao->disconnect();
		return $id;
	}
	
	/**
	 * Apaga todos os registos de uma tabela na base de dados
	 * @return boolean
	 */
	public function clear() {
		$table = get_class($this);
		$sql = "TRUNCATE TABLE ". $table;
		$rs = $this->dao->db->execute($sql);
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
	public  function getAll($fields =null){
		$table = get_class($this);
		$sql = "SELECT "; 
				
		if (isset($fields)){
			$count = count($fields); 
			$i = 0; 
			foreach ($fields as $f){
				$sql .= $f;
				$i++;
				if ($i < $count){
					$sql .= ', ';  
				} 
			}
		}
		else{
			$sql .= ' * '; 
		}
		$sql .= ' FROM ' . $table . ';';
		
		$this->dao->connect(); 
		$rs = $this->dao->db->execute($sql) or die ($this->dao->db->ErrorMsg());
		$objects = array();
		
		
		while(!$rs->EOF) {
			$arrayAssoc = $rs->fields;
			$obj = new $table;
			$this->setObj($arrayAssoc, $obj); 
			$objects[] = $obj;
			$rs->MoveNext();
		}
		$this->dao->disconnect(); 
		return $objects;
	}
	
	/**
	 * Retorna o primeiro objecto resultante da pesquisa � Base de Dados.
	 * @param String[] $fields - O array associativo com os atributos e valores pelo qual desejam filtrar a pesquisa. 
	 *                           Os campos apenas podem ser strings ou numericos.
	 * @return Object $res[0] - Objecto da classe chamadora refletindo resultado da pesquisa � Base de Dados 
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
	 * @return Object[] $values - Array com objectos da classe chamadora refletindo resultado da pesquisa � Base de Dados
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
		
		$this->dao->connect(); 
		$rs = $this->dao->db->execute($sql);
		$values = array();
		while (!$rs->EOF){
			$ob = new $table;
			$this->setObj($rs->fields, $ob);
			$values[] = $ob; 
			$rs->MoveNext(); 
		}
		$this->dao->disconnect(); 
		return $values;  
	}
		
	/**
	 * Recupera um objecto da base de dados pelo seu id
	 * @param int $id Identificador do objecto na base de dados
	 */
	public function getObjectById($id) {
		$table = get_class($this);
		$sql = "SELECT * FROM ".$table. " WHERE id".$table." = ".$id;
		$this->dao->connect();
		$rs = $this->dao->db->execute($sql);
		foreach($rs->fields as $key => $value) {
			$this->$key = $value;
		}
		$this->dao->disconnect(); 
	}
	
	/**
	 * Cria uma clausula where bem formada a partir de um ArrayAssociativo com ANDS 
	 * S� suporta strings e numericos. 
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
?>