<?php

 
/*
 * Created on Mar 10, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 /**
  * Classe que representa a rela‹o Noticias Locais
  * 
  */
  class NoticiasLocais{
  
	/**
	 * Insere na bd uma reala‹o entre uma noticia e um local
	 * @param $idnoticia O id da  noticia a inserir
	 * @param $idlocal O id local a inserir
	 */
	public static function insertById($idnoticia, $idlocal){
		$dao = new DAO(); 
		$dao->connect(); 
		
		$hashInsert["idnoticia"] = $idnoticia;
		$hashInsert["idlocal"] = $idlocal;

		$result = $dao->AutoExecute("noticia_locais", $hashInsert, "INSERT");
		
		if (!$result){
			die ($dao->db->ErrorMsg()); 
		}
		$dao->disconnect(); 
	}  	
	
	/**
	 * Insere na bd uma reala‹o entre uma noticia e um local
	 * @param $idnoticia A noticia a inserir
	 * @param $idlocal O local a inserir
	 */
	public static function insertByObject($noticia, $local){
		return NoticiasLocais::insertById($noticia->getIdnoticia(), $local->getIdlocal());
		
	}
  }
?>
