<?php

require_once "includes.php";

$n = new Noticia();

$n->getObjectById(1);

ParserNoticias::parseNoticia($n);



?>