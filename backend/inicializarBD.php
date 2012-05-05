<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "includes.php";

echo "<center><h1>Inicialização da Base de Dados</h1></center>";
//-------------------------- LIMPANDO BASE DE DADOS -------------------------------------------//
echo "Limpando a Base de Dados... ";
$dao = new DAO();

$rs = $dao->execute("SELECT table_name FROM information_schema.tables WHERE table_schema = 'aw' AND table_name NOT LIKE 'view_%';");

while(!$rs->EOF) {
	$table = $rs->fields["table_name"];
	if (strcmp($table, "local") != 0  &&
		strcmp($table,"noticia_data_clube") != 0 && 
		strcmp($table,"noticia_x_clube") != 0 &&
		strcmp($table,"nr_noticia_data") != 0 &&
		strcmp($table,"nr_noticia_integrante") != 0 &&
		strcmp($table,"nr_noticia_local_clube") != 0 &&
		strcmp($table,"nr_noticia_local") != 0 &&
		strcmp($table,"testview") != 0
		){
		echo "Apagando tabela : " . $table . "<br/>"; 
		$sql = "TRUNCATE TABLE ". $table;
		$dao->execute($sql);
	}
	$rs->MoveNext();
}
echo "Ok!<hr>";

//----------------------------- FONTE ----------------------------------------------------------//
echo "Inicializa��o da Tabela <b>fonte</b>...";
$f = new Fonte();
$f->setIdfonte(null);
$f->setLigado(1);

$f->setNome("Arquivo da Web Portuguesa");
$f->setMain_url("http://arquivo.pt/opensearch?query=");
$f->add();

$f->setNome("RSS Sapo Noticias");
$f->setMain_url("http://pesquisa.sapo.pt/?barra=noticias&cluster=0&format=rss&location=pt&st=local&limit=10&q=");
$f->add();

$f->setNome("Geo-Net-PT");
$f->setMain_url("http://dmir.inesc-id.pt/resolve/geonetpt02/sparql.psp");
$f->add();

$f->setNome("RSS Google News");
$f->setMain_url("https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=");
$f->add();

$f->setNome("Google Maps");
$f->setMain_url("http://maps.google.com");
$f->add();

$f->setNome("TwitterSearch");
$f->setMain_url("http://search.twitter.com/search.rss");

$f->setNome("WebService");
$f->setMain_url("");
$f->add(); 

echo "Ok!<hr>";

//----------------------------- LOCAL ---------------------------------------------------------//
echo "Inicialização da Tabela <b>local</b>... ";
$l = new Local();

include "GeoNetPtClient.php";

echo "Ok!<hr>";

echo "Inicialização de Integrantes e Clubes da Primeira liga portuguesa através da dbpedia <br/>";

include "dbpedia.php";
insertClubesOfPrimeiraLiga(); 

//----------------------------- LEXICO -------------------------------------------------------------//
echo "Inicialização da Tabela <b>lexico</b>... ";
require_once ("ReadLexico.php");
echo "Ok!<hr>";
echo 'The end'; 

?>