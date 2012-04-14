<?php
 
require_once "includes.php";
 
/**
* Classe para fazer parsing ao texto da noticia.
* Busca referencias temporais, espaciais e relacionamento com clubes e integrantes
*/

class ParserNoticias {
    	/**
    	 * Efectua parsing de noticias
    	 * Efectua mudan�as directamente na base de dados relativa ˆ noticia  
    	 */
		public static function parseNoticia($noticia){
	     	//Armazenamento da noticia na Base de Dados
			$idnoticia = $noticia->add();
			$noticia->setIdnoticia($idnoticia);
			
			// Caracterização Semântica da Notícia
			//ParserNoticias::findRefEspacial($noticia);
		    ParserNoticias::findRefTemporal($noticia); 
			//ParserNoticias::findRefClubesAndIntegrantes($noticia); 
		}
		
		private static function findRefEspacial($noticia){
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
				 	 
		private static function findRefClubesAndIntegrantes($noticia){
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
							$rel = new Noticia_Has_Clube($noticia->getIdnoticia(), $lexClubes->getIdClube(), 0 , $lexico->getIdLexico());
							$rel->add();  
						}
						$rel->addQualificacao($lexico->getPol());
						$rel->update();
					//echo 'phase 1 <br/>';  
					}
                  if ($lexIntegrantes){
                  	//echo 'going to find first ' . $lexIntegrantes->getIdIntegrante() .'<br/>'; 
                     $rel = $Noticia_Integrante->findFirst(array ("idnoticia" => $noticia->getIdnoticia(), "idintegrante" => $lexIntegrantes->getIdIntegrante())); 
                     
                     if (!$rel){
                     //	echo 'going to create relation <br/>'; 
                          $rel = new Noticia_Has_Integrante($noticia->getIdnoticia(), $lexIntegrantes->getIdIntegrante(), 0 ,$lexico->getIdLexico()); 
                          //echo '<br/> aqui <br/>';
                       //   echo 'Printing id ' . $rel->getIdNoticia();  

                          $rel->add(); 
                         // echo '<br/> done <br/>';
                      }
                      $rel->addQualificacao($lexico->getPol()); 
                      $rel->update(); 
                   }
				}
			}
		}
		
		private static function findRefTemporal($noticia){
				$texto = $noticia->getTexto(); 
				$regexes = array(
/*1*/			//'/\d{1,2}((\ )*\/(\ )*|(\ )*\-(\ )*)\d{1,2}((\ )*\/(\ )*|(\ )*\-(\ )*)\d{2}/',
/*2*/			'/\d{2}(\/)\d{1,2}(\/)\d{4}/',
/*3*/			'/\d{2}(\-)\d{1,2}(\-)\d{4}/',
				'/\d{4}(\/)\d{1,2}(\/)\d{2}/',
				'/\d{4}(\-)\d{1,2}(\-)\d{2}/',
/*4*/			//'/\d{1,2}(\/|\-)(Jan|Fev|Mar|Abr|Mai|Jun|Jul|Ago|Set|Out|Nov|Dez)(\/|\-)\d{2}/',
/*5*/			//'/\d{1,2}(\/|\-)(Jan|Fev|Mar|Abr|Mai|Jun|Jul|Ago|Set|Out|Nov|Dez)(\/|\-)\d{4}/',
/*6*/			//'/\d{4}(\/|\-)(Jan|Fev|Mar|Abr|Mai|Jun|Jul|Ago|Set|Out|Nov|Dez)(\/|\-)\d{1,2}/',
/*7*/			//'/\d{1,2}(\ de\ |,\ ){0,1}(Janeiro|Fevereiro|Mar�o|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)(\ de\ |,\ ){0,1}\d{2}/',
/*8*/			'/(\d{2}(\ de\ )){0,1}(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)(\ de\ )\d{4}/',
/*9*/			//'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)\ \d{1,2}(\ de\ |\ ){0,1}\d{2}/',
/*10*/			//'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)\ \d{2}(\ de\ )\d{4}/',
/*11*/			//'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)\ \d{1,2}/',
/*12*/			//'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)(\ de\ )\d{4}/',
/*13*/			//'/(Janeiro|Fevereiro|Março|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)/'
/*14*/			//'/\d{4}/'
			);
			
			// insere data da publicação na tabela data_noticia
				
			$matches = array();
			for($i=0;$i<count($regexes);$i++){
				if(preg_match_all($regexes[$i], $texto, $matches)){
					if ($matches[0][0] != ''){
						// retira valores duplicados no array, sem alterar as chaves originais
						$dates = array_unique($matches[0]);
						// reordena as chaves do array sem valores duplicados
						$dates = array_values($dates);
						$dataInterpretada = "";
						//criação e armazenamento dos objetos noticia_data
						for($j=0; $j<count($dates); $j++) {
							//echo $i." - ".$dates[$j]." - ";
							switch ($i) {
								case 0:
									$dataInterpretada = explode("/", $dates[$j]);
									$dataInterpretada = $dataInterpretada[2]."-".$dataInterpretada[1]."-".$dataInterpretada[0];
									break;
								case 1:
									$dataInterpretada = explode("-", $dates[$j]);
									$dataInterpretada = $dataInterpretada[2]."-".$dataInterpretada[1]."-".$dataInterpretada[0];
									break;
								case 2:
									$dataInterpretada = explode("/", $dates[$j]);
									$dataInterpretada = $dataInterpretada[0]."-".$dataInterpretada[1]."-".$dataInterpretada[2];
									break;
								case 3:
									$dataInterpretada = explode("-", $dates[$j]);
									$dataInterpretada = $dataInterpretada[0]."-".$dataInterpretada[1]."-".$dataInterpretada[2];
									break;
								case 4:
									$dataInterpretada = explode("de", $dates[$j]);
									if(count($dataInterpretada) == 3) {
										$dataInterpretada = trim($dataInterpretada[2])."-".Util::$mesesFull[trim($dataInterpretada[1])]."-".trim($dataInterpretada[0]);
									}
									else {
										$dataInterpretada = $dataInterpretada[0]."-".$dataInterpretada[1]."-00";
									}
									break;
							}
							//echo $dataInterpretada."<br>";
							$rel  = new Noticia_Data($noticia->getIdnoticia(), $dates[$j], $dataInterpretada);
							$rel->add();
						}
					}	
				}
			}
			$noticiaData = new Noticia_Data();
			$badDates = $noticiaData->delete(array("data_interpretada" => "0000-00-00"));
		}
}

/*
$dao = new DAO(); 
$dao->connect(); 
$dao->execute("truncate table noticia");
$dao->execute("truncate table noticia_has_clube"); 
$dao->execute("truncate table noticia_locais");
$dao->execute("truncate table noticia_has_integrante"); 
$noticia = new Noticia();
$noticia->setIdfonte(1); 
$noticia->setTexto(addslashes(file_get_contents("./exemploNoticia.html"))); 
ParserNoticias::parseNoticia($noticia);   
*/   

?>
