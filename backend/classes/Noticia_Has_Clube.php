<?php
require_once("DAO.php"); 
/*
 * Created on Mar 15, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Noticia_Has_Clube extends DAO{
 	var $idclube; 
	var $idnoticia; 
	var $qualificacao =0; 
	
	public function getIdClube(){return $this->idclube;}  
	public function getIdNoticia() {return $this->idnoticia; }
	public function getQualificacao() {return $this->qualificacao; }
	
	public function setIdClube($p) {$this->idclube = $p; }
	public function setIdNoticia($p) {$this->idnoticia = $p; }
	public function setQualificacao($p) {$this->qualificao = $p; }
			
	public function __construct($idNoticia=0, $idClube=0,$qualificacao = 0){
		parent::__construct(); 
		//var_dump(debug_backtrace()); 
		$this->idclube = $idClube; 
		$this->idnoticia = $idNoticia; 		
		$this->qualificacao = $qualificacao; 
	}
	
	
	//TODO - clean up and generalize update function
	public function update(){
			$sql_where_key =" where idclube = " . $this->idclube . " AND idnoticia = " . $this->idnoticia;
			$query = "select * from noticia_has_clube" . $sql_where_key;   
			
			$ado = new DAO(); 
			$ado->connect();
			//echo '<br/> SQL <br/> ' . $query . '<br/>';  
			$rs = $ado->execute($query); 
			
			if (!$rs){
				die($dao->db->ErrorMsg());
			}
			if ($rs->RecordCount() > 0 ){
				$query = "update noticia_has_clube SET qualificacao = " . $this->qualificacao . $sql_where_key; 
			}
			else {
				$query = "insert into noticia_has_clube values (" . $this->idnoticia . "," . $this->idclube . ", " . $this->qualificacao . ")";
			}
			
			$rs = $ado->execute($query);
			
			//TODO check if failed. 
		}
		
	public function addQualificacao($qual){
		$this->qualificacao += $qual; 
	}
	
	public function __toString(){
		$res = 'NoticiaCLubes : '; 
		if ($this->idclube) $res .= ' ID CLUBE : ' . $this->idclube . ' |';
		if ($this->idnoticia) $res .= ' ID NOTICIA : ' . $this->idnoticia . ' |';
		if ($this->qualificacao) $res .= ' QUALIFICACAO: ' . $this->idnoticia ;
		return $res; 
	}
	
 }	
 ?>
