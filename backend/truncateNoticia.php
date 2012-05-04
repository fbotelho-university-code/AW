<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "includes.php";

$n = new Noticia();
$n->clear();

$nd = new Noticia_data();
$nd->clear();

$nl = new Noticia_locais();
$nl->clear();

$ni = new Noticia_Has_Integrante();
$ni->clear();

$nc = new Noticia_Has_Clube();
$nc->clear();

?>