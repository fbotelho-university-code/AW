<?php
/*
 * Created on Mar 21, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 require_once("Model.php");
  
 class Noticia_data extends DAO{
 
 var $idnoticia; 
 var $tempo; 
 
 public function setIdNoticia($v) {$this->idnoticia = $v; }
 public function setTempo($v) {$this->tempo = $v;}
 public function getIdNoticia() {return $this->idnoticia; }
 public function getTempo() { return $this->tempo; }
  
  public function __construct($idnoticia, $tempo){
  	parent::__construct();
  	$this->idnoticia = $idnoticia; 
  	$this->tempo = $tempo; 
  }
 }
?>
