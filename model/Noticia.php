<?php

require_once "Model.php";
require_once 'includes.php'; 

<<<<<<< HEAD
require_once 'lib/Util.php'; 

/**
 * Classe que representa uma notícia recuperada de fontes de informações da Web
=======

/**
 * Classe que representa uma not�cia recuperada de fontes de informa��es da Web
>>>>>>> origin/master
 *  (Google News, Sapo News, Twitter, etc.)
 */ 
class Noticia extends Model{
	
	public static function checkAndGetDate($date){
			//TODO - parse date from String
			return $date; 
	}
	
	public function checkValidity(){
		return true; 
	}
	
	public function getKeyFields(){
		return array('idnoticia'); 		
	
	}
	
	
	/**
	 * Return associative array with (
	 * "noticia" => obNoticia, 
	 * "locais" => locais , 
	 *  "tempo" => blah ) 
	 */		
	public static function getRelationArray($idNoticia){
		//TODO what if idNoticia nao existe? 
		$class_noticia = new Noticia();
		$noticiaOb = $class_noticia->getObjectById($idNoticia);
		if (!$noticiaOb ) return null;
		//We do not want this to show: 
		$noticiaOb->visivel = null;
		 
		//O array resultante. 
		
		
		//Noticia em si:	
		//$result['noticia'] = $noticiaOb; 
		
		
		foreach (get_object_vars($noticiaOb) as $key=>$value){
			$result[$key] = $value; 
		}
		
		//locais : 
		$class_locais_rel = new Noticia_Locais();
		//TODO - what if idNoticia nao existe nas relações. 
		$locais_noticias = $class_locais_rel->find(array("idnoticia" => $idNoticia));
		
		$result['locais'] =  Noticia_Locais::getAllLocais($locais_noticias);
		$result['datas'] = Noticia_Data::getAllDatas($idNoticia); 
		$result['clubes'] = Noticia_Has_Clube::getAllClubes($idNoticia); 
		$result['integrantes'] = Noticia_Has_Integrante::getAllIntegrantes($idNoticia); 
		
		return $result; 
	}
	
	/**
<<<<<<< HEAD
	 * Fun�‹o para ir buscar o texto de noticia a partir de um url
	 * @param url O url da noticia.  
	 */
	public static function fetchTexto($url){
		// TODO - usar curl, meter null em caso de o url t‡ dead. 
		// TODO - usar parser html do prof e fazer cenas... (ir buscar s— o body)
=======
	 * Fun��o para ir buscar o texto de noticia a partir de um url
	 * @param url O url da noticia.  
	 */
	public static function fetchTexto($url){
		// TODO - usar curl, meter null em caso de o url t� dead. 
		// TODO - usar parser html do prof e fazer cenas... (ir buscar s� o body)
>>>>>>> origin/master
		return addslashes(file_get_contents($url)); 
	}
	 
	/**
	 * Identificador da noticia
	 * @var int
	 */
	var $idnoticia = null;
	
	/**
<<<<<<< HEAD
	 * Identificador da fonte da notícia
=======
	 * Identificador da fonte da not�cia
>>>>>>> origin/master
	 * @var int
	 */
	var $idfonte;
	
	/**
<<<<<<< HEAD
	 * Data de publicação da notícia
=======
	 * Data de publica��o da not�cia
>>>>>>> origin/master
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	var $data_pub;  
	
	/**
<<<<<<< HEAD
	 * Data presente no corpo da notícia
=======
	 * Data presente no corpo da not�cia
>>>>>>> origin/master
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	
	/**
<<<<<<< HEAD
	 * Assunto da notícia
=======
	 * Assunto da not�cia
>>>>>>> origin/master
	 * @var String
	 */
	var $assunto;
	
	/**
	 * Breve resumo da mensagem
	 * @var String
	 */
	var $descricao;
	
	/**
<<<<<<< HEAD
	 * Texto completo da notícia
=======
	 * Texto completo da not�cia
>>>>>>> origin/master
	 * @var String
	 */
	var $texto;
	
	/**
<<<<<<< HEAD
	 * URL contendo a íntegra da notícia
=======
	 * URL contendo a �ntegra da not�cia
>>>>>>> origin/master
	 * @var String
	 */
	var $url;
	
	/**
<<<<<<< HEAD
	 * Define se uma notícia deve estar visível para o utilizador
=======
	 * Define se uma not�cia deve estar vis�vel para o utilizador
>>>>>>> origin/master
	 * @var boolean
	 */
	var $visivel = true;
		
	/**
	 * Contrutor da classe. 
	 */
	public function __construct() {
		parent::__construct();
		$this->data_pub = "0000-00-00 00:00:00"; 
	}
	
	/**
<<<<<<< HEAD
	* Retorna o identificador da notícia
=======
	* Retorna o identificador da not�cia
>>>>>>> origin/master
	* @return int {@link $idnoticia}
	*/
	public function getIdnoticia() {
		return $this->idnoticia;
	}
		
	/**
<<<<<<< HEAD
	 * Altera o valor do identificador da notícia {@link $idnoticia}
=======
	 * Altera o valor do identificador da not�cia {@link $idnoticia}
>>>>>>> origin/master
	 * @param int $id
	 */
	public function setIdnoticia($id) {
		$this->idnoticia = $id;
	}
	
	/**
<<<<<<< HEAD
	* Retorna o identificador da fonte da notícia
=======
	* Retorna o identificador da fonte da not�cia
>>>>>>> origin/master
	* @return int {@link $idfonte}
	*/
	public function getIdfonte() {
		return $this->idfonte;
	}
	
	/**
<<<<<<< HEAD
	 * Altera o valor do identificador da fonte da notícia {@link $idfonte}
=======
	 * Altera o valor do identificador da fonte da not�cia {@link $idfonte}
>>>>>>> origin/master
	 * @param int $id
	 */
	public function setIdfonte($id) {
		$this->idfonte = $id;
	}
	
	/**
<<<<<<< HEAD
	 * Retorna a data de publicação da notícia
=======
	 * Retorna a data de publica��o da not�cia
>>>>>>> origin/master
	 * @return Date {@link $data_pub}
	 */
	public function getData_pub() {
		return $this->data_pub;
	}
	
	/**
<<<<<<< HEAD
	 * Altera o valor da data da notícia {@link $data_pub}
=======
	 * Altera o valor da data da not�cia {@link $data_pub}
>>>>>>> origin/master
	 * @param Date $date
	 */
	public function setData_pub($date) {
		$this->data_pub = $date;
	}
	
	/**
<<<<<<< HEAD
	* Retorna o assunto da notícia
=======
	* Retorna o assunto da not�cia
>>>>>>> origin/master
	* @return String {@link $assunto}
	*/
	public function getAssunto() {
		return $this->assunto;
	}
	
	/**
<<<<<<< HEAD
	 * Altera o valor do assunto da notícia {@link $assunto}
=======
	 * Altera o valor do assunto da not�cia {@link $assunto}
>>>>>>> origin/master
	 * @param String $as
	 */
	public function setAssunto($as) {
		$this->assunto = utf8_encode($as);
	}
	
	/**
<<<<<<< HEAD
	* Retorna a descrição da notícia
=======
	* Retorna a descri��o da not�cia
>>>>>>> origin/master
	* @return String {@link $descricao}
	*/
	public function getDescricao() {
		return $this->descricao;
	}
	
	/**
<<<<<<< HEAD
	 * Altera o valor da descrição da notícia {@link $descricao}
=======
	 * Altera o valor da descri��o da not�cia {@link $descricao}
>>>>>>> origin/master
	 * @param String $desc
	 */
	public function setDescricao($desc) {
		$this->descricao = utf8_encode($desc);
	}
	
	/**
<<<<<<< HEAD
	* Retorna o texto da notícia
=======
	* Retorna o texto da not�cia
>>>>>>> origin/master
	* @return String {@link $texto}
	*/
	public function getTexto() {
		return $this->texto;
	}
	
	/**
<<<<<<< HEAD
	 * Altera o valor do texto da notícia {@link $texto}
=======
	 * Altera o valor do texto da not�cia {@link $texto}
>>>>>>> origin/master
	 * @param String $t
	 */
	public function setTexto($t) {
		$this->texto = utf8_encode($t);
	}
	
	/**
<<<<<<< HEAD
	* Retorna a URL da notícia
=======
	* Retorna a URL da not�cia
>>>>>>> origin/master
	* @return String {@link $url}
	*/
	public function getUrl() {
		return $this->url;
	}
	
	/**
<<<<<<< HEAD
	 * Altera o valor da URL da notícia {@link $url}
=======
	 * Altera o valor da URL da not�cia {@link $url}
>>>>>>> origin/master
	 * @param String $u
	 */
	public function setUrl($u) {
		$this->url = utf8_encode($u);
	}
	
	/**
<<<<<<< HEAD
	* Retorna a visibilidade da notícia
=======
	* Retorna a visibilidade da not�cia
>>>>>>> origin/master
	* @return boolean {@link $visivel}
	*/
	public function getVisivel() {
		return $this->visivel;
	}
	
	/**
<<<<<<< HEAD
	 * Altera o valor da URL da notícia {@link $url}
=======
	 * Altera o valor da URL da not�cia {@link $url}
>>>>>>> origin/master
	 * @param String $url
	 */
	public function setVisivel($v) {
		$this->visivel = $v;
	}


}

?>