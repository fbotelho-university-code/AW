<?php

require_once "./lib/Util.php";
require_once "./classes/DAO.php";
require_once "./classes/Noticia.php";
require_once "./classes/Clube.php";

$c = new Clube();

$clubes = $c->getAll();

var_dump($clubes);

?>