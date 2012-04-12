<?php
/*
 * Created on Mar 19, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once ("Model.php"); 

class Noticia_Has_Integrante extends Model{
	var $idnoticia; 
	
		public function checkValidity(){
		return true; 
	}
	
	public function getKeyFields(){
		return array ('idnoticia', 'idintegrante' ); 
	}
	 
	/**
	* Identificador do integrante
	* @var int
	*/
	var $idintegrante; 
	
	/**
	* Qualificação da notícia. Representa se um notícia descreve aspectos positivos (1), neutros (0) e negativos (-1)
	* @var int
	*/
	var $qualificacao = 0;
	
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
	public function __construct($idnoticia=0, $idintegrante=0, $qualificacao=0,  $idlexico = 0){
		parent::__construct();
		$this->idnoticia = $idnoticia;
		$this->idintegrante= $idintegrante;
		$this->qualificacao = $qualificacao;
		$this->idlexico = $idlexico;
	}
	
	/**
	* Retorna o identificador da notícia
	* @return int {@link $idnoticia}
	*/
	public function getIdNoticia() {
		return $this->idnoticia;
	}
	
	/**
	 * Altera o valor do identificador da notícia {@link $idnoticia}
	 * @param int $id
	 */
	public function setIdNoticia($p) {
		$this->idnoticia = $p;
	}
	
	/**
	* Retorna o identificador do integrante
	* @return int {@link $idintegrante}
	*/
	public function getIdIntegrante(){
		return $this->idintegrante;
	}
	
	/**
	 * Altera o valor do identificador do integrante {@link $idintegrante}
	 * @param int $id
	 */
	public function setIdIntegrante($id) {
		$this->idintegrante = $id;
	}
	
	/**
	* Retorna a qualificação da notícia
	* @return int {@link $qualificacao}
	*/
	public function getQualificacao() {
		return $this->qualificacao;
	}
	
	/**
	 * Altera o valor da qualificacao da notícia {@link $qualificacao}
	 * @param int $q
	 */
	public function setQualificacao($q) {
		$this->qualificao = $q;
	}
	
/**
	 * Calcula a qualificação da notícia de forma acumulativa
	 * @param int $qual
	 * @uses {@link $qualificacao}
	 */
	public function addQualificacao($qual){
		$this->qualificacao += $qual; 
	}
        
   
   	/**
	 * Consulta Base de Dados para inserir ou alterar uma relação entre uma noticia e um integrante
	 */
	 public function update() {
        $sql_where_key = " where idnoticia = " . $this->idnoticia . " AND idintegrante = " . $this->idintegrante;
        $query = "select * from noticia_has_integrante" . $sql_where_key;

        $ado = new DAO();
        $ado->connect();
    	
    	$rs = $ado->execute($query);
    	
    	if (!$rs) {
            die($dao->db->ErrorMsg());
        }
        // Relacionamento já existe na base de dados. Alterar registo
        if ($rs->RecordCount() > 0) {
            $query = "update noticia_has_integrante SET qualificacao = " . $this->qualificacao . $sql_where_key;
        }
        // Relacionamento não existe na base de dados. Inserir registo
        else {
            $query = "insert into noticia_has_integrante values (" . $this->idnoticia . "," . $this->idintegrante . ", " . $this->qualificacao . "," . $this->idlexico .")";

        }
        $rs = $ado->execute($query);
    }
    
    /**
    * Retorna o objeto em forma de String. Usado para depuração.
    * @return String $res
    */
    public function __toString(){
		$res = "Noticia Has Integrante : "; 
		if ($this->idnoticia)  $res .= "ID Noticia :" . $this->idnoticia . " |"; 
		if ($this->idintegrante)  $res .= "ID Integrante:" . $this->idintegrante  . " |";
		if ($this->qualificacao)  $res .= "Qualificacao:" . $this->qualificacao . " |" ;
		if ($this->idlexico) $rs .= 'ID LEXICO : ' . $this->idlexico;
		
		return $res; 
	}
}
?>
