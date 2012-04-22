<?php

class Clube_Imagem extends Model{
	var $idclube; 
	var $imagem; 
	var $content_type; 
	
	public function getKeyFields(){
		return array("idclube"); 
	}
	
	public function checkValidity(){
		return true; 	
	} 
	
}
?>