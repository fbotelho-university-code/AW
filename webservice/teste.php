<?php require_once ('../model/Clube.php'); 

	$clube = new Clube();
	
	$xmlString = "<?xml version='1.0' encoding='UTF-8'?>
<clube>
  <idclube>1</idclube>
  <idlocal>1</idlocal>
  <idcompeticao>1</idcompeticao>
  <nome_clube>Bahia</nome_clube>
  <nome_oficial>Esporte Clube Bahia</nome_oficial>
</clube>";
	
	$clube->validateXMLbyXSD($xmlString);

?>