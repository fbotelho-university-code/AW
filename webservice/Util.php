<?php
@header('Content-Type: text/html; charset=utf-8');
require_once ('../model/Fonte.php'); 

class Utill {
	public static function getIdWebServiceAsFonte(){
		$f = new Fonte("WebService");		
		return $f->getIdFonte();
	}
	
	public static function whiteListening($text){
		return true; 
	}
	
	public static function checkEtag($req, $ob){
		if (($n = $req->getEtag())){
			$hash = md5(var_export($ob, true));
			if ($hash == $req->getEtag()){
				//Not modified. 
			   RestUtils::sendResponse(304); 	
			}
		}
	}
}
?>