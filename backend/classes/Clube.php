<?php

/**
* Classe que representa um clube de futebol
*  Ex: Benfica, Porto, Sporting, etc.
* @author Anderson Barretto - Nr 42541
* @author Fсbio Botelho 	 - Nr 41625
* @author Josщ Lopes		 - Nr 42437
* @author Nuno Marques		 - Nr 42809
* @package backend.classes
* @version 1.0 20120309
*/

class Clube {
	
	/**
	* Identificador do clube
	* @var int
	*/
	private $idclube;
	
	/**
	 * Identificador do local do clube
	 * @var int
	 */
	private $idlocal;
	
	/**
	 * Identificador da competiчуo que o clube participa
	 * @var int
	 */
	private $idcompeticao;
	
	/**
	 * Nome do clube
	 * @var String
	 */
	private $nome_clube;
	
	/**
	 * Construtor da classe. Inicializa o nome do clube {@link $nome_clube}
	 * @param String $n
	 */	
	public function __construct($n ='') {
		if ($n != '' ){
			$this->nome_clube = $n;
			$this->getClubeByNome();
		}
	}
	
	/**
	* Retorna o identificador do clube
	* @return int {@link $idclube}
	*/
	public function getIdclube() {
		return $this->idclube;
	}
	
	/**
	* Altera o valor do identificador do clube {@link $idclube}
	* @param int $id
	*/
	public function setIdclube($id) {
		$dao = new DAO();
		$dao->connect();
		$sql = "SELECT idclube FROM clube WHERE nome_clube = '".$this->nome__clube."'";
		$rs = $dao->db->Execute($sql) or die($dao->db->ErrorMsg());
		if(count($rs->fields) == 1) {
			$this->idclube = $rs->fields["idclube"];
		}
		else {
			die("Erro ao buscar identificador do clube!");
		}
	}
	
	/**
	 * Altera valor do id do clube
	 * TODO - check this with anderson 
	 */
	public function setId($id){
		$this->idclube = $id; 
	}
	
	/**
	* Retorna o identificador do local do clube
	* @return int {@link $idlocal}
	*/
	public function getIdlocal() {
		return $this->idlocal;
	}
	
	/**
	* Altera o valor do identificador do local do clube {@link $idlocal}
	* @param int $id
	*/
	public function setIdlocal($id) {
		$this->idlocal = $id;
	}
	
	/**
	* Retorna o identificador da competicao do clube
	* @return int {@link $idcompeticao}
	*/
	public function getIdcompeticao() {
		return $this->idcompeticao;
	}
	
	/**
	* Altera o valor do identificador da competicao do clube{@link $idcompeticao}
	* @param int $id
	*/
	public function setIdcompeticao($id) {
		$this->idcompeticao = $id;
	}
	
	/**
	* Retorna o nome do clube
	* @return String {@link $nome_competicao}
	*/
	public function getNome_clube() {
		return $this->nome_clube;
	}
	
	/**
	* Altera o valor do nome do clube {@link $nome_competicao}
	* @param String $n
	*/
	public function setNome_clube($n) {
		$this->nome_clube = $n;
	}
	
	/**
	 * Get all Clubes from the database. 
	 * @returns An array of objects Clubes. 
	 */
	public static function getAll(){
		$dao = new DAO(); 
		$dao->connect(); 
		
		$sql = "SELECT  * FROM clube; ";

		//TODO - does not dies ? 
		$rs = $dao->db->execute($sql);
		if (!$rs){
			//echo 'ERROR'; 
		   die ($dao->db->ErrorMsg()); 
		}
		
		$clubes = array(); // array de locais para retornar
		
		while (!$rs->EOF){
			$clubes[] = Clube::fromHash($rs->fields);
			$rs->MoveNext();
		}
		
		$rs->Close(); 
		$dao->disconnect();
		return $clubes;		
	}
	
	
	/**
	 *   
	 */
	public static function fromhash($clube){
		$c = new Clube(); 
		$c->setId($clube["idclube"]);
		$c->setIdLocal($clube["idlocal"]); 
		$c->setIdcompeticao($clube["idcompeticao"]);
		$c->setNome_clube($clube["nome_clube"]);
		return $c; 
	}
	
	/**
	* Recupera o todos os atributos do clube usando seu nome
	*/
	public function getClubeByNome($nome){
		$dao = new DAO();
		$dao->connect();
		$sql = "SELECT idclube FROM clube WHERE nome_clube = '".$this->main_url."'";
		$rs = $dao->db->Execute($sql) or die($dao->db->ErrorMsg());
		if(count($rs->fields) == 1) {
			$this->idfonte = $rs->fields["idfonte"];
		}
		else {
			die("Erro ao buscar identificador da fonte de informaчуo!");
		}
	}
	public function __toString(){
		$str = 'Clube - '; 
		if ($this->nome_clube ) $str .= ' Nome : ' . $this->nome_clube; 
		if ($this->idclube ) $str .= ' ID Clube : ' . $this->idclube; 
		if ($this->idlocal ) $str .= ' ID local : ' . $this->idlocal; 
		if ($this->idcompeticao ) $str .= ' ID competicao: ' . $this->idcompeticao; 
	    return $str; 
	}
}

?>