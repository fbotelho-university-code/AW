<?php

require_once "./lib/Util.php";
require_once "./classes/DAO.php";
require_once "./classes/Noticia.php";
require_once "./classes/Clube.php";
require_once "./classes/Local.php";
require_once "ParserNoticias.php";

$n = new Noticia();

$n->getObjectById(1);

ParserNoticias::parseNoticia($n);



?>