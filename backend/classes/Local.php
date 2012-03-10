<?php



/**
* Classe que representa um local. Pode ser um Distrito, Ilha ou Concelho de Portugal
* @author Anderson Barretto - Nr 42541
* @author Fábio Botelho 	 - Nr 41625
* @author José Lopes		 - Nr 42437
* @author Nuno Marques		 - Nr 42809
* @package backend.classes
* @version 1.0 20120305
*/
class Local {
	/**
	 * Criar instancia Local a partir de um array Associativo
	 * @param $map O array associativo com todos os campos de local 
	 * @return O Objecto local correspondente 
	 */
	 
	public static function fromHash( $map){
		$l = new Local(); 
		$l->setIdlocal($map["idlocal"]);
		$l->setNome_local($map["nome_local"]); 
		$l->setCoordenadas($map["coordenadas"]);
		return $l;   	
	}
	
	/**
	* Identificador do local
	* @var int
	*/
	private $idlocal;
	
	/**
	* Nome do local
	* @var String
	*/
	private $nome_local;
	
	/**
	* Coordenadas do local
	* @var String
	*/
	private $coordenadas;
	
	/**
	* Contrutor da classe.
	*/
	public function __contruct() {}
	
	/**
	* Retorna o identificador do local
	* @return int {@link $idlocal}
	*/
	public function getIdlocal() {
		return $this->idlocal;
	}
	
	/**
	* Altera o valor do identificador do local {@link $idlocal}
	* @param int $id
	*/
	public function setIdlocal($id) {
		$this->idlocal = $id;
	}
	
	/**
	* Retorna o nome do local
	* @return String {@link $nome_local}
	*/
	public function getNome_local() {
		return $this->nome_local;
	}
	
	/**
	* Altera o valor do nome do local {@link $nome_local}
	* @param String $n
	*/
	public function setNome_local($n) {
		$this->nome_local = $n;
	}
	
	/**
	* Retorna as coordenadas do local no formato lat;long
	* @return String {@link $coordenadas}
	*/
	public function getCoordenadas() {
		return $this->coordenadas;
	}
	
	/**
	* Altera o valor das coordenadas do local {@link $coordenadas}
	* @param String $c
	*/
	public function setCoordenadas($c) {
		$this->coordenadas = $c;
	}
	
	
	public function __toString(){
		$str = 'Local - ';
		if ($this->idlocal) $str .=  ' IdLocal : ' . $this->idlocal;  
		if ($this->nome_local) $str .= ' Nome : ' . $this->nome_local;  
		if ($this->coordenadas) $str .= ' Coordenadas : ' . $this->coordenadas;
		return $str; 
	}
	
	/**
	* Insere um local na Base de Dados
	* @param Array $fields Array com os locais recolhidos da fonte de informação Geo-Net-PT
	* 					   O parâmetro deve ser uma array associativo, onde  as chaves devem 
	*                      representar o nome de todas as coluna da tabela 'local' e o valor 
	*                      associado a chave deve ser o valor a ser inserido na tabela.
	* @return String $msg Mensagem sobre a execução da operação
	*/
	public function insert($fields) {
		
		/** Mesnagem de Retorno **/
		$msg = "";
		
		/** Conexão com a Base de Dados **/
		$dao = new DAO();
		$dao->connect();
		
		//Apaga todas as noticias da fonte de informação
		$sql = "TRUNCATE TABLE local";
		$rs = $dao->db->Execute($sql) or die($dao->db->ErrorMsg());
		
		//Insere todos os locais
		foreach ($fields as $local) {
			$rs = $dao->db->AutoExecute("local", $local, "INSERT") or die($dao->db->ErrorMsg());
			if(!$rs) {
				$msg = "Erro na inserção de local<br>";
			}
		}
		$dao->disconnect();
		$msg = "Foram inseridos ".count($fields)." locais.";
		return $msg;
	}
	
	/**
	 * Consultar lista de todos os locais existentes
	 * @return Um array de objectos Local
	 */
	 
	public static function getAll(){
		$dao = new DAO(); 
		$dao->connect(); 
		
		$sql = "SELECT  * FROM local"; 
		$rs = $dao->db->execute($sql);
		
		if (!$rs){
		   die ($dao->db->ErrorMsg()); 
		}
		
		$locais = array(); // array de locais para retornar
		
		while (!$rs->EOF){
				$locais[] = Local::fromHash($rs->fields);
				$rs->MoveNext();
		}
		
		$rs->Close(); 
		$dao->disconnect();
		return $locais;
	}
}
/*
$l= new Local();
$rs = $l->getAll(); 

foreach($rs as $ll){
	echo $ll . '<br/>'; 
}
*/
?>