<?php

require_once "Model.php";

/**
 * Classe que representa uma notícia recuperada de fontes de informações da Web
 *  (Google News, Sapo News, Twitter, etc.)
 */ 
class Noticia extends Model{
	
	/**
	 * Retorna uma nova noticia a partir de um XML bem formado
	 * sen‹o estiver bem formado retorna null 
	 */
	 
	//TODO - SQL Injection.  			
	public static function fromXml($xml){
		try { 
			$n = new Noticia(); //nova noticia para criar  
			$nxml = new SimpleXMLElement($xml);
			
			//check if tags is defined
			if ( $nxml->newNoticia){
<<<<<<< HEAD
				//get descrica�ao 
				if ($nxml->newNoticia->descricao) 
					$n->descricao = addslashes($nxml->newNoticia->descricao);  
				else  return null;
				
				//get data de publica�‹o
=======
				//get descrica�ao 
				if ($nxml->newNoticia->descricao) $n->descricao = addslashes($nxml->newNoticia->descricao);  else  return null;

				//get data de publica��o
>>>>>>> origin/master
				if ($nxml->newNoticia->data_pub) {
					$n->data_pub = Noticia::checkAndGetDate($nxml->newNoticia->data_pub); 							
				}
				
				//get url 
				if ($nxml->newNoticia->url){
					//se tiver url vamos buscar o texto l‡
				   $n->url= addslashes($nxml->newNoticia->url);
				   //TODO check url is well formed. 
				   $n->text = Noticia::fetchTexto($n->url); 
				}
				else {
<<<<<<< HEAD
					// se nao tiver url ent‹o devia ter o corpo da noticia. 
					if ($nxml->newNoticia->texto)
					{ 
						$n->texto = addslashes($nxml->newNoticia->texto); 
					} else { 
						return null;
					}	
=======
					// se nao tiver url ent�o devia ter o corpo da noticia. 
					if ($nxml->newNoticia->texto) $n->texto = addslashes($nxml->newNoticia->texto);  else return null;	
>>>>>>> origin/master
				}
			}
			else return null; 
		}catch (Exception $e){
			return null; 
		}
	}	
	
	public static function checkAndGetDate($date){
			//TODO - parse date from String
			return $date; 
	}
	
	/**
	 * Fun�‹o para ir buscar o texto de noticia a partir de um url
	 * @param url O url da noticia.  
	 */
	public static function fetchTexto($url){
		// TODO - usar curl, meter null em caso de o url t‡ dead. 
		// TODO - usar parser html do prof e fazer cenas... (ir buscar s— o body)
		return addslashes(file_get_contents($url)); 
	}
	 
	/**
	 * Identificador da noticia
	 * @var int
	 */
	var $idnoticia = null;
	
	/**
	 * Identificador da fonte da notícia
	 * @var int
	 */
	var $idfonte;
	
	/**
	 * Data de publicação da notícia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	var $data_pub;
	
	/**
	 * Data presente no corpo da notícia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	
	/**
	 * Assunto da notícia
	 * @var String
	 */
	var $assunto;
	
	/**
	 * Breve resumo da mensagem
	 * @var String
	 */
	var $descricao;
	
	/**
	 * Texto completo da notícia
	 * @var String
	 */
	var $texto;
	
	/**
	 * URL contendo a íntegra da notícia
	 * @var String
	 */
	var $url;
	
	/**
	 * Define se uma notícia deve estar visível para o utilizador
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
		$this->assunto = utf8_encode($as);
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
		$this->descricao = utf8_encode($desc);
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
		$this->texto = utf8_encode($t);
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
		$this->url = utf8_encode($u);
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

}

?>