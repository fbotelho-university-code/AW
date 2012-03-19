<?php
/**
 * Classe para fazer parsing ao texto da noticia.
 * TODO - meter este c‚Äîdigo na pr‚Äîpria classe Noticia 
 */
 
 require_once ('./classes/Noticia.php'); 
 require_once ('./classes/Local.php');
 require_once ('./classes/Lexico.php'); 
 require_once ('./classes/LexicoClubes.php'); 
 require_once ('./classes/NoticiasClubes.php');  
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
			ParserNoticias::findLocais($noticia);
			//TODO - criar relaÔøΩÔøΩo Noticia/Locais 
			//	ParserNoticias::findLocais($noticia);
			
			//ParserNoticias::findClubes($noticia); 
			//referencias temporal 
		}
		
		private static function findLocais($noticia){

			$l = new Local();
			$locais = $l->getAll();
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
			$textoNoticia = $noticia->getTexto(); 
			$lexicos = Lexico::getAll();
			 
			foreach($lexicos as $lexico){
				$pos = stripos($textoNoticia, $lexico->getContexto());
				if ($pos !== false){
					//Find the clube associated with lexico. 

					//TODO - lexico poderia estar associado a mais que um clube !  
					//Assumindo que s‚Äî vai ser associado a um: 
					$lexClubes = LexicoClubes::find(array("idlexico" => $lexico->getIdlexico()));
					
					//relaÔøΩ‚Äπo entre noticiaEClubes
					$rel = NoticiasClubes::find(array("idnoticia" => $noticia->getIdnoticia(), "idclube" => $lexicoClubes->getIdClube())); 
					if (!$rel){
						//$rel = new NoticiasClubes($noticia->getIdnoticia(), $); 
					}
					//$rel->addQualificacao($lexico->getPol()){

					//TODO - lexico poderia estar associado a mais que um clube !
					//TODO - lexico pode nao estar associado a nenhum clube   
					//Assumindo que sÔøΩ vai ser associado a um: 
					$lexClubes = LexicoClubes::find(array("idlexico" => $lexico->getIdlexico()));
					if (count(lexClubes) > 0){
						$lexClube = $lexClubes[0]; 
						var_dump($lexClube); 
						//relaÔøΩÔøΩo entre noticiaEClubes
						$rel = NoticiasClubes::find(array("idnoticia" => $noticia->getIdnoticia(), "idclube" => $lexClube->getIdClube())); 
						var_dump($rel); 
						
						if (!$rel){
							$rel = new NoticiasClubes($noticia->getIdnoticia(), $lexClubes[0]->getIdClube());
							$rel->save();
							var_dump($rel);  
						}
						
						var_dump($rel); 
						
						$rel->addQualificacao($lexico->getPol());
						$rel->update(); 
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

/*$dao = new DAO(); 
$dao->connect(); 
$dao->execute("truncate table noticia"); 
$noticia = new Noticia();

$noticia->setIdnoticia(32);
$noticia->setIdfonte(1); 
$noticia->setTexto(file_get_contents("./exemploNoticia.html")); 
ParserNoticias::parseNoticia($noticia); */     
?>
