<?php
/**
 * Classe para fazer parsing ao texto da noticia.
 * TODO - meter este c�digo na pr�pria classe Noticia 
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
    	 * Efectua mudan�as directamente na base de dados relativa � noticia  
    	 */
		public static function parseNoticia($noticia){
			//lexico de futebol
			//Clubes/integrantes
			//referencias espacial
			ParserNoticias::findLocais($noticia); 
			//referencias temporal 
		}
		
		private static function findLocais($noticia){
			//TODO - ir buscar isto de cada vez � um bocado desperdicio. 
			$locais = Local::getAll();
			
			$textoNoticia = $noticia->getTexto();
			 
			foreach ($locais as $local){
				$nome_local = ' ' . $local->getNome_local() . ' ';   // para encontrar palavra exacta e nao no meio de outra palavra 
				$pos = stripos($textoNoticia , $local->getNome_local());
				if ($pos != false){
					NoticiasLocais::insertByObject($noticia, $local);
					
				} 
			}
		} 	
		
		
		private static function findClubes($noticia){
			
		}
			
		private static function findIntegrantes($noticia){
				
		} 
		
		private static function findTemporal($noticia){
			
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
