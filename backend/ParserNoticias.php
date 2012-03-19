<?php
/**
 * Classe para fazer parsing ao texto da noticia.
 * TODO - meter este código na própria classe Noticia 
 */
 
 include ('./classes/Noticia.php'); 
 include ('./classes/Local.php'); 
 include ('./classes/NoticiasLocais.php'); 
 include ("./adodb/adodb.inc.php");
 include ("./classes/DAO.php");

/*
 * Created on Mar 10, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

    class ParserNoticias {
    	
    	/**
    	 * Efectua parsing de noticias
    	 * Efectua mudanças directamente na base de dados relativa à noticia  
    	 */
		public static function parseNoticia($noticia){
			//lexico de futebol
			//Clubes/integrantes
			//referencias espacial
			ParserNoticias::findLocais($noticia); 
			//referencias temporal 
		}
		
		private static function findLocais($noticia){
			//TODO - ir buscar isto de cada vez é um bocado desperdicio. 
			$locais = Local::getAll();
			
			$textoNoticia = $noticia->getTexto();
			 
			foreach ($locais as $local){
				$nome_local = ' ' . $local->getNome_local() . ' ';   // para encontrar palavra exacta e nao no meio de outra palavra 
				$pos = stripos($textoNoticia , $local->getNome_local());
				if ($pos !== false){
					NoticiasLocais::insertByObject($noticia, $local);
				} 
			}
		}
		 	
		private static function findClubes($noticia){
			$textoNoticia = $noticia->getTexto(); 
			$lexicos = Lexico::getAll(); 
			foreach($lexicos as $lexico){
				$pos = stripos($textoNoticia, $lexico->getContexto());
				if ($pos !== false){
					//Find the clube associated with lexico. 
					//TODO - lexico poderia estar associado a mais que um clube !  
					//Assumindo que só vai ser associado a um: 
					$lexClubes = LexicoClubes::find(array("idlexico" => $lexico->getIdlexico()));
					
					//relação entre noticiaEClubes
					$rel = NoticiasClubes::find(array("idnoticia" => $noticia->getIdnoticia(), "idclube" => $lexicoClubes->getIdClube())); 
					if (!$rel){
						$rel = new NoticiasClubes($noticia->getIdnoticia(), $); 
					}
					$rel->addQualificacao($lexico->getPol()){
					}
				}
			}
		}
		
		private static function findIntegrantes($noticia){
				
		} 
		
		private static function findTemporal($noticia){
			
						$regexes = array(
/*1*/			'/\d{1,2}((\ )*\/(\ )*|(\ )*\-(\ )*)\d{1,2}((\ )*\/(\ )*|(\ )*\-(\ )*)\d{2}/',
/*2*/			'/\d{1,2}(\/|\-)\d{1,2}(\/|\-)\d{4}/',
/*3*/			'/\d{4}(\/|\-)\d{1,2}(\/|\-)\d{1,2}/',
/*4*/			'/\d{1,2}(\/|\-)(Jan|Fev|Mar|Abr|Mai|Jun|Jul|Ago|Set|Out|Nov|Dez)(\/|\-)\d{2}/',
/*5*/			'/\d{1,2}(\/|\-)(Jan|Fev|Mar|Abr|Mai|Jun|Jul|Ago|Set|Out|Nov|Dez)(\/|\-)\d{4}/',
/*6*/			'/\d{4}(\/|\-)(Jan|Fev|Mar|Abr|Mai|Jun|Jul|Ago|Set|Out|Nov|Dez)(\/|\-)\d{1,2}/',
/*7*/			'/\d{1,2}(\ de\ |,\ ){0,1}(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)(\ de\ |,\ ){0,1}\d{2}/',
/*8*/			'/\d{1,2}(\ de\ |,\ ){0,1}(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)(\ de\ |,\ ){0,1}\d{4}/',
/*9*/			'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)\ \d{1,2}(\ de\ |\ ){0,1}\d{2}/',
/*10*/			'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)\ \d{1,2}(\ de\ |,\ ){0,1}\d{4}/',
/*11*/			'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)\ \d{1,2}/',
/*12*/			'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)\ \d{4}/',
/*13*/			'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)/',
/*14*/			'/\d{4}/'
			);
		
			$matches = array();
				
			for($i=0;$i<count($regexes);$i++){
				if(preg_match_all($regexes[$i], $noticia, $matches)){
					$j=0;
					foreach($matches as $match){
						if ($matches[0][$j] != ''){
							echo ($i+1).' Found '.$matches[0][$j++];
 	      					echo '<br>';
						}
					}					
				}
			}
			
		}
		
    }

$noticia = new Noticia(); 
$noticia->setIdnoticia(32); 
$dao = new DAO();
$dao->connect();
$sql = "DELETE FROM noticia_locais ";
$rs = $dao->db->Execute($sql) or die($dao->db->ErrorMsg());
$dao->disconnect(); 
$noticia->setTexto(file_get_contents("./exemploNoticia.html")); 
ParserNoticias::parseNoticia($noticia);      
?>
