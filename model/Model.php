<?php
@header('Content-Type: text/html; charset=utf-8');
/*
 * Created on Mar 29, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once ('DAO.php'); 
require_once ('../webservice/Util/RestUtils.php'); 

abstract class Model{
	private  $dao;

	
	/**
	 * Should check the validity of the data it is composed.
	 *  
	 */
	public abstract function checkValidity();
	
	public function setCount(){
		$start = $count = null;
		if(isset($_GET["start"])) {
			$start = $_GET["start"];
			settype($start, "integer");
		}
		if(isset($_GET["count"])) {
		$count = $_GET["count"];
		settype($count, "integer");
	}
	if(!is_null($start) && is_null($count)) {
		$count = 10;
	}
	if(is_null($start) && !is_null($count)) {
		$start = 0;
	}
	$result['start'] = $start; 
	$result['count'] = $count; 
	return $result; 
	}
	
	public function setText(){
		
		$text = null; 
		if (isset($_GET['texto'])){
			$text = $_GET['texto']; 
			if (strcmp($text, 'true') == 0){
				$text = true; 
			}
			else if (strcmp($text, 'false') == 0){
				$text = false; 
			}
			else{
				RestUtils::sendResponse(400); 
			}
		}
		return $text; 
	}
		
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
	 
	private function throwException($string){
		throw new Exception($string); 
	}

	
	/**
	 * Insere um objeto na base de dados
	 * @return int $id Identificador do registo inserido
	 */
	public function add(){
		$this->dao->connect();
		$table = get_class($this);
		$fields = $this->my_get_object_vars();
		
		$rs = $this->dao->db->AutoExecute($table, $fields, "INSERT") or $this->throwException($this->dao->db->ErrorMsg() . "<br>CENAS SQL: ".var_export($fields,true). " - Table: ".$table);
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
	
	public function execute($m){ return $this->dao->execute($m); }

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
		$this->dao->execute($sql);
	}
	
	/**
	 * Cria-te um objecto a partir de uma string xml.
	 */
	public  function fromXml($xmlString){
		if ($xmlString == ''){
			return ; 
		}
		@$ob =  simplexml_load_string($xmlString);
		$class = get_class($this);
	    $return_obj  = new $class; 
	    $this->setObj(get_object_vars($ob), $return_obj);
	    return $return_obj;
	}
	
	/**
	 * Valida um XML em formato String usando um ficheiro XML Schema (XSD)
	 * @param String $xmlString
	 */
	public function validateXMLbyXSD($xmlString, $xsdName){
		// Transforma��o da String em DOM
		$xmlDOM = new DOMDocument();
		@$xmlDOM->loadXML($xmlString);
		
		//Valida��o do XML usando o ficheiro XSD
		$pathToXSD = "../webservice/Schemas/".$xsdName;
		@$validate = $xmlDOM->schemaValidate($pathToXSD);
		
		if($validate) {
			return true;
		}
		else {
			return false;
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
	
	
	public function select($fields){
		$sql = ""; 
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
		return $sql;
	}
	/**
	 * Retorna todos os registos da base de dados de uma tabela
	 * @return Object[] $objects Array de Objectos com atributos da base de dados
	 */
	public  function getAll($fields =null){
		$var = $this->setCount(); 
		$start = $var['start'];
		$end = $var['count'];
		
		$table = get_class($this);
		$sql = "SELECT  "; 
				
		$sql .= $this->select($fields); 
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
	 * Retorna o primeiro objecto resultante da pesquisa � Base de Dados.
	 * @param String[] $fields - O array associativo com os atributos e valores pelo qual desejam filtrar a pesquisa. 
	 *                           Os campos apenas podem ser strings ou numericos.
	 * @return Object $res[0] - Objecto da classe chamadora refletindo resultado da pesquisa � Base de Dados 
	 */
	public function findFirst($fields, $connector =' = ', $selectedFields=null){
		$table = get_class($this);
		$res = $this->find ($fields, $connector, $selectedFields);
		if (count($res) > 0) return $res[0]; 
		return null;  
	}
		
	/**
	 * Retorna um array de objectos que satisfazem um dado criterio. 
	 * @param String[] $fields - O array associativo com os atributos e valores pelo qual desejam filtrar a pesquisa. 
	 *                           Os campos apenas podem ser strings ou numericos.
	 * @return Object[] $values - Array com objectos da classe chamadora refletindo resultado da pesquisa � Base de Dados
	 */
	public  function find ($fields, $connector = ' = ', $selectedFields = null){
		$var = $this->setCount(); 
		$start = $var['start'];
		$end = $var['count'];
		
		//Subclasses de Fonte devem usar tabela da classe pai (fonte)	
		if(is_subclass_of($this, "fonte")) {
			$table = "fonte";
		}
		else {
			$table = get_class($this);
		}
		
		$sql = 'select  '; 
		$sql .= $this->select($selectedFields);
		$sql .= ' from ' . $table;
		
		//This $connector is used for LIKE statements
		$sql .= $this->createWhereClause($fields, 'where', ' AND ', $connector) ;
		
		if(!(is_null($start) && is_null($end))) {
				$sql .= " LIMIT ".$start." , ". $end;
		}
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
	public function getObjectById($id, $fields=null) {
		$table = get_class($this);
		$sql = 'select '; 
		$sql .= $this->select($fields);
		$sql .= " FROM ".$table. " WHERE id".$table." = ".$id;
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
	 * S� suporta strings e numericos. 
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
	}
	public function deleteById($noticia){
			$sql = 'DELETE FROM  ' . get_class($this) . ' WHERE idnoticia =  ' . $noticia;
			$this->execute($sql);   
	}
	
	
	/**
	 * Transforma Array associaticvo em Objeto, de acordo com a subclasse chamadora
	 * @param String[] $arrayAssoc
	 * @param Object $obj - Objecto da subclasse chamadora
	 */
	public function setObj($arrayAssoc, $obj){
	 foreach($arrayAssoc as $key => $value) {
			$obj->$key = $value;
		}
	}
	
	
	public function getAllNews($idnoticia, $url){
		$sql = "select idnoticia from " . get_class($this) . " where " . $this->getRel() .  " = "  . $idnoticia ;

		$rs = $this->execute($sql);
		if  (!$rs->fields) return ;
		$result = array(); 

		foreach  ($rs->fields as $key => $value){
			$result[] = Noticia::getRelationArray($value, $url);
		}
		return $result; 
	}
	
	

	/*	//Altera��o do cabe�alho XML para inclus�o das refer�ncias para o XSD
	 public function createXMLNS($xmlString) {
	$xmlDOM = new DOMDocument();
	@$xmlDOM->loadXML($xmlString);
	$xmlDOM->formatOutput = true;
	
	//Recupera Elemento raiz do XML
	$rootElement = $xmlDOM->documentElement;
	//$rootElement->get
	
	
	$ns = $xmlDOM->createElementNS("localhost", "noticias");
	//$xmlDOM->appendChild($ns);
	
	//xmlns='localhost'
	//$atributo = $xmlDOM->createAttribute("xmlns");
	//$atributo->value = "localhost";
	//$rootElement->appendChild($atributo);
	
	//$atributo = $xmlDOM->createAttributeNS("localhost", "xmlns");
	$rootElement->setAttributeNS("localhost", "xmlns", "localhost");
	
	//xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
	$atributo = $xmlDOM->createAttribute("xmlns:xsi");
	$atributo->value = "http://www.w3.org/2001/XMLSchema-instance";
	//$rootElement->appendChild($atributo);
	$rootElement->setAttributeNS("localhost", "xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
	
	//xsi:schemaLocation='localhost Noticias.xsd '
	$atributo = $xmlDOM->createAttribute("xmlns:schemaLocation");
	$atributo->value = "localhost Noticias.xsd";
	//$rootElement->appendChild($atributo);
	$rootElement->setAttributeNS("localhost", "xsi:schemaLocation", "localhost Noticias.xsd ");
	
	//echo $rootElement->namespaceURI;
	//echo $xmlDOM->saveXML();
	
	return $xmlDOM->saveXML();
	}
	*/
}
?>
