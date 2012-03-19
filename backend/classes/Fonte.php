<?php



/**
* Classe que representa uma fonte de informações da Web
*  (Google News, Sapo News, Twitter, etc.)
* @author Anderson Barretto - Nr 42541
* @author Fábio Botelho 	 - Nr 41625
* @author José Lopes		 - Nr 42437
* @author Nuno Marques		 - Nr 42809
* @package backend.classes
* @version 1.0 20120305
*/

abstract class Fonte {
	
	/**
	* Identificador da fonte
	* @var int
	*/
	var $idfonte;
	
	/**
	* Nome da fonte
	* @var String
	*/
	var $nome;
	
	/**
	* URL principal da fonte
	* @var String
	*/
	var $main_url;
	
	/**
	* Visibilidade das notícias recolhidas da fonte
	* @var boolean
	*/
	var $ligado;
	
	/**
	 * Contrutor da classe. Inicializa os atributos da classe.
	 * @param int $id Identificador da fonte
	 * @param String $n Nome da fonte
	 * @param String $u URL principal da fonte
	 */
	public function __construct($n) {
		parent::__construct(); 
		$this->nome = $n;
		$this->retrieveFonte();
	}
	
	/**
	* Retorna o identificador da fonte
	* @return int {@link $idfonte}
	*/
	public function getIdfonte() {
		return $this->idfonte;
	}
	
	/**
	 * Pesquisa por uma determina express‹o  na fonte determinada. 
	 * @param search_str A express‹o a pesquisa
	 * @return Um array de objectos Noticia criados pela pesquisa.  
	 */
	abstract public function search($search_str);
	 
	/**
	* Recupera o valor do identificador da fonte {@link $idfonte} da base de dados
	* @uses {@link $main_url} Usa a URL principal da fonte para busca na base de dados
	*/
	public function setIdfonte() {
		$dao = new DAO();
		$dao->connect();
		$sql = "SELECT idfonte FROM fonte WHERE main_url = '".$this->main_url."'";
		$rs = $dao->db->Execute($sql) or die($dao->db->ErrorMsg());
		if(count($rs->fields) == 1) {
			$this->idfonte = $rs->fields["idfonte"];
		}
		else {
			die("Erro ao buscar identificador da fonte de informa�ao!");
		}
	}
	
	/**
	* Retorna o nome da fonte
	* @return String {@link $nome}
	*/
	public function getNome() {
		return $this->nome;
	}
	
	/**
	* Altera o valor do nome da fonte {@link $nome}
	* @param String $n Novo nome da fonte
	*/
	public function setNome($n) {
		$this->nome = $n;
	}
	
	/**
	* Retorna a URL principal da fonte
	* @return String {@link $url}
	*/
	public function getMain_url() {
		return $this->main_url;
	}
	
	/**
	* Altera o valor da URL principal da fonte {@link $main_url}
	* @param String $u Nova URL da fonte
	*/
	public function setMain_url($u) {
		$this->main_url = $u;
	}
	
	/**
	 * Recupera fonte cadastrada no BD usando o nome da fonte.
	 * Altera os atributos do objeto de acordo com a base de dados
	 * @uses {@link $idfonte}
	 * @uses {@link $main_url}
	 */
	public function retrieveFonte() {
		$sql = "SELECT * FROM fonte WHERE nome = '".$this->nome."'";
		$dao = new DAO();
		$rs = $dao->execute($sql);
		$this->mountFonte($rs->fields);
	}
	
	/**
	 * Monta um objeto integrante com resposta de consulta à base de dados
	 */
	private function mountFonte($fields) {
		$this->idfonte = $fields["idfonte"];
		$this->nome = $fields["nome"];
		$this->main_url = $fields["main_url"];
		$this->ligado = $fields["ligado"];
	}
}

?>