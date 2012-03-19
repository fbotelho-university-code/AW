<?php


include "./lib/simple_html_dom.php";
include "./classes/DAO.php";

//ini_set('default_charset','UTF-8');

$clubes = array("sl_benfica", "fc_porto", "sporting_cp", "sc_braga", "nacional");
$url = "http://www.lpfp.pt/liga_zon_sagres/pages/clube.aspx?epoca=20112012&clube=";

$dao = new DAO();
$dao->connect();

echo "Apagando todas as entradas da tabela 'integrante'...<br>";
$sql = "DELETE FROM integrante WHERE 1";
$dao->db->Execute($sql) or die($dao->db->ErrorMsg());
echo "Tabela 'integrante' apagada!<br><br>";

$integrantes = array();

echo "Inicializando tabela integrante...<br>";

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

echo "Tabela 'integrante' inicializada com ".count($integrantes). " linhas.<br>";

function parserPlantel($clube, $begin, $end) {
	global $url, $clubes, $dao;
	$page = file_get_html($url.$clube);
	$items = $page->find('td.tl');
	$integrantes = array();
	for($i = $begin; $i <=$end; $i++) {
		$integrante = array();
		$integrante["idintegrante"] = null;
		$integrante["idclube"] = array_search($clube, $clubes) + 1;
		$integrante["idfuncao"] = 3;
		$integrante["nome_integrante"] = addslashes($items[$i]->innertext);
		$GLOBALS["integrantes"][] = $integrante;
		$rs = $dao->db->AutoExecute("integrante", $integrante, "INSERT") or die($dao->db->ErrorMsg());
		$i +=4;
	} 
}


	

?>