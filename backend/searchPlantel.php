<?php

require_once "includes.php";
require_once "lib/simple_html_dom.php";

//ini_set('default_charset','UTF-8');

$clubes = array("sl_benfica", "fc_porto", "sporting_cp", "sc_braga", "nacional");
$url = "http://www.lpfp.pt/liga_zon_sagres/pages/clube.aspx?epoca=20112012&clube=";

$int = new Integrante();
$int->clear();
$int->setIdintegrante(null);

/* echo "<br><b>Benfica</b><hr>"; */
parserPlantel($clubes[0], 11, 176);

/* echo "<br><b>Porto</b><hr>"; */
parserPlantel($clubes[1], 11, 191);

/* echo "<br><b>Sporting</b><hr>"; */
parserPlantel($clubes[2], 11, 146);

/* echo "<br><b>Braga</b><hr>";*/
parserPlantel($clubes[3], 11, 241);

/* echo "<br><b>Nacional</b><hr>";*/
parserPlantel($clubes[4], 11, 171);

function parserPlantel($clube, $begin, $end) {
	global $url, $clubes, $int;
	$page = file_get_html($url.$clube);
	$items = $page->find('td.tl');	
	for($i = $begin; $i <=$end; $i++) {
		$int->setIdclube(array_search($clube, $clubes) + 1);
		$int->setIdfuncao(3);
		$int->setNome_integrante(addslashes($items[$i]->innertext));
		$int->add();
		$i +=4;
	} 
}

?>