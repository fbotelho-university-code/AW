<?php
@header('Content-Type: text/html; charset=utf-8');
require_once("Model.php"); 
/*
 * Created on Mar 15, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Noticia_Has_Clube extends Model{
 	
 	/**
 	* Identificador do clube
 	* @var int
 	*/
 	var $idclube; 
	
	public function checkValidity(){
		return true; 
	}
	
	public function getRel(){
		return "idclube"; 
	}
	public function getKeyFields(){
		return array ('idnoticia', 'idclube' ); 
	}
	 
	 
 	/**
 	 * Identificador da noticia
 	 * @var int
 	 */
 	var $idnoticia; 
	
 	/**
 	 * Qualifica��o da not�cia. Representa se um not�cia descreve aspectos positivos (1), neutros (0) e negativos (-1)
 	 * @var int
 	 */
 	var $qualificacao =0;
	
 	/**
 	 * Identificador do lexico
 	 * @var int
 	 */
 	var $idlexico; 
	
	
 	/**
 	 * Construtor da classe
 	 * @param int $idNoticia
 	 * @param int $idClube
 	 * @param int $qualificacao
 	 * @param int $idlexico
 	 */
 	public function __construct($idNoticia=0, $idClube=0,$qualificacao = 0, $idlexico = 0){
 		parent::__construct();
 		$this->idclube = $idClube;
 		$this->idnoticia = $idNoticia;
 		$this->qualificacao = $qualificacao;
 		$this->idlexico = $idlexico;
 	}
 	
 	/**
 	* Retorna o identificador do clube
 	* @return int {@link $idclube}
 	*/
 	public function getIdClube(){
 		return $this->idclube;
 	}

 	/**
 	* Altera o valor do identificador do clube {@link $idclube}
 	* @param int $id
 	*/
 	public function setIdClube($p) {
 		$this->idclube = $p;
 	}
 	
 	/**
 	* Retorna o identificador da not�cia
 	* @return int {@link $idnoticia}
 	*/
 	public function getIdNoticia() {
 		return $this->idnoticia;
 	}
 	
 	/**
 	* Altera o valor do identificador da not�cia {@link $idnoticia}
 	* @param int $id
 	*/
 	public function setIdNoticia($p) {
 		$this->idnoticia = $p;
 	}
 	
 	/**
 	* Retorna a qualifica��o da not�cia
 	* @return int {@link $qualificacao}
 	*/
 	public function getQualificacao() {
 		return $this->qualificacao;
 	}
 	
 	/**
 	* Altera o valor da qualificacao da not�cia {@link $qualificacao}
 	* @param int $q
 	*/
 	public function setQualificacao($q) {
 		$this->qualificao = $q;
 	}
 	
 	 	
 	/**
 	* Retorna o identificador do lexico
 	* @return int {@link $idlexico}
 	*/
 	public function getIdLexico() {
 		return $this->idlexico;
 	}
	
 	/**
 	* Altera o valor do identificador do lexico {@link $idlexico}
 	* @param int $id
 	*/
 	public function setIdLexico() {
 		return $this->idlexico;
 	}
			
	/**
	 * Consulta Base de Dados para inserir ou alterar uma rela��o entre uma noticia e um clube
	 */
	/*public function update(){
			$sql_where_key =" where idclube = " . $this->idclube . " AND idnoticia = " . $this->idnoticia;
			$query = "select * from noticia_has_clube" . $sql_where_key;   
			
			$ado = new DAO(); 
			$ado->connect();
			$rs = $ado->execute($query); 
			
			if (!$rs){
				die($dao->db->ErrorMsg());
			}
			// Relacionamento j� existe na base de dados. Alterar registo
			if ($rs->RecordCount() > 0 ){
				$query = "update noticia_has_clube SET qualificacao = " . $this->qualificacao . $sql_where_key; 
			}
			// Relacionamento n�o existe na base de dados. Inserir registo
			else {
				$query = "insert into noticia_has_clube values (" . $this->idnoticia . "," . $this->idclube . ", " . $this->qualificacao . "," . $this->idlexico .")";
			}

			$rs = $ado->execute($query); 
		}
		
		*/
		
	
	/**
	 * Calcula a qualifica��o da not�cia de forma acumulativa
	 * @param int $qual
	 * @uses {@link $qualificacao}
	 */
	public function addQualificacao($qual){
		$this->qualificacao += $qual; 
	}
	
	/**
	* Retorna o objeto em forma de String. Usado para depura��o.
	* @return String $res
	*/
	public function __toString(){
		$res = 'NoticiaCLubes : '; 
		if ($this->idclube) $res .= ' ID CLUBE : ' . $this->idclube . ' |';
		if ($this->idnoticia) $res .= ' ID NOTICIA : ' . $this->idnoticia . ' |';
		if ($this->qualificacao) $res .= ' QUALIFICACAO: ' . $this->idnoticia . ' | ' ;
		if ($this->idlexico) $rs .= 'ID LEXICO : ' . $this->idlexico;
		return $res; 
	}
	
	
	public static function getAllNoticias($idIntegrante){
			$class_this = new Noticia_Has_Clube();
			$rel = $class_this->find(array("idclube" => $idIntegrante));
			if (!$rel) return null; 
			$noticias = array();
			$clube_class = new Noticia();
			foreach($rel as $rl){
				$n =$clube_class->getObjectById($rl->getIdNoticia()); 
				$n->visivel = null; 
				$clubes[] = $n; 
			}
			return $clubes; 
	}
	
	public static function getAllClubes($idnoticia, $baseurl){
		$class_this = new Noticia_Has_Clube(); 
		$rel = $class_this->find(array("idnoticia" => $idnoticia)); 
		if (!$rel) return null; 
		
		$clubes = array();
		$clube_class = new Clube(); 
		
		foreach($rel as $rl){
			$c = $clube_class->getObjectById($rl->getIdClube());
			//$c->idlexico = $rl->idlexico; 
			$c->qualificacao = $rl->qualificacao; 
			$c->follow = $baseurl . 'entidades.php/clube/' . $c->idclube; 
			$clubes[] = $c; 
		}
		return $clubes; 
	}
 }	
 ?>
