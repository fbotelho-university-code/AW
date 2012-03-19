<?php
/**
 * Classe para fazer parsing ao texto da noticia.
 * TODO - meter este c‚Äîdigo na pr‚Äîpria classe Noticia 
 */
 
 require_once ('./classes/Noticia.php'); 
 require_once ('./classes/Local.php');
 require_once ('./classes/Lexico.php'); 
 require_once ('./classes/Clubes_Lexico.php'); 
 require_once ('./classes/Noticia_Has_Clube.php');  
 require_once ('./classes/Noticia_locais.php'); 
 require_once ("./adodb/adodb.inc.php");
 require_once ("./classes/DAO.php");


/*
 * Created on Mar 10, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

	
    class ParserNoticias {
    	/**
    	 * Efectua parsing de noticias
    	 * Efectua mudanÔøΩas directamente na base de dados relativa ÀÜ noticia  
    	 */
		public static function parseNoticia($noticia){
			//lexico de futebol
			//Clubes/integrantes
			//referencias espacial
			$idnoticia = $noticia->add();
			$noticia->setIdnoticia($idnoticia);
			//ParserNoticias::findLocais($noticia);
			//TODO - criar relaÔøΩÔøΩo Noticia/Locais 
			//	ParserNoticias::findLocais($noticia);
			
			ParserNoticias::findClubes($noticia); 
			//referencias temporal 
		}
		
		private static function findLocais($noticia){
			$l = new Local();
			$locais = $l->getAll(); // TODO  tirar getAll daqui. Tirar classe estática. 
			$textoNoticia = $noticia->getTexto();
			foreach ($locais as $local){
				$nome_local = ' ' . $local->getNome_local() . ' ';   // para encontrar palavra exacta e nao no meio de outra palavra 
				$pos = stripos($textoNoticia , $nome_local);
				if ($pos !== false){
					$n_l = new Noticia_locais();
					$n_l->setIdnoticia($noticia->getIdNoticia());
					$n_l->setIdlocal($local->getIdlocal());
					$n_l->add();
				} 
			}
		}
		 	
		private static function findClubes($noticia){
			$Lexico = new Lexico();
			$Clubes_Lexico = new Clubes_Lexico(); 
			$Noticias_Clube = new Noticia_Has_Clube(); 
			 
			$textoNoticia = $noticia->getTexto(); 
			$lexicos = $Lexico->getAll();
			
			foreach($lexicos as $lexico){
				$pos = stripos($textoNoticia, " " . $lexico->getContexto() . " ");
				if ($pos !== false){
					//Find the clube associated with lexico. 
					//TODO - lexico poderia estar associado a mais que um clube !  
					//Assumindo que s‚Äî vai ser associado a um: 
					echo '<br/> Found : ' . $lexico->getContexto(); 
					$lexClubes = $Clubes_Lexico->findFirst(array("idlexico" => $lexico->getIdlexico()));
					echo '<br/> ';
					 
					var_dump($lexClubes); 
					echo '<br/>'; 
					//TODO - e se nao houver 
					
					if ($lexClubes){					
						//relação entre noticiaEClubes
						$rel = $Noticias_Clube->findFirst(array("idnoticia" => $noticia->getIdnoticia(), "idclube" => $lexClubes->getIdClube()));

						if (!$rel){
							$rel = new Noticia_Has_Clube($noticia->getIdnoticia(), $lexClubes->getIdClube());
							echo '<br/> AQUI: '; 
							var_dump($rel); 
							$rel->add();  
							echo 'after';  
						}
						$rel->addQualificacao($lexico->getPol());
						//echo 'aqui';  
						$rel->update();
						//echo 'done';  
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

$dao = new DAO(); 
$dao->connect(); 
$dao->execute("truncate table noticia");
$dao->execute("truncate table noticia_has_clube");  
$noticia = new Noticia();


$noticia->setIdfonte(1); 
$noticia->setTexto(file_get_contents("./exemploNoticia.html")); 
ParserNoticias::parseNoticia($noticia);      
?>
