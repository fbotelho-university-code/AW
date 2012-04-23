<?php
@header('Content-Type: text/html; charset=utf-8');

require_once "Model.php";
require_once 'includes.php'; 
require_once 'lib/Util.php'; 
require_once 'Encoding.php'; 
/**
 * Classe que representa uma notícia recuperada de fontes de informações da Web
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
	public static function getRelationArray($idNoticia, $baseurl){
		//TODO what if idNoticia nao existe? 
		$class_noticia = new Noticia();
		$noticiaOb = $class_noticia->getObjectById($idNoticia);
		if (!$noticiaOb ) return null;
		//We do not want this to show: 

		
		//O array resultante. 
		foreach (get_object_vars($noticiaOb) as $key=>$value){
			$result[$key] = $value; 
		}
		//locais : 
		$class_locais_rel = new Noticia_Locais();
		//TODO - what if idNoticia nao existe nas relações. 
		$locais_noticias = $class_locais_rel->find(array("idnoticia" => $idNoticia));
		
		$result['locais'] =  Noticia_Locais::getAllLocais($locais_noticias, $baseurl);
		$result['datas'] = Noticia_Data::getAllDatas($idNoticia, $baseurl); 
		$result['clubes'] = Noticia_Has_Clube::getAllClubes($idNoticia,$baseurl); 
		$result['integrantes'] = Noticia_Has_Integrante::getAllIntegrantes($idNoticia,$baseurl); 
		
		return $result; 
	}
	
	/**
	 * Fun�‹o para ir buscar o texto de noticia a partir de um url
	 * @param url O url da noticia.  
	 */
		public static function fetchTexto($url){
			    //Encoding::fixUTF8(Encoding::toUTF8(addslashes($url)));
			    addslashes($url);
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
	 * Texto completo da not�cia
	 * @var String
	 */
	var $texto;
	
	/**
	 * URL contendo a íntegra da notícia
	 * @var String
	 */
	var $url;
	
	/**
	 * Define se uma not�cia deve estar vis�vel para o utilizador
	 * @var boolean
	 */
	
	
	/**
	 * Contrutor da classe. 
	 */
	public function __construct() {
		parent::__construct();
		$this->data_pub = "0000-00-00 00:00:00"; 
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
	
	private function arrangeFields($selectedFields =null){
		if ($this->setText() ){
			if (!isset($selectedFields)){
				$selectedFields = array("idnoticia", "data_pub", "assunto", "descricao", "texto", "url"); 
			}
			else{
				if (array_search("texto", $selectedFields)  === false ){
					$selectedFields[] = "texto"; 
				}
			}
		}
		else{
			if (!isset($selectedFields)){
				$selectedFields = array("idnoticia", "data_pub", "assunto", "descricao", "url"); 
			}
			else{
				$a = array(); 
				foreach ($selectedFields as $f){
					if (strcmp($f, "texto") == 0){
						continue; 
					}
					$a[] = $f; 
				}
				$selectedFields = $a;  	
			}
		}
		return $selectedFields; 
	}

	public function getObjectById($id){
		
		if ($this->setText()){
			$selectedFields = array("idnoticia", "data_pub", "assunto", "descricao", "texto", "url"); 	
		}else{
			
			$selectedFields = array("idnoticia", "data_pub", "assunto", "descricao", "url"); 	
		}

		return parent::getObjectById($id, $selectedFields); 
	}
	
	public function find($fields, $connector = ' = ', $selectedFields =null){
		$selectedFields = $this->arrangeFields($selectedFields);
		return parent::find($fields, $connector, $selectedFields); 
	}
	public function getAll($fields=null){
		$fields = $this->arrangeFields($fields);
		return parent::getAll($fields);  
	}
}

?>