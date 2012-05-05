<?php

class Clube_Imagem extends Model{
	
	public function getKeyFields(){
		return array("idclube"); 
	}
	
	public function checkValidity(){
		return true; 	
	} 
	
}
?>