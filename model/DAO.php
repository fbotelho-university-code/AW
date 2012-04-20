<?php
@header('Content-Type: text/html; charset=utf-8');
include ("adodb/adodb.inc.php");

/**
 * Classe que representa uma abstracao para acesso a base de dados.
 * Usada com superclasse de todas as classes do Modelo
 */
class DAO extends ADOConnection {
	
	/**
	 * SGBD utilizado pela aplicacao
	 * @var String
	 */
	private $mysgbd = "mysql";
	
	/**
	 * Nome ou IP do servidor na qual encontra-se instalada a Base de Dados
	 * @var String
	 */
	private $myserver = "localhost";
	
	/**
	 * Nome do usuario para acesso � Base de Dados
	 * @var String
	 */
	private $myuser = "root";
	
	/**
	 * 
	 * Palavra-passe para acesso � Base de Dados
	 * @var String
	 */
	 
	private $mypassword = "pcdamf06";
		
	/**
	 * Nome da Base de Dados a ser utilizada
	 * @var String
	 */
	private $mydbName = "aw";
	
	/**
	 * Objeto para acesso � Base de Dados
	 * @var ADONewConnection
	 */
	public $db;
	
 	
	/**
	 * Construtor da Classe
	 * Configura o SGBD a ser utilizado
	 * @uses {@link $mysgbd}
	 */
	function __construct(){
		$this->db = &ADONewConnection($this->mysgbd);
		/* Ativa Associa��o dos nomes das colunas das tabelas da BD com as chaves dos arrays de retorno de consulta */
		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
	}
	
	/**
	 * Conecta com a base de dados
	 * Usa os atributos da classe para estabelecar uma liga��o com o SGBD
	 */
	 
	function connect() {
		$this->db->Connect($this->myserver, $this->myuser, $this->mypassword, $this->mydbName) or die($this->db->ErrorMsg());
	  	
	}
	
	/**
	 * Disconecta com a base de dados
	 */
	function disconnect() {
		$this->db->Close();
	}
	
	private function throwException($string){
		throw new Exception($string); 
	}
	 
	function execute($sql) {
		$this->connect();

		$rs = $this->db->Execute($sql) or $this->throwException($this->db->ErrorMsg() . "<br> CENAS SQL: ".$sql); 

		$this->disconnect();
		return $rs;
	}
}