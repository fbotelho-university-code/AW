<?php

require_once ('../model/Fonte.php'); 

class Util {
	
	public static function getIdWebServiceAsFonte(){
		
		$f = new Fonte("WebService");		
		return $f->getIdFonte();
	}
}
?>