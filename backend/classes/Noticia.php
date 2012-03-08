<?php

ini_set('default_charset','UTF-8');

/**
 * Classe que representa uma notícia recuperada de fontes de informações da Web
 *  (Google News, Sapo News, Twitter, etc.)
 * @author Anderson Barretto - Nr 42541
 * @author Fábio Botelho 	 - Nr 41625
 * @author José Lopes		 - Nr 42437
 * @author Nuno Marques		 - Nr 42809
 * @package backend.classes
 * @version 1.0 20120305
 */ 
class Noticia {
	
	/**
	 * Identificador da noticia
	 * @var int
	 */
	private $idnoticia;
	
	/**
	 * Identificador da fonte da notícia
	 * @var int
	 */
	private $idfonte;
	
	/**
	 * Identificador de uma referencia local da notícia
	 * @var int
	 */
	private $idlocal;
	
	/**
	 * Data de publicação da notícia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	private $data_pub;
	
	/**
	 * Data presente no corpo da notícia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	private $data_noticia;
	
	/**
	 * Assunto da notícia
	 * @var String
	 */
	private $assunto;
	
	/**
	 * Breve resumo da mensagem
	 * @var String
	 */
	private $descricao;
	
	/**
	 * Texto completo da notícia
	 * @var String
	 */
	private $texto;
	
	/**
	 * URL contendo a íntegra da notícia
	 * @var String
	 */
	private $url;
	
	/**
	 * Define se uma notícia deve estar visível para o utilizador
	 * @var boolean
	 */
	private $visivel =1 ;
	
	/**
	 * Objeto para acesso à base de dados
	 * @var DAO
	 */
	private $db;
	
	/**
	 * Contrutor da classe. 
	 */
	public function __construct() {	}
	
	/**
	* Retorna o identificador da notícia
	* @return int {@link $idnoticia}
	*/
	public function getIdnoticia() {
		return $this->idnoticia;
	}
	
	/**
	 * Altera o valor do identificador da notícia {@link $idnoticia}
	 * @param int $id
	 */
	public function setIdnoticia($id) {
		$this->idnoticia = $id;
	}
	
	/**
	* Retorna o identificador da fonte da notícia
	* @return int {@link $idfonte}
	*/
	public function getIdfonte() {
		return $this->idfonte;
	}
	
	/**
	 * Altera o valor do identificador da fonte da notícia {@link $idfonte}
	 * @param int $id
	 */
	public function setIdfonte($id) {
		$this->idfonte = $id;
	}
	
	/**
	* Retorna o identificador da referencia espacial da notícia
	* @return int {@link $idlocal}
	*/
	public function getIdlocal() {
		return $this->idlocal;
	}
	
	/**
	 * Altera o valor do identificador da referencia espacial da notícia {@link $idlocal}
	 * @param int $id
	 */
	public function setIdlocal($id) {
		$this->idlocal = $id;
	}
	
	/**
	 * Retorna a data de publicação da notícia
	 * @return Date {@link $data_pub}
	 */
	public function getData_pub() {
		return $this->data_pub;
	}
	
	/**
	 * Altera o valor da data da notícia {@link $data_pub}
	 * @param Date $date
	 */
	public function setData_pub($date) {
		$this->data_pub = $date;
	}
	
	/**
	 * Retorna uma data presente em uma notícia
	 * @return Date {@link $data_noticia}
	 */
	public function getData_noticia() {
		return $this->data_noticia;
	}
	
	/**
	* Altera o valor de uma data presente em uma notícia {@link $data_noticia}
	* @param Date $date
	*/
	public function setData_noticia($date) {
		$this->data_noticia = $date;
	}
	
	/**
	* Retorna o assunto da notícia
	* @return String {@link $assunto}
	*/
	public function getAssunto() {
		return $this->assunto;
	}
	
	/**
	 * Altera o valor do assunto da notícia {@link $assunto}
	 * @param String $as
	 */
	public function setAssunto($as) {
		$this->assunto = $as;
	}
	
	/**
	* Retorna a descrição da notícia
	* @return String {@link $descricao}
	*/
	public function getDescricao() {
		return $this->descricao;
	}
	
	/**
	 * Altera o valor da descrição da notícia {@link $descricao}
	 * @param String $desc
	 */
	public function setDescricao($desc) {
		$this->descricao = $desc;
	}
	
	/**
	* Retorna o texto da notícia
	* @return String {@link $texto}
	*/
	public function getTexto() {
		return $this->texto;
	}
	
	/**
	 * Altera o valor do texto da notícia {@link $texto}
	 * @param String $t
	 */
	public function setTexto($t) {
		$this->texto = $t;
	}
	
	/**
	* Retorna a URL da notícia
	* @return String {@link $url}
	*/
	public function getUrl() {
		return $this->url;
	}
	
	/**
	 * Altera o valor da URL da notícia {@link $url}
	 * @param String $u
	 */
	public function setUrl($u) {
		$this->url = $u;
	}
	
	/**
	* Retorna a visibilidade da notícia
	* @return boolean {@link $visivel}
	*/
	public function getVisivel() {
		return $this->visivel;
	}
	
	/**
	 * Altera o valor da URL da notícia {@link $url}
	 * @param String $url
	 */
	public function setVisivel($v) {
		$this->visivel = $v;
	}
	
	
	/**
	 * Insere uma notícia na Base de Dados
	 * @param Array $fields Array com as notícias recolhidas da fonte de informação
	 * @return String $msg Mensagem com informações sobre a execução da operação
	 */
	public function insert($fields) {
		
		/** Mensagemn de retorno **/
		$msg = "";
		
		/** Conexão com a base de dados */
		$dao = new DAO();
		$dao->connect();
		
		/** Apaga todas as noticias da fonte de informação **/
		if(count($fields) > 0) {
			$sql = "DELETE FROM noticia WHERE idfonte = ".$fields[0]["idfonte"];
			$rs = $dao->db->Execute($sql) or die($dao->db->ErrorMsg());
		}
		else {
			$msg = "<b>Não existem notícias a inserir</b>";
		}
		
		/** Insere as notícias recuperadas da fonte de informação **/
		foreach ($fields as $new) {
			$rs = $dao->db->AutoExecute("noticia", $new, "INSERT");
			if($rs) {
				//echo "Noticia \"<b>".$new["assunto"]."</b>\" inserida com sucesso!<br>";
			}
			else {
				$msg = "Erro ao inserir noticia!<br>";
				return $msg;
			}
		}
		$dao->disconnect();
		$msg = "Foram inseridas ".count($fields)." mensagens.";
		return $msg;
	}
				
	/**
	 * Função para apagar todas as entradas da tabela noticia na Base de Dados
	 */
	public function clear() {
		$dao = new DAO();
		$dao->connect();
		$sql = "TRUNCATE TABLE noticia";
		$rs = $dao->db->Execute($sql) or die($dao->db->ErrorMsg());
		echo "Tabela noticia apagada com sucesso!";
	}
	
	public function __toString(){
		$return = "Noticia -";
		if ($this->assunto) $return .= 'ASSUNTO: ' . $this->assunto; 
		if ($this->data_pub) $return .= 'PUBLICADO EM : ' . $this->data_pub; 
		if ($this->descricao) $return .= 'DESCRI‚ÌO :' . $this->descricao; 
		if ($this->url) $return .= 'URL :' . $this->url;   
		return $return; 
	}
}
?>