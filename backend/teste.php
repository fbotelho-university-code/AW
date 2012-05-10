<?php
require_once('../model/Fonte.php');

$f = new Fonte();
$rs = $f->search(array("Benfica"));
var_dump($rs); 
?>