<?php
$start = $count = null;
if(isset($_GET["start"])) {
	$start = $_GET["start"];
	settype($start, "integer");
}
if(isset($_GET["count"])) {
	$count = $_GET["count"];
	settype($count, "integer");
}
if(!is_null($start) && is_null($count)) {
	$count = 10;
}
if(is_null($start) && !is_null($count)) {
	$start = 0;
}
?>