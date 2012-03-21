<?php
/*
 * Created on Mar 19, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once ("DAO.php"); 

class Noticia_Has_Integrante extends DAO{
	var $idnoticia; 
	var $idintegrante; 
	var $qualificacao; 
        
	public function getIdNoticia(){ return $this->idnoticia; }
	public function getIdIntegrante(){ return $this->idintegranteb; }
	public function getQualificacao() { return $this->qualificacao; }
	public function setIdNoticia($p) {$this->idnoticia = $p; }
	public function setIdIntegrante($p) {$this->idintegrante = $p; }
	public function setQualificacao($p) { $this->qualificacao = $p; }
    public function addQualificacao($p) { $this->qualificacao += $p; }
        
   public function __construct($idnoticia=0, $idintegrante=0, $qualificacao=0){
    	parent::__construct(); 
    	$this->idnoticia = $idnoticia; 
    	$this->idintegrante= $idintegrante;
    	$this->qualificacao = $qualificacao; 
    }
    
    
	//TODO - clean up and generalize update function
	public function update() {
        $sql_where_key = " where idnoticia = " . $this->idnoticia . " AND idintegrante = " . $this->idintegrante;
        $query = "select * from noticia_has_integrante" . $sql_where_key;

        $ado = new DAO();
        $ado->connect();
    	
    	$rs = $ado->execute($query);
    	
        if (!$rs) {
            die($dao->db->ErrorMsg());
        }
        if ($rs->RecordCount() > 0) {
            $query = "update noticia_has_integrante SET qualificacao = " . $this->qualificacao . $sql_where_key;
        } else {
            $query = "insert into noticia_has_integrante values (" . $this->idnoticia . "," . $this->idintegrante . ", " . $this->qualificacao . ")";

        }
        
        $rs = $ado->execute($query);
        //TODO check if failed. 
    }
    
        public function __toString(){
		$res = "Noticia Has Integrante : "; 
		if ($this->idnoticia)  $res .= "ID Noticia :" . $this->idnoticia . " |"; 
		if ($this->idintegrante)  $res .= "ID Integrante:" . $this->idintegrante  . " |";
		if ($this->qualificacao)  $res .= "Qualificacao:" . $this->qualificacao ;
		
		return $res; 
	}
}
?>
