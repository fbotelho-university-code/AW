<?php
/**
 * Classe para fazer parsing ao texto da noticia.
 * TODO - meter este c—digo na pr—pria classe Noticia 
 */
 
require_once "includes.php";
 
/*
 * Created on Mar 10, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


    class ParserNoticias {
    	/**
    	 * Efectua parsing de noticias
    	 * Efectua mudan�as directamente na base de dados relativa ˆ noticia  
    	 */
		public static function parseNoticia($noticia){
			//lexico de futebol
			//Clubes/integrantes
			//referencias espacial
			$idnoticia = $noticia->add();
			$noticia->setIdnoticia($idnoticia);
			//ParserNoticias::findLocais($noticia);	//OK
			//TODO - criar rela��o Noticia/Locais 
			//	ParserNoticias::findLocais($noticia);
			
			ParserNoticias::findClubes($noticia); 
			//referencias temporal 
		}
		
		private static function findLocais($noticia){
			$l = new Local();
			$locais = $l->getAll(); // TODO  tirar getAll daqui. Tirar classe est�tica. 
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
			$Integrantes_Lexico = new Integrantes_Lexico(); 
            $Noticia_Integrante = new Noticia_Has_Integrante(); 
			$textoNoticia = $noticia->getTexto(); 
                        
			$lexicos = $Lexico->getAll();
			                        
			foreach($lexicos as $lexico){
				$pos = stripos($textoNoticia, " " . $lexico->getContexto() . " ");
				if ($pos !== false){
					//Find the clube associated with lexico. 
					//TODO - lexico poderia estar associado a mais que um clube !  
					//Assumindo que s— vai ser associado a um: 
					$lexClubes = $Clubes_Lexico->findFirst(array("idlexico" => $lexico->getIdlexico()));
					$lexIntegrantes = $Integrantes_Lexico->findFirst(array ("idlexico" => $lexico->getIdlexico())); 
					if ($lexClubes){					
						//rela��o entre noticiaEClubes
						$rel = $Noticias_Clube->findFirst(array("idnoticia" => $noticia->getIdnoticia(), "idclube" => $lexClubes->getIdClube()));

						if (!$rel){
							$rel = new Noticia_Has_Clube($noticia->getIdnoticia(), $lexClubes->getIdClube());
							$rel->add();  
							
						}
						$rel->addQualificacao($lexico->getPol());
						$rel->update();
					echo 'phase 1 <br/>';  
					}
                  if ($lexIntegrantes){
                  	echo 'going to find first ' . $lexIntegrantes->getIdIntegrante() .'<br/>'; 
                     $rel = $Noticia_Integrante->findFirst(array ("idnoticia" => $noticia->getIdnoticia(), "idintegrante" => $lexIntegrantes->getIdIntegrante())); 
                     
                     if (!$rel){
                     	echo 'going to create relation <br/>'; 
                          $rel = new Noticia_Has_Integrante($noticia->getIdnoticia(), $lexIntegrantes->getIdIntegrante()); 
                          //echo '<br/> aqui <br/>';
                          echo 'Printing id ' . $rel->getIdNoticia();  

                          $rel->add(); 
                          //echo '<br/> done <br/>';
                      }
                      $rel->addQualificacao($lexico->getPol()); 
                      $rel->update(); 
                   }
				}
			}
		}
		
		private static function findTemporal($noticia){
					$regexes = array(
/*1*/			'/\d{1,2}((\ )*\/(\ )*|(\ )*\-(\ )*)\d{1,2}((\ )*\/(\ )*|(\ )*\-(\ )*)\d{2}/',
/*2*/			'/\d{1,2}(\/|\-)\d{1,2}(\/|\-)\d{4}/',
/*3*/			'/\d{4}(\/|\-)\d{1,2}(\/|\-)\d{1,2}/',
/*4*/			'/\d{1,2}(\/|\-)(Jan|Fev|Mar|Abr|Mai|Jun|Jul|Ago|Set|Out|Nov|Dez)(\/|\-)\d{2}/',
/*5*/			'/\d{1,2}(\/|\-)(Jan|Fev|Mar|Abr|Mai|Jun|Jul|Ago|Set|Out|Nov|Dez)(\/|\-)\d{4}/',
/*6*/			'/\d{4}(\/|\-)(Jan|Fev|Mar|Abr|Mai|Jun|Jul|Ago|Set|Out|Nov|Dez)(\/|\-)\d{1,2}/',
/*7*/			'/\d{1,2}(\ de\ |,\ ){0,1}(Janeiro|Fevereiro|Mar�o|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)(\ de\ |,\ ){0,1}\d{2}/',
/*8*/			'/\d{1,2}(\ de\ |,\ ){0,1}(Janeiro|Fevereiro|Mar�o|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)(\ de\ |,\ ){0,1}\d{4}/',
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
$noticia->setTexto(addslashes(file_get_contents("./exemploNoticia.html"))); 
ParserNoticias::parseNoticia($noticia);      
?>
