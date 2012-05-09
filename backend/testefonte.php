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
		<item>/rss/channel/item</item>
		<data_pub>item/pubDate</data_pub>
		<assunto>item/title</assunto>
		<descricao>item/description</descricao>
		<link>item/link</link>
	</noticia>
</xml>";

$f = new Fonte();
$f->data_pub = "item/pubDate";
$f->assunto = "item/title";
$f->descricao = "item/description";
$f->{'link'} = "item/link";
$f->idfonte = 99;
$f->item = "/rss/channel/item";


			//prepara query
			$url_search = "http://pesquisa.sapo.pt/?barra=noticias&cluster=0&format=rss&location=pt&st=local&limit=10&q=porto";
			  
			$ch = curl_init($url_search);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$data = curl_exec($ch);
			curl_close($ch);
			
			$doc = new SimpleXmlElement($data, LIBXML_NOCDATA);
			
			$doc = $data->xpath($f->item);
			
			if($doc){
				foreach($doc as $item){
					$myNew = new Noticia();
					$myNew->setIdfonte($f->idfonte);
					
					// pubDate
					$pub = $item->xpath($f->data_pub);
					if(isset($pub)) $myNew->setData_pub(Util::formatDateToDB($pub));
					else $myNew->setData_pub("");
					
					// assunto
					$ass = $item->xpath($f->assunto);
					if(isset($ass)) $myNew->setAssunto($ass);
					else $myNew->setAssunto("");
					
					// descricao
					$desc = $item->xpath($f->descricao);
					if(isset($desc)) $myNew->setDescricao($desc);
					else $myNew->setDescricao("");
					
					// link
					$link = $item->xpath($f->{'link'});
					if(isset($link)) $myNew->setLink($link);
					else continue;
					
					// texto
					//parserNoticias
				}
				echo "Foram inseridas notícias da Fonte ".$this->getNome()." com sucesso.";
			}

?>