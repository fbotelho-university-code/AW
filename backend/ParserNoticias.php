<?php
/**
 * Classe para fazer parsing ao texto da noticia.
 * TODO - meter este c‚Äîdigo na pr‚Äîpria classe Noticia 
 */
 
 include ('./classes/Noticia.php'); 
 include ('./classes/Local.php');
 include ('./classes/Lexico.php'); 
 include ('./classes/LexicoClubes.php'); 
 include ('./classes/NoticiasClubes.php');  
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
    	 * Efectua mudanÔøΩas directamente na base de dados relativa ÀÜ noticia  
    	 */
		public static function parseNoticia($noticia){
			//lexico de futebol
			//Clubes/integrantes
			//referencias espacial
			$noticia->save();
			
			//TODO - criar relação Noticia/Locais 
			//	ParserNoticias::findLocais($noticia);
			
			ParserNoticias::findClubes($noticia); 
			//referencias temporal 
		}
		
		private static function findLocais($noticia){
<<<<<<< HEAD
			//TODO - ir buscar isto de cada vez ≈Ω um bocado desperdicio. 
			$locais = Local::getAll();
			
=======
			//TODO - ir buscar isto de cada vez é um bocado desperdicio de computação 
			$locais = Local::getAll();			
>>>>>>> origin/master
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
<<<<<<< HEAD
					//TODO - lexico poderia estar associado a mais que um clube !  
					//Assumindo que s‚Äî vai ser associado a um: 
					$lexClubes = LexicoClubes::find(array("idlexico" => $lexico->getIdlexico()));
					
					//relaÔøΩ‚Äπo entre noticiaEClubes
					$rel = NoticiasClubes::find(array("idnoticia" => $noticia->getIdnoticia(), "idclube" => $lexicoClubes->getIdClube())); 
					if (!$rel){
						//$rel = new NoticiasClubes($noticia->getIdnoticia(), $); 
					}
					//$rel->addQualificacao($lexico->getPol()){
=======
					//TODO - lexico poderia estar associado a mais que um clube !
					//TODO - lexico pode nao estar associado a nenhum clube   
					//Assumindo que só vai ser associado a um: 
					$lexClubes = LexicoClubes::find(array("idlexico" => $lexico->getIdlexico()));
					if (count(lexClubes) > 0){
						$lexClube = $lexClubes[0]; 
						var_dump($lexClube); 
						//relação entre noticiaEClubes
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
>>>>>>> origin/master
					}
				}
			}
		}
		
<<<<<<< HEAD
		//private static function findIntegrantes($noticia){
				
		//} 
		
		//private static function findTemporal($noticia){
			
		//}
=======
			
		private static function findIntegrantes($noticia){
		
		} 
		
		private static function findTemporal($noticia){
		
		}
>>>>>>> origin/master
		
    //}

$dao = new DAO(); 
$dao->connect(); 
$dao->execute("truncate table noticia"); 
$noticia = new Noticia();

$noticia->setIdnoticia(32);
$noticia->setIdfonte(1); 
$noticia->setTexto(file_get_contents("./exemploNoticia.html")); 
ParserNoticias::parseNoticia($noticia);      
?>
