<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "Model.php";
require_once '../backend/lib/HttpClient.php';
require_once '../backend/lib/parseXml.php'; 
 
/**
 * Classe que representa uma fonte de informações da Web
 *  (Google News, Sapo News, Twitter, etc.)
 */
class Fonte extends Model {
	
	public function checkValidity(){
		return true; 
	}
	 
	 public function getKeyFields(){
		return array ('idfonte'); 
	}
	
	/**
	* Identificador da fonte
	* @var int
	*/
	var $idfonte;
	var $type; 
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
	 * Contrutor da classe.
	 */
	public function __construct($n = "") {
		parent::__construct();
		if($n != "") {
			$this->webname = $n; 
			$where = array("webname" => $this->webname);
			$obj = $this->findFirst($where);
			$this->setIdfonte($obj->idfonte);
		}
	}

	/**
	* Retorna o identificador da fonte
	* @return int {@link $idfonte}
	*/
	public function getIdfonte() {
		return $this->idfonte;
	}
	
	/**
	* Altera o valor do identificador da fonte {@link $idfonte}
	* @param int $id
	*/
	public function setIdfonte($id) {
		$this->idfonte =$id;
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
	* Retorna a visibilidade da fonte
	* @return Boolean {@link $ligado}
	*/
	public function getLigado() {
		return $this->ligado;
	}
	
	/**
	 * Altera o valor da visibilidade da fonte {@link $ligado}
	 * @param Boolean $l Nova visibilidade da fonte
	 */
	public function setLigado($l) {
		$this->ligado = $l;
	}
	
	public function toObject($xmlString){
		if ($xmlString == ''){
			return ;
		}
		@$ob =  simplexml_load_string($xmlString);
		return $ob; 
	}
	
	/**
	 * 
	 * @param unknown_type $searchParameters
	 */
	public function search($searchParameters){
		$news = array(); 
		foreach ($searchParameters as $s){
				$url_s = $this->getUri(urlencode($s));
				if (isset($url_s)){
					$data = getUrlContent($url_s);
				}
				$n_ =  parseXml($data, $this->xmlObject, $this->idfonte, $s);
				if (isset($n_)){
						$news = array_merge($news, $n_);
				}
		}
		return $news; 
	}
	
	public function getUri($search){
		if (!isset($this->xmlObject)){
			if (isset($this->xml)){
				$this->xmlObject = $this->toObject($this->xml);
				if (isset($this->xmlObject->template)){
					$this->xmlObject = $this->xmlObject->template; 
				}
			}
			else return; 
		}
			$base = "";
			foreach ($this->xmlObject->uri->url as $url){
					if (strcmp($url,"AW_SEARCH_VALUE") == 0){
						$base .= $search;
					}else{
						$base .= $url;
						
					}
			}
			if (isset($this->xmlObject->uri->query->variable)){
				$base .= '?'; 
				$i = 0;
				$count = count($this->xmlObject->uri->query->variable);
				foreach ($this->xmlObject->uri->query->variable as $q){
					$base .= $q->id . '='; 
					if (!isset($q->value)){
						$base .= $search;
					}
					else{
						$base .= $q->value; 
					}
					$i++; 
					if ($i < $count){
						$base .= '&'; 
					}
				}	
			}
			return $base;
		}
}

?>