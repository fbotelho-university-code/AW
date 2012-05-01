<?php
@header('Content-Type: text/html; charset=utf-8');

class Util {

	/**
	 * Array com a correla��o dos meses do ano em formato [A-Z]2[a-z] para 2[00-12]
	 * @var String[] 
	 */ 
	static $meses = array( "Jan" => "01",
				"Feb" => "02", 
				"Mar" => "03",
				"Apr" => "04",
				"May" => "05",
				"Jun" => "06",
				"Jul" => "07",
				"Ago" => "08",
				"Sep" => "09",
				"Oct" => "10",
				"Nov" => "11",
				"Dec" => "12");
	
	static $mesesFull = array(
						"Janeiro" 	=> "01",
						"Fevereiro" => "02", 
						"Mar�o" 	=> "03",
						"Abril" 	=> "04",
						"Maio" 		=> "05",
						"Junho" 	=> "06",
						"Julho" 	=> "07",
						"Agosto" 	=> "08",
						"Setembro" => "09",
						"Outubro" 	=> "10",
						"Novembro" 	=> "11",
						"Dezembro" 	=> "12");

	/**
 	* 
 	* Converte formato de Data de "Fri, 01 Jan 2000 00:00:00 -000" para AAAA-MM-DD HH:MM:SS
 	* @param String $stringDate //data no formato Dia-da-semana, DD MMM AAA, HH:MM:SS -000 
 	* @return String //data em formato AAAA-MM-DD HH:MM:SS
 	*/
	public static function formatDateToDB($stringDate) {
		if($stringDate == "") {
			$date_db_formated = "0000-00-00 00:00:00";
		}
		else {
			$date_db = substr($stringDate,5,20);
			$date_db = explode(" ", $date_db);
			$date_db_formated = $date_db[2]."-".Util::$meses[$date_db[1]]."-".$date_db[0]." ".$date_db[3];
		}
		return $date_db_formated;
	}

	/**
 	* Converte o formato de Data de AAAAMMDDHHMMSS -000
 	* @param unknown_type $tstmp
 	*/
	public static function formatTstampToDb($tstmp) {
		$ano = substr($tstmp,0,4);
		$mes = substr($tstmp,4,2);
		$dia = substr($tstmp,6,2);
		$hora = substr($tstmp,8,2);
		$min = substr($tstmp,10,2);
		$seg = substr($tstmp, 12,2);
		$data_db = $ano."-".$mes."-".$dia." ".$hora.":".$min.":".$seg;
		return $data_db;	
	}

	/**
	 * Procura texto da not�cia em p�gina HTML
	 * @param String $url URL da p�gina HTML na qual se dar� a busca
	 * @param String $selector Tag HTML na qual a pesquisa dever� ser feita
	 * @param String $texto Texto a procurar
	 * @return String $text Texto da not�cia
	 */
	public static function find_contains($url, $selector, $keyword) {
    	$html = file_get_html($url);
		$ret = array();
    	foreach ($html->find($selector) as $e) {
        	if (strpos($e->innertext, $keyword)!==false)
            	$ret[] = $e;
    	}
    	
    	$text = "";
    	foreach($ret as $element) {
    		$text .= addslashes(trim($element->innertext));
    	}

   	 	return $text;
	}
	
	/**
	 * Busca todos os par�metros para realizar pesquisas em fontes de informa��o.
	 * Os par�metros s�o todos os nomes de clube e de integrantes cadastrados no banco de dados
	 * @return String[] $param
	 */
	public static function getSearchParameters() {
		$dao = new DAO();
		$param = array();
		
		$sqlClube = "SELECT nome_oficial FROM clube";
		$rs = $dao->execute($sqlClube);
		while(!$rs->EOF) {
			$param[] = $rs->fields["nome_oficial"];
			$rs->MoveNext();
		}
		
		/*$sqlIntegrante = "SELECT nome_integrante FROM integrante";
		$rs = $dao->execute($sqlIntegrante);
		while(!$rs->EOF) {
			$param[] = $rs->fields["nome_integrante"];
			$rs->MoveNext();
		}*/
		
		return $param;
	}
}

?>