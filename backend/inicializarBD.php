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
	if (//strcmp($table, "local") != 0  &&
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
echo "Inicializa da Tabela <b>fonte</b>...";
$f = new Fonte();
$f->ligado = 1; 
$f->type = 2; 
$f->webname = "twiiter" ; 
$f->xml =  "<template>
	<uri>
	<url>http://search.twitter.com/search.rss</url>
	<query>
	<variable>
	<id>q</id>
	</variable>
	<variable>
	<id>include_entities</id>
	<value>true</value>
	</variable>
	<variable>
	<id>result_type</id>
	<value>mixed</value>
	</variable>
	</query>
	</uri>
	<noticia>
	<item>/rss/channel/item</item>
	<data_pub>pubDate</data_pub>
	<assunto>title</assunto>
	<descricao>description</descricao>
	<link>link</link>
	<user>author</user>
	<formatfoo>formatDateToDB</formatfoo>
	</noticia>
	</template>";

try{
	$f->add();
	$f->type = 1; 
	$f->webname = 'sapo';
	$f->xml =  "<template>
	<uri>
		<url>http://pesquisa.sapo.pt/</url>
		<query>
			<variable>
				<id>barra</id>
				<value>noticias</value>
			</variable>
			<variable>
				<id>cluster</id>
				<value>0</value>
			</variable>
			<variable>
				<id>format</id>
				<value>rss</value>
			</variable>
			<variable>
				<id>location</id>
				<value>pt</value>
			</variable>
			<variable>
				<id>st</id>
				<value>local</value>
			</variable>
			<variable>
				<id>limit</id>
				<value>10</value>
			</variable>
			<variable>
				<id>q</id>
			</variable>
		</query>
	</uri>
	<noticia>
		<item>/rss/channel/item</item>
		<data_pub>pubDate</data_pub>
		<assunto>title</assunto>
		<descricao>description</descricao>
		<link>link</link>
		<formatfoo>formatDateToDB</formatfoo>
	</noticia>
</template>"; 
	$f->add();
	$f->webname ='webportuguesa';
	$f->xml = "<template>
	<uri>
	<url>http://arquivo.pt/opensearch</url>
	<query>
	<variable>
	<id>query</id>
	</variable>
	</query>
	</uri>
	<noticia>
	<item>/rss/channel/item</item>
	<data_pub>pwa:tstamp</data_pub>
	<assunto>title</assunto>
	<descricao>pwa:digest</descricao>
	<link>link</link>
	<formatfoo>formatTstampToDb</formatfoo>
	</noticia>
	</template>";
	$f->type = 1;
	$f->add();
	$f->webname = 'gnews';
	$f->xml = "invalid";
	$f->add();
	$f->webname = 'webservice'; 
	$f->xml = '';
	$f->add();
	
	
}catch(Exception $e){
	echo $e; 
	echo '<br/>Could not add fonte ' . $f->nome . "<br/>"; 
}

echo "Ok!<hr>";

//----------------------------- LOCAL ---------------------------------------------------------//
echo "Inicialização da Tabela <b>local</b>... ";

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