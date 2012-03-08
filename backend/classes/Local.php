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
	
	/**
	* Insere um local na Base de Dados
	* @param Array $fields Array com os locais recolhidos da fonte de informação Geo-Net-PT
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
			if($rs) {
				//echo "Local \"<b>".$local["nome_local"]."</b>\" inserido com sucesso!<br>";
			}
			else {
				$msg = "Erro na inserção de local<br>";
			}
		}
		$dao->disconnect();
		$msg = "Foram inseridos ".count($fields)." locais.";
		return $msg;
	}
	
}


?>