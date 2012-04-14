<?php

require_once ('../model/Fonte.php'); 

class Utill {
	public static function getIdWebServiceAsFonte(){
		$f = new Fonte("WebService");		
		return $f->getIdFonte();
	}
}
?>