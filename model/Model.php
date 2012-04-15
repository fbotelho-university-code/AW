<?php
/*
 * Created on Mar 29, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require_once ('DAO.php'); 


abstract class Model{
	
	private $dao; 
	
	/**
	 * Should check the validity of the data it is composed.
	 *  
	 */
	public abstract function checkValidity();
	
	/**
	 * Remote DAO from get_object vars
	 * Also allows the filtering of the vars in the returning associative array. 
	 * Useful when used with the primary key. 
	 */
	function my_get_object_vars($filter =null){
	
	$array = get_object_vars($this);
	if (isset($array['dao'])){
		unset($array['dao']);
	}
	
	if ($filter != null){
		foreach($array as $k => $field){
			if (array_search($k, $filter) === false ){
				unset($array[$k]);
			}
		}
	}		
	return $array;  	 
	}
	
	
	/**
	 * Methods should override this and return an array of the primary key identifiers. 
	 */
	public abstract function getKeyFields();  
	public function __construct(){
		$this->dao = new DAO(); 
	}
	 
	/**
	 * Executa uma SQL
	 * @param String $sql
	 * @return ResultSet $rs Resultado da SQL executada
	 */

	
	/**
	 * Insere um objeto na base de dados
	 * @return int $id Identificador do registo inserido
	 */
	public function add(){
		$this->dao->connect();
		$table = get_class($this);
		$fields = $this->my_get_object_vars();
		$rs = $this->dao->db->AutoExecute($table, $fields, "INSERT") or die($this->dao->db->ErrorMsg() . "<br>SQL: ".var_dump($fields). " - Table: ".$table);
		$id = $this->dao->db->Insert_ID();
		$this->dao->disconnect();
		return $id;
	}
		
	public function del(){
		$table = get_class($this); 
		$sql = 'delete from ' . $table   . $this->getPrimaryKeyWhere(); 
		$this->dao->execute($sql);
	}
	
	public function delete($fields) {
		$table = get_class($this);
		$sql = 'delete from ' . $table;
		$sql .= $this->createWhereClause($fields) . ';';
		$this->dao->execute($sql);
	}
	public function execute($m){ $this->dao->execute($m); }

/**
 * Return the Where statement selecting this object in the database.
 */
	public function getPrimaryKeyWhere(){
		return $this->createWhereClause($this->my_get_object_vars($this->getKeyFields())); 
	}		
	
	public function update(){
		$table = get_class($this); 
		$fields = $this->my_get_object_vars();
		foreach ($this->getKeyFields() as $key){
			if (isset($fields[$key]))
				unset($fields[$key]); 
		}
		
		$sql = 'update '. $table . $this->createWhereClause($fields, 'SET', ' , ');
		
		//Filter the primary key.
		$sql .= $this->getPrimaryKeyWhere();
		
		//echo $sql; 
		$this->dao->execute($sql);
	}
	
	/**
	 * Cria-te um objecto a partir de uma string xml.
	 */
	public  function fromXml($xmlString){
		$ob =  simplexml_load_string($xmlString);
		$class = get_class($this);
	    $return_obj  = new $class; 
	    $this->setObj(get_object_vars($ob), $return_obj);
	    return $return_obj;  	
	}
	
	/**
	 * Valida um XML em formato String usando um ficheiro XML Schema (XSD)
	 * @param String $xmlString
	 */
	public function validateXMLbyXSD($xmlString) {
		
		// Transformação da String em DOM
		$xmlDOM = new DOMDocument();
		$xmlDOM->loadXML($xmlString);
		
		//Manipulação do nome da classe chamadora
		$class = get_class($this);
		if($class == "local") {
			$class = "espaco";
		}
		
		//Alteração do cabeçalho XML para inclusão das referências para o XSD
		$rootElement = $xmlDOM->getElementsByTagName("clube");
		
		$xmlnsAttribute = $xmlDOM->createAttribute("xmlns");
		$xmlnsAttribute->value = "http://localhost/AW-3/workspace/Schemas/".$class.".xsd";
		
		$xmlnsXsiAttribute = $xmlDOM->createAttribute("xmlns:xsi");
		$xmlnsXsiAttribute->value = "http://www.w3.org/2001/XMLSchema-instance";
		
		$schemaLocationAttribute = $xmlDOM->createAttribute("xsi:schemaLocation");
		$schemaLocationAttribute->value = "http://localhost/AW-3/workspace/Schemas/".$class.".xsd ".$class."xsd ";
		
		$rootElement->appendChild($xmlnsAttribute);
		$rootElement->appendChild($xmlnsXsiAttribute);
		$rootElement->appendChild($schemaLocationAttribute);
		$xmlDOM->appendChild($rootElement);
		
		//Validação do XML usando o ficheiro XSD
		$pathToXSD = "../webservice/Schemas/";
		$pathToXSD .= $class.".xsd";
		if($xmlDOM->schemaValidate($pathToXSD)) {
			echo "validated<br>";
		}
		else {
			echo "Error!!<br>";
		}
	}
	
	
	/**
	 * Apaga todos os registos de uma tabela na base de dados
	 * @return boolean
	 */
	public function clear() {
		$table = get_class($this);
		$sql = "TRUNCATE TABLE ". $table;
		$rs = $this->dao->execute($sql);
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
	public  function getAll($fields =null, $start = null, $end = null){
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
		$sql .= ' FROM ' . $table;
		
		if(!(is_null($start) && is_null($end))) {
				$sql .= " LIMIT ".$start." , ". $end;
			}
		
		$rs = $this->dao->execute($sql) or die ($this->dao->db->ErrorMsg());
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
	 * Retorna o primeiro objecto resultante da pesquisa ï¿½ Base de Dados.
	 * @param String[] $fields - O array associativo com os atributos e valores pelo qual desejam filtrar a pesquisa. 
	 *                           Os campos apenas podem ser strings ou numericos.
	 * @return Object $res[0] - Objecto da classe chamadora refletindo resultado da pesquisa ï¿½ Base de Dados 
	 */
	public function findFirst($fields, $connector =' = '){
		$table = get_class($this);
		$res = $this->find ($fields, $connector);
		if (count($res) > 0) return $res[0]; 
		return null;  
	}
		
	/**
	 * Retorna um array de objectos que satisfazem um dado criterio. 
	 * @param String[] $fields - O array associativo com os atributos e valores pelo qual desejam filtrar a pesquisa. 
	 *                           Os campos apenas podem ser strings ou numericos.
	 * @return Object[] $values - Array com objectos da classe chamadora refletindo resultado da pesquisa ï¿½ Base de Dados
	 */
	 
	public  function find ($fields, $connector = ' = '){
		//Subclasses de Fonte devem usar tabela da classe pai (fonte)	
		if(is_subclass_of($this, "fonte")) {
			$table = "fonte";
		}
		else {
			$table = get_class($this);
		}
		
		$sql = 'select * from ' . $table;
		
		//This $connector is used for LIKE statements
		$sql .= $this->createWhereClause($fields, 'where', ' AND ', $connector) . ';';

		$rs = $this->dao->execute($sql);
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
		$rs = $this->dao->execute($sql);
		if (!$rs->fields) return null;
		$result = new $table; 
		$this->setObj($rs->fields, $result);  
		foreach($rs->fields as $key => $value) {
			$this->$key = $value;
		}
		return $result; 	
	}
	
	/**
	 * Cria uma clausula where bem formada a partir de um ArrayAssociativo com ANDS 
	 * Sï¿½ suporta strings e numericos. 
	 * @returns a String a dizer where key0 = $arrayAssoc[key0] AND $key1 = 'arrayAssoc[key1]' ou entao a string vazia caso o array esteja vazio.
	 */


	 //TODO is_string not working.
	private function createWhereClause($arrayAssoc, $connector='where', $logicalConnector = ' AND ', $equalitySign = ' = '){
		$sql = '';
		$sql .= (count($arrayAssoc) > 0 ) ?  (' ' . $connector . ' ' )  : ''; //check to see if they are where clausules 
		$i = 0;
		  
		foreach ($arrayAssoc as $key=>$value){
			$sql .= ' '  . $key .  $equalitySign ; 
			//$sql .= '\'' . $value  . '\''; 
			$sql .= (!is_numeric($value)) ?  '\'' . $value  . '\' ': $value;
			$i += 1;
			//se for ultimo adicionar and para proxima clausula 
			if ($i < count($arrayAssoc)){
				$sql .=  $logicalConnector ; 
			}  
		}
		return $sql; 
	}
	
	public function getSelectFilter($start,$count) {
		if(!is_null($start)) {
			settype($start, "integer");
		}
		if(!is_null($count)) {
			settype($count, "integer");
		}
		if(!is_null($start) && is_null($count)) {
			$count = 10;
		}
		if(is_null($start) && !is_null($count)) {
			$start = 0;
		}
	public function deleteById($noticia){
			$sql = 'DELETE FROM  ' . get_class($this) . ' WHERE idnoticia =  ' . $noticia;
			echo $sql; 
			$this->execute($sql);   
			
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
