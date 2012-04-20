<?php
@header('Content-Type: text/html; charset=utf-8');
require_once ('../model/Fonte.php'); 

class Utill {
	public static function getIdWebServiceAsFonte(){
		$f = new Fonte("WebService");		
		return $f->getIdFonte();
	}
}
?>