<?php
@header('Content-Type: text/html; charset=utf-8');
$xml = new DOMDocument();
$xml->load('./Noticia.xml');

//echo $xml->documentElement->namespaceURI;

@$validate = $xml->schemaValidate('./Noticia.xsd');

if ($validate) {
   echo "valid<p/>";
}
else {
   echo "invalid<p/>";
}


/**
	1) Schema para incluir dependencias no XML
	2) Fun��o p/ incluir cabe�alho XML para valida��o do Schema
	3) Fun��o para tratamento de erro de Schemas (chamada pela fun��o de valida��o)
	
	
	
	WADL no Anexo do Relat�rio
	Citar no Relat�rio os m�dulos e exemplos.
	Acrescentar noticia: "Chamo Web service com esses parametros e ele devolve isso"
	
	Evitar os filtros do lado do front end.
	Inserir filtros no webservice. Ex: Buscra as primeiras 10 norticias.
	Filtros sobre datas e locais
	Zoom em um mapa em Lisboa = buscra not�cias s� de Lisboa.
	Obrigat�rio: PUT e DELETE
	
	Interface HTML para teste do Web Service.
	
	Apresentar uma p�gina HTML com a API do Web Service, com exemplos.
	
	Uso de Parametros para realizar filtros do n�mero de resultados.(N�o necessariamente REST full)
	Ou noticias.php/1-10
	
	Converter parametros da URL para transformar em String (settype()). Mais para tratar SQL Injection.
	
	O Prof falou que n�o vai avaliar c�digo!!!!
	No DELETE, N�o apagar a not�cia. Colocar ela como n�o visivel.
	
	1) Filtro para GelALL
	2) Inserir clube na noticia apos pesquisa
	3) XSD para Rela��o
		/noticias
	4) Cabe�alho XML
	
*/

?>