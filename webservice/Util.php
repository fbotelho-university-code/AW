<?php
@header('Content-Type: text/html; charset=utf-8');
require_once ('../model/Fonte.php'); 

class Utill {
	public static function getIdWebServiceAsFonte(){
		$f = new Fonte("webservice");		
		return $f->getIdFonte();
	}
	
	public static function whiteListening($text){
		return true; 
	}

	public static function getEtag($ob){
		return md5(var_export($ob, true));
	}
	
	public static function checkEtag($req, $ob){
		$n = $req->getEtag();
		$hash = Utill::getEtag($ob);
		if (isset($n)){
			if (strcmp($hash,$req->getEtag()) == 0){
				//Not modified. 
			   RestUtils::sendResponse(304); 	
			}
		}
		return $hash; 
	}
}
?>