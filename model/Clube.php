<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "Model.php";

/**
 * Classe que representa um clube de futebol
 *  (Ex: Benfica, Porto, Sporting, etc.)
 */
class Clube extends Model {

	/**
	* Identificador do clube
	* @var int
	*/
	var $idclube;
	
	public function checkValidity(){
		return true; 
	}
	
	public function getKeyFields(){
		return array ('idclube'); 
	}
	
	/**
	* Nome oficial do clube. Usado para relacionamento com o lexico
	* @var String
	*/
	var $nome_oficial;
	
	/**
	 * Construtor da classe. Inicializa o nome do clube, se houver {@link $nome_clube}
	 * @param String $n
	 */	
	public function __construct($n ='') {
		parent::__construct();
		if ($n != '' ){
			$this->nome_clube = $n;
		}
	}
	
	/**
	* Retorna o identificador do clube
	* @return int {@link $idclube}
	*/
	public function getIdclube() {
		return $this->idclube;
	}
	
	/**
	* Altera o valor do identificador do clube {@link $idclube}
	* @param int $id
	*/
	public function setIdclube($id) {
		$this->idclube = $id;
	}
	
	/**
	* Retorna o identificador do local do clube
	* @return int {@link $idlocal}
	*/
	public function getIdlocal() {
		return $this->idlocal;
	}
	
	/**
	* Altera o valor do identificador do local do clube {@link $idlocal}
	* @param int $id
	*/
	public function setIdlocal($id) {
		$this->idlocal = $id;
	}
	
	/**
	* Retorna o identificador da competicao do clube
	* @return int {@link $idcompeticao}
	*/
	public function getIdcompeticao() {
		return $this->idcompeticao;
	}
	
	/**
	* Altera o valor do identificador da competicao do clube {@link $idcompeticao}
	* @param int $id
	*/
	public function setIdcompeticao($id) {
		$this->idcompeticao = $id;
	}
	
	/**
	* Retorna o nome do clube
	* @return String {@link $nome_competicao}
	*/
	public function getNome_clube() {
		return $this->nome_clube;
	}
	
	/**
	* Altera o valor do nome do clube {@link $nome_competicao}
	* @param String $n
	*/
	public function setNome_clube($n) {
		$this->nome_clube = $n;
	}
	
	/**
	* Retorna o nome oficial do clube
	* @return String {@link $nome_oficial}
	*/
	public function getNome_oficial() {
		return $this->nome_oficial;
	}
	
	/**
	 * Altera o valor do nome oficial do clube {@link $nome_oficial}
	 * @param String $n
	 */
	public function setNome_oficial($n) {
		$this->nome_oficial = $n;
	}
	
	
	public function __toString(){
		$res = 'Clube'; 
		if ($this->idclube) $res .= ' ID CLUBE : ' . $this->idclube . ' |';
		if ($this->idlocal) $res .= ' ID LOCAL : ' . $this->idlocal . ' |';
		if ($this->idcompeticao) $res .= ' ID COMPETICAO: ' . $this->idcompeticao . ' | ' ;
		if ($this->nome_clube) $rs .= 'ID  : ' . $this->nome_clube . ' | ';
		if ($this->nome_oficial) $rs .= 'NOME OFICIAL  : ' . $this->nome_oficial . ' | ';
		return $res; 
	}
	
	public function getUrl2(){
		$v = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		$r = $v['scheme'] . '://' . $v['host'] . $v['path'];
		$pos = strpos($r, 'webservice/') ;
		$val = substr($r, 0, $pos );
		return $val;
	}
	
	public function setObj($arrayAssoc, $obj){
		foreach($arrayAssoc as $key => $value){
				$obj->$key = $value;
			}
		if (isset($obj->url_img)){
			$obj->url_img =  $this->getUrl2() . 'webservice/entidades.php/clube/' . $obj->idclube  . '/thumbnail';
		}
		else $obj->url_img = ""; 
	}
}

?>