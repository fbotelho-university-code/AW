<?php

require_once "includes.php";

echo "<center><h1>Inicialização da Base de Dados</h1></center>";
//-------------------------- LIMPANDO BASE DE DADOS -------------------------------------------//
echo "Limpando a Base de Dados... ";
$dao = new DAO();

$rs = $dao->execute("SELECT table_name FROM information_schema.tables WHERE table_schema = 'aw' AND table_name NOT LIKE 'view_%';");

while(!$rs->EOF) {
	$table = $rs->fields["table_name"];
	$sql = "TRUNCATE TABLE ". $table;
	$dao->execute($sql);
	$rs->MoveNext();
}
echo "Ok!<hr>";

//----------------------------- FONTE ----------------------------------------------------------//
echo "Inicialização da Tabela <b>fonte</b>...";
$f = new Fonte();
$f->setIdfonte(null);
$f->setLigado(1);

$f->setNome("Arquivo da Web Portuguesa");
$f->setMain_url("http://arquivo.pt/opensearch?query=");
$f->add();

$f->setNome("RSS Sapo Notícias");
$f->setMain_url("http://pesquisa.sapo.pt/?barra=noticia&format=rss&q=");
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

//---------------------------- COMPETICAO ---------------------------------------------------//
echo "Inicialização da Tabela <b>competicao</b>... ";
$comp = new Competicao();
$comp->setIdcompeticao(null);

$comp->setNome_competicao("Liga Zon Sagres");
$idLigaZon = $comp->add();
$comp->setNome_competicao("Liga Orangina");
$idLigaOran = $comp->add();
echo "Ok!<hr>";

//----------------------------- LOCAL ---------------------------------------------------------//
echo "Inicialização da Tabela <b>local</b>... ";
$l = new Local();
include "GeoNetPtClient.php";
echo "Ok!<hr>";

//----------------------------- CLUBE ----------------------------------------------------------//
echo "Inicialização da Tabela <b>clube</b>... ";
$c = new Clube();
$c->setIdclube(null);

$c->setNome_clube("Benfica");
$where = array("nome_local" => "Lisboa");
$idlocalLisboa = $l->findFirst($where)->getIdlocal();
$c->setIdlocal($idlocalLisboa);
$c->setIdcompeticao($idLigaZon);
$c->setNome_oficial("sport lisboa e benfica");
$idBenfica = $c->add();

$c->setNome_clube("Porto");
$where = array("nome_local" => "Porto");
$idlocalPorto = $l->findFirst($where)->getIdlocal();
$c->setIdlocal($idlocalPorto);
$c->setIdcompeticao($idLigaZon);
$c->setNome_oficial("futebol clube do porto");
$idPorto = $c->add();

$c->setNome_clube("Sporting");
$c->setIdlocal($idlocalLisboa);
$c->setIdcompeticao($idLigaZon);
$c->setNome_oficial("sporting clube de portugal");
$idSporting = $c->add();

$c->setNome_clube("Braga");
$where = array("nome_local" => "Braga");
$idlocalBraga = $l->findFirst($where)->getIdlocal();
$c->setIdlocal($idlocalBraga);
$c->setIdcompeticao($idLigaZon);
$c->setNome_oficial("sporting clube de braga");
$idBraga = $c->add();

$c->setNome_clube("Nacional");
$where = array("nome_local" => "Funchal");
$idlocalFunchal = $l->findFirst($where)->getIdlocal();
$c->setIdlocal($idlocalFunchal);
$c->setIdcompeticao($idLigaZon);
$c->setNome_oficial("clube desportivo nacional");
$idNacional = $c->add();
echo "Ok!<hr>";
//----------------------------- FUNCAO ----------------------------------------------------------//
echo "Inicialização da Tabela <b>funcao</b>... ";
$f = new Funcao();
$f->setIdFuncao(null);

$f->setFuncao("Presidente");
$idPresidente = $f->add();

$f->setFuncao("Treinador Principal");
$idTreinadorP = $f->add();

$f->setFuncao("Jogador");
$idJogador = $f->add();

echo "Ok!<hr>";
//----------------------------- INTEGRANTE ---------------------------------------------------------//
echo "Inicialização da Tabela <b>integrante</b>... ";
$i = new Integrante();
include ("searchPlantel.php");
echo "Ok!<hr>";
//----------------------------- LEXICO -------------------------------------------------------------//
echo "Inicialização da Tabela <b>lexico</b>... ";
require_once ("ReadLexico.php");
echo "Ok!<hr>";
echo 'The end'; 

?>