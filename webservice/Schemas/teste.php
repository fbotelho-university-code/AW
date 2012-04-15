<?php

$xml = new DOMDocument();
$xml->load('./Noticias.xml');

echo $xml->documentElement->namespaceURI;
/*
@$validate = $xml->schemaValidate('./Noticias.xsd');

if ($validate) {
   echo "valid<p/>";
}
else {
   echo "invalid<p/>";
}*/


/**
	1) Schema para incluir dependencias no XML
	2) Função p/ incluir cabeçalho XML para validação do Schema
	3) Função para tratamento de erro de Schemas (chamada pela função de validação)
	
	
	
	WADL no Anexo do Relatório
	Citar no Relatório os módulos e exemplos.
	Acrescentar noticia: "Chamo Web service com esses parametros e ele devolve isso"
	
	Evitar os filtros do lado do front end.
	Inserir filtros no webservice. Ex: Buscra as primeiras 10 norticias.
	Filtros sobre datas e locais
	Zoom em um mapa em Lisboa = buscra notícias só de Lisboa.
	Obrigatório: PUT e DELETE
	
	Interface HTML para teste do Web Service.
	
	Apresentar uma página HTML com a API do Web Service, com exemplos.
	
	Uso de Parametros para realizar filtros do número de resultados.(Não necessariamente REST full)
	Ou noticias.php/1-10
	
	Converter parametros da URL para transformar em String (settype()). Mais para tratar SQL Injection.
	
	O Prof falou que não vai avaliar código!!!!
	No DELETE, Não apagar a notícia. Colocar ela como não visivel.
	
	1) Filtro para GelALL
	2) Inserir clube na noticia apos pesquisa
	3) XSD para Relação
		/noticias
	4) Cabeçalho XML
	
*/

?>