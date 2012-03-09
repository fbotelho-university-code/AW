<?php

include "./classes/Integrante.php";
include "./classes/DAO.php";

$i = new Integrante();
$i->retrieveIntegrante(1);
var_dump($i);

?>