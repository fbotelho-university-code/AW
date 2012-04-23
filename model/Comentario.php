<?php

require_once ('Model.php'); 

class Comentario extends Model{

	
	var $idnoticia;
	var $idcomentario;   
	var $comentario;
	var $time; 
	var $user;
	  
	public function checkValidity(){
		return true; 
	}
	 
	public function getKeyFields(){
		return array("idcomentario"); 
	}
	
}
?>