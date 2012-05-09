<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "../model/Fonte.php";

$xml = "<xml>
	<uri>
		<uri>http://pesquisa.sapo.pt/</uri>
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
		</query>
		<search>
			<id>q</id>
		</search>
	</uri>
	<noticia>
		<data_pub>item/pubDate</data_pub>
		<assunto>item/title</assunto>
		<descricao>item/description</descricao>
		<link>item/link</link>
	</noticia>
</xml>";


$f = new Fonte();







?>