<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "includes.php";
require_once "lib/simple_html_dom.php";

/**
* Classe responsavel pelo consulta ao Servico Geo-Net-PT para armazenamento das referencias espaciais
*/
class GeoNetPtClient extends Fonte {
	
	var $main_url = 'http://dmir.inesc-id.pt/resolve/geonetpt02/sparql.psp'; 


	/**
	 * Busca inform��es sobre as refer�ncias espaciais na fonte Geo-Net-PT
	 * @param Array $parameters Array com queries SparQL
	 * @return Array $places Array com informa��es sobre os locais (nome e corrdenadas)
	 */
	public function search($parameters) {
		foreach($parameters as $query) {
			/* Execute the query */
			@$page = file_get_html($this->main_url.$query);
			
			if ($page == null) return null; 
			/* Parsing */
			$tableHeader = TRUE;
			/* Sweep all the entries in the table */
			foreach($page->find('tr') as $element) {
				/* One should ignore the first element, because its the table's header */
				if($tableHeader==TRUE){
					$tableHeader=FALSE;
					continue;
				}
			
				$tmp = array();
				$entry = array( 'idlocal' => '', 'nome_local'=>'', 'coordenadas'=>'');
			
				/* Sweep all the cells in an entry */
				foreach ($element->find('td') as $val)
				$tmp[] = addslashes(trim(substr($val,4,-5)));
			
				/* Fill the entry with the respective values */
				$l = new Local();
				$rs = $l->findFirst(array("nome_local" => $tmp[0]));
				if (!isset($rs)){ 
					$l->setNome_local($tmp[0]);
					$l->lat = $tmp[1];
					$l->log = $tmp[2];
					$l->add();
				}
			}
		}
	}
}

$geo = new GeoNetPtClient();

/* URIs to query Geo-Net-PT (order: Ilhas, Concelhos and Distrito) */
$queryIlha = '?default-graph-uri=http%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeonetpt02&query=PREFIX+dcterms%3A+%3Chttp%3A%2F%2Fpurl.org%2Fdc%2Fterms%2F%3E%0D%0APREFIX+geo%3A+%3Chttp%3A%2F%2Fwww.w3.org%2F2003%2F01%2Fgeo%2Fwgs84_pos%23%3E%0D%0APREFIX+gn%3A+%3Chttp%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeo-net%23%3E%0D%0APREFIX+gnpt%3A+%3Chttp%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeo-net-pt%23%3E%0D%0APREFIX+gnpt02%3A+%3Chttp%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeo-net-pt-02%23%3E%0D%0ASELECT+%3Ftitle%2C+%3Flatitude%2C+%3Flongitude+where+%7B%0D%0A++%3Fentity+gn%3Atype+gnpt02%3Ailha-ATILH+.%0D%0A++%3Fentity+dcterms%3Atitle+%3Ftitle+.%0D%0A++%3Fentity+gn%3Afootprint+%3Ffootprint+.%0D%0A++%3Ffootprint+geo%3Alat+%3Flatitude+.%0D%0A++%3Ffootprint+geo%3Along+%3Flongitude+.%0D%0A%7D+ORDER+BY+%3Ftitle&format=text%2Fhtml&debug=off';
$queryConc = '?default-graph-uri=http%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeonetpt02&query=PREFIX+dcterms%3A+%3Chttp%3A%2F%2Fpurl.org%2Fdc%2Fterms%2F%3E%0D%0APREFIX+geo%3A+%3Chttp%3A%2F%2Fwww.w3.org%2F2003%2F01%2Fgeo%2Fwgs84_pos%23%3E%0D%0APREFIX+gn%3A+%3Chttp%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeo-net%23%3E%0D%0APREFIX+gnpt%3A+%3Chttp%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeo-net-pt%23%3E%0D%0APREFIX+gnpt02%3A+%3Chttp%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeo-net-pt-02%23%3E%0D%0ASELECT+%3Ftitle%2C+%3Flatitude%2C+%3Flongitude+where+%7B%0D%0A++%3Fentity+gn%3Atype+gnpt02%3Aconcelho-ATCON+.%0D%0A++%3Fentity+dcterms%3Atitle+%3Ftitle+.%0D%0A++%3Fentity+gn%3Afootprint+%3Ffootprint+.%0D%0A++%3Ffootprint+geo%3Alat+%3Flatitude+.%0D%0A++%3Ffootprint+geo%3Along+%3Flongitude+.%0D%0A%7D+ORDER+BY+%3Ftitle&format=text%2Fhtml&debug=off';
$queryDist = '?default-graph-uri=http%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeonetpt02&query=PREFIX+dcterms%3A+%3Chttp%3A%2F%2Fpurl.org%2Fdc%2Fterms%2F%3E%0D%0APREFIX+geo%3A+%3Chttp%3A%2F%2Fwww.w3.org%2F2003%2F01%2Fgeo%2Fwgs84_pos%23%3E%0D%0APREFIX+gn%3A+%3Chttp%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeo-net%23%3E%0D%0APREFIX+gnpt%3A+%3Chttp%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeo-net-pt%23%3E%0D%0APREFIX+gnpt02%3A+%3Chttp%3A%2F%2Fdmir.inesc-id.pt%2Fpub%2Fpublications%2F2009%2F10%2Fgeo-net-pt-02%23%3E%0D%0ASELECT+%3Ftitle%2C+%3Flatitude%2C+%3Flongitude+where+%7B%0D%0A++%3Fentity+gn%3Atype+gnpt02%3Adistrito-ATDST+.%0D%0A++%3Fentity+dcterms%3Atitle+%3Ftitle+.%0D%0A++%3Fentity+gn%3Afootprint+%3Ffootprint+.%0D%0A++%3Ffootprint+geo%3Alat+%3Flatitude+.%0D%0A++%3Ffootprint+geo%3Along+%3Flongitude+.%0D%0A%7D+ORDER+BY+%3Ftitle&format=text%2Fhtml&debug=off';

$queries = array($queryIlha, $queryConc, $queryDist);
$l = new Local();
$result = $geo->search($queries);

?>