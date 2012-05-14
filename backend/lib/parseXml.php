<?php

require_once('Util.php'); 
require_once ('../model/Noticia.php'); 
//prepara query

function parseXml($data, $f, $idfonte, $about=null){
try{
	$data = str_replace('xmlns=', 'ns=', $data); 
	@$doc = new SimpleXmlElement($data, LIBXML_NOCDATA);
}catch(Exception $e){
	return ;
}
if (!isset($doc)){
	return ; 
}
$f = $f->noticia;
$doc = $doc->xpath($f->item);

if($doc){
	foreach($doc as $item){
		$myNew = new Noticia();
		$myNew->setIdfonte($f->idfonte);
		
		// pubDate
		if (isset($f->data_pub) && isset($f->formatfoo)){
			$pub = $item->xpath($f->data_pub);
			if(isset($pub)){
				$foo = $f->formatfoo . ""; 
				$myNew->setData_pub(BackUtil::$foo($pub[0]));
			}
			else $myNew->setData_pub("");
		}
		if (isset($f->assunto)){
			$ass = $item->xpath($f->assunto);
			if(isset($ass)){
				$myNew->setAssunto(deal($ass[0] . ""));
			}
			else $myNew->setAssunto("");
		}
		if (isset($f->descricao)){
			$desc = $item->xpath($f->descricao);
			if(isset($desc)) $myNew->setDescricao(deal($desc[0] . ""));
			else $myNew->setDescricao("");

			
		}
		if (isset($f->user)){
			$user = $item->xpath($f->user); 
			if (isset($user)) $myNew->user = (deal($user[0]));
		}
		
		// link
		$link = $item->xpath($f->{'link'});
		if(isset($link)) $myNew->setUrl($link[0] . "");
		else continue;
		if (isset($about)){
			$myNew->about = $about; 
		}
		$myNew->idfonte = $idfonte;
		$noticas[] = $myNew; 
	}
	return $noticas; 
}

}
	
	function deal($ts){
		return addslashes(strip_tags($ts)); 
	}
?>