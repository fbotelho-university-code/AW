<?php
@header('Content-Type: text/html; charset=utf-8'); 
require_once('lib/HttpClient.php');
require_once "includes.php";
 
/**
* Classe para fazer parsing ao texto da noticia.
* Busca referencias temporais, espaciais e relacionamento com clubes e integrantes
*/
class ParserNoticias {
	var $l ;
	var $Lexico;
	var $locais; 
	var $lexicos; 
	
	public function parseSeveral($noticias){
		try{
			$this->l = new Local(); 
			$this->Lexico = new Lexico(); 
			$this->locais = $this->l->getAll(); 
			$this->lexicos = $this->Lexico->getAll();
		}catch(Exception $e){
			return ; 
		}
		$i = 0; 
		foreach ($noticias as $n){
			if ( $this->parseNoticia($n) == true ){
				$i++; 
			}
		}
		return $i; 
	}
	/**
    	 * Efectua parsing de noticias
    	 * Efectua mudanças directamente na base de dados relativa ˆ noticia  
    	 */
		public  function parseNoticia($noticia){
			$n = new Noticia(); 
			$noticia->descricao = strip_tags($noticia->descricao); 
			$noticia->assunto = strip_tags($noticia->assunto);
			$r = $n->findFirst(array("url" => $noticia->url)); 
			if (!isset($r)){
				//echo '<br/> Tenho uma noticia nova <br/>'; 
				$texto = getUrlContent($noticia->url);
				//echo '<br/> Texto: <br/>' . strlen($texto); 
				if (isset($texto)){
					$noticia->texto = $texto; 
				}else{
					//No texto to analyse. 
					return; 
				}
		     	//Armazenamento da noticia na Base de Dados

				$idnoticia = $noticia->add();

				$noticia->setIdnoticia($idnoticia);
				// Caracterização Semântica da Notícia
				ParserNoticias::findRefEspacial($noticia);
		    	ParserNoticias::findRefTemporal($noticia); 
				ParserNoticias::findRefClubesAndIntegrantes($noticia);
				return true; 
			}else{
				//echo '<br/>Url repetido : ' . $noticia->url . '<br/>'; 
			}
		}
		
		private  function findRefEspacial($noticia){
			$l = new Local();
			
			$textoNoticia = $noticia->getTexto();
			foreach ($this->locais as $local){
				$nome_local = ' ' . $local->getNome_local() . ' ';   // para encontrar palavra exacta e nao no meio de outra palavra 
				$pos = stripos($textoNoticia , $nome_local);
				if ($pos !== false){
					$n_l = new Noticia_locais();
					$n_l->setIdnoticia($noticia->getIdNoticia());
					$n_l->setIdlocal($local->getIdlocal());
					try{
						$n_l->add();
					}catch(Exception $e){
						continue; 
					}
				} 
			}
		}
				 	 
		private  function findRefClubesAndIntegrantes($noticia){
			$Lexico = new Lexico();
			$Clubes_Lexico = new Clubes_Lexico();
			$Noticias_Clube = new Noticia_Has_Clube(); 
			$Integrantes_Lexico = new Integrantes_Lexico(); 
            $Noticia_Integrante = new Noticia_Has_Integrante(); 
			$textoNoticia = $noticia->getTexto();
        	$integrantes_inseridos[] = array(); 
        	$clubes_inseridos[] = array();
        	
        	try{
        	$int = new Integrante(); 
        	$id = $int->findFirst(array("nome_integrante" => $noticia->about));
        	if (isset($id)){ 
        		$id = $id->idintegrante;
        		$Noticia_Integrante->idnoticia = $noticia->idnoticia; 
        		$Noticia_Integrante->idintegrante = $id;
        		$Noticia_Integrante->idlexico =0;
        		$Noticia_Integrante->qualificacao = 0; 
        		$Noticia_Integrante->add();  
        	}
        	else{
        		$id = $int->findFirst(array("nome_oficial" => $noticia->about));
        		if (isset($id)){
        			$id = $id->idclube;
        			$Noticias_Clube->idnoticia = $noticia->$idnoticia;
        			$Noticias_Clube->idclube = $id;
        			$Noticias_Clube->idlexico = 0;
        			$Noticias_Clube->qualificacao = 0;
        			$Noticias_Clube->add();
        		}	
        	}
        	}catch(Exception $e){
        		; 
        	}
        	
			foreach($this->lexicos as $lexico){
				//echo '<br/> Looking for this lexico : ' . $lexico->getContexto() ;
				$pos = stripos($textoNoticia, " " . $lexico->getContexto() . " ");
				if ($pos !== false){
					//echo '<br/> Found it in the news <br/>';
					//Find the clube associated with lexico. 
					//TODO - lexico poderia estar associado a mais que um clube !  
					//Assumindo que s— vai ser associado a um:
					$lexClubes = $Clubes_Lexico->findFirst(array("idlexico" => $lexico->getIdlexico()));
					if ($lexClubes){
						//echo '<br/> Lexico pertence a clubes <br/>';
						//relação entre noticiaEClubes
						$rel = $Noticias_Clube->findFirst(array("idnoticia" => $noticia->getIdnoticia(), "idclube" => $lexClubes->getIdClube()));
						if (!$rel){
							$rel = new Noticia_Has_Clube($noticia->getIdnoticia(), $lexClubes->getIdClube(), 0 , $lexico->getIdLexico());
							try{
							$rel->add();
							}catch(Exception $e){
								continue; 
							}  
						}
						$rel->addQualificacao($lexico->getPol());
						$rel->update();
					//echo 'phase 1 <br/>';  
					}
					$lexIntegrantes = $Integrantes_Lexico->findFirst(array ("idlexico" => $lexico->getIdlexico()));
                  if ($lexIntegrantes){
                  		//echo '<br/> Lexico pertence a integrantes <br/>'; 
                  	//echo 'going to find first ' . $lexIntegrantes->getIdIntegrante() .'<br/>'; 
                     $rel = $Noticia_Integrante->findFirst(array ("idnoticia" => $noticia->getIdnoticia(), "idintegrante" => $lexIntegrantes->getIdIntegrante())); 
                     if (!$rel){
    	                 //	echo 'going to create relation <br/>'; 
                          $rel = new Noticia_Has_Integrante($noticia->getIdnoticia(), $lexIntegrantes->getIdIntegrante(), 0 ,$lexico->getIdLexico()); 
                          //echo '<br/> aqui <br/>';
	                      //   echo 'Printing id ' . $rel->getIdNoticia();
	                      try{  
                          	$rel->add();
	                      }catch(Exception $e){
	                      	continue; 
	                      } 
                         // echo '<br/> done <br/>';
                      }
                      $rel->addQualificacao($lexico->getPol()); 
                      $rel->update(); 
                   }
				}
			}
		}
		
		private  function findRefTemporal($noticia){
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
			$rel  = new Noticia_Data($noticia->getIdnoticia(), $noticia->getData_pub(), $noticia->getData_pub());
			$rel->add();
				
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
										$dataInterpretada = trim($dataInterpretada[2])."-".BackUtil::$mesesFull[trim($dataInterpretada[1])]."-".trim($dataInterpretada[0]);
									}
									else {
										$dataInterpretada = $dataInterpretada[0]."-".$dataInterpretada[1]."-00";
									}
									break;
							}
							$testearray = $rel->find(array('idnoticia'=>$noticia->getIdnoticia(),'tempo'=> $dataInterpretada));
							if(!count($testearray)){							
								//echo $dataInterpretada."<br>";
								$rel  = new Noticia_Data($noticia->getIdnoticia(), $dates[$j], $dataInterpretada);
								try{
									$rel->add();
								}catch(Exception $e) {
									continue; 
								}
							}
						}
					}	
				}
			}
			$noticiaData = new Noticia_Data();
			try{
			$badDates = $noticiaData->delete(array("data_interpretada" => "0000-00-00"));
			}catch(Exception $e){
				continue; 
			}
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
