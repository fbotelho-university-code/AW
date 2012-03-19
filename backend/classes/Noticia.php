<?php

require_once "DAO.php";
/**
 * Classe que representa uma not�cia recuperada de fontes de informa��es da Web
 *  (Google News, Sapo News, Twitter, etc.)
 * @author Anderson Barretto - Nr 42541
 * @author F�bio Botelho 	 - Nr 41625
 * @author Jos� Lopes		 - Nr 42437
 * @author Nuno Marques		 - Nr 42809
 * @package backend.classes
 */ 
class Noticia extends DAO{
	
	/**
	 * Identificador da noticia
	 * @var int
	 */
	var $idnoticia = null;
	
	/**
	 * Identificador da fonte da not�cia
	 * @var int
	 */
	var $idfonte;
	
	/**
	 * Identificador de uma referencia local da not�cia
	 * @var int
	 */
	var $idlocal;
	
	/**
	 * Data de publica��o da not�cia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	var $data_pub;
	
	/**
	 * Data presente no corpo da not�cia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	var $data_noticia;
	
	/**
	 * Assunto da not�cia
	 * @var String
	 */
	var $assunto;
	
	/**
	 * Breve resumo da mensagem
	 * @var String
	 */
	var $descricao;
	
	/**
	 * Texto completo da not�cia
	 * @var String
	 */
	var $texto;
	
	/**
	 * URL contendo a �ntegra da not�cia
	 * @var String
	 */
	var $url;
	
	/**
	 * Define se uma not�cia deve estar vis�vel para o utilizador
	 * @var boolean
	 */
	var $visivel = true;
		
	/**
	 * Contrutor da classe. 
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	* Retorna o identificador da not�cia
	* @return int {@link $idnoticia}
	*/
	
	public function getIdnoticia() {
		return $this->idnoticia;
	}
	
	/**
	 * Altera o valor do identificador da not�cia {@link $idnoticia}
	 * @param int $id
	 */
	public function setIdnoticia($id) {
		$this->idnoticia = $id;
	}
	
	/**
	* Retorna o identificador da fonte da not�cia
	* @return int {@link $idfonte}
	*/
	public function getIdfonte() {
		return $this->idfonte;
	}
	
	/**
	 * Altera o valor do identificador da fonte da not�cia {@link $idfonte}
	 * @param int $id
	 */
	public function setIdfonte($id) {
		$this->idfonte = $id;
	}
	
	/**
	* Retorna o identificador da referencia espacial da not�cia
	* @return int {@link $idlocal}
	*/
	public function getIdlocal() {
		return $this->idlocal;
	}
	
	/**
	 * Altera o valor do identificador da referencia espacial da not�cia {@link $idlocal}
	 * @param int $id
	 */
	public function setIdlocal($id) {
		$this->idlocal = $id;
	}
	
	/**
	 * Retorna a data de publica��o da not�cia
	 * @return Date {@link $data_pub}
	 */
	public function getData_pub() {
		return $this->data_pub;
	}
	
	/**
	 * Altera o valor da data da not�cia {@link $data_pub}
	 * @param Date $date
	 */
	public function setData_pub($date) {
		$this->data_pub = $date;
	}
	
	/**
	 * Retorna uma data presente em uma not�cia
	 * @return Date {@link $data_noticia}
	 */
	public function getData_noticia() {
		return $this->data_noticia;
	}
	
	/**
	* Altera o valor de uma data presente em uma not�cia {@link $data_noticia}
	* @param Date $date
	*/
	public function setData_noticia($date) {
		$this->data_noticia = $date;
	}
	
	/**
	* Retorna o assunto da not�cia
	* @return String {@link $assunto}
	*/
	public function getAssunto() {
		return $this->assunto;
	}
	
	/**
	 * Altera o valor do assunto da not�cia {@link $assunto}
	 * @param String $as
	 */
	public function setAssunto($as) {
		$this->assunto = utf8_encode($as);
	}
	
	/**
	* Retorna a descri��o da not�cia
	* @return String {@link $descricao}
	*/
	public function getDescricao() {
		return $this->descricao;
	}
	
	/**
	 * Altera o valor da descri��o da not�cia {@link $descricao}
	 * @param String $desc
	 */
	public function setDescricao($desc) {
		$this->descricao = utf8_encode($desc);
	}
	
	/**
	* Retorna o texto da not�cia
	* @return String {@link $texto}
	*/
	public function getTexto() {
		return $this->texto;
	}
	
	/**
	 * Altera o valor do texto da not�cia {@link $texto}
	 * @param String $t
	 */
	public function setTexto($t) {
		$this->texto = utf8_encode($t);
	}
	
	/**
	* Retorna a URL da not�cia
	* @return String {@link $url}
	*/
	public function getUrl() {
		return $this->url;
	}
	
	/**
	 * Altera o valor da URL da not�cia {@link $url}
	 * @param String $u
	 */
	public function setUrl($u) {
		$this->url = utf8_encode($u);
	}
	
	/**
	* Retorna a visibilidade da not�cia
	* @return boolean {@link $visivel}
	*/
	public function getVisivel() {
		return $this->visivel;
	}
	
	/**
	 * Altera o valor da URL da not�cia {@link $url}
	 * @param String $url
	 */
	public function setVisivel($v) {
		$this->visivel = $v;
	}

}

?>