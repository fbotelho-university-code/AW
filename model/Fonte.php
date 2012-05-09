<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "Model.php";

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
			$this->nome = $n; 
			$where = array("nome" => $this->nome);
			$obj = $this->findFirst($where);
			$this->setIdfonte($obj->idfonte);
			$this->setMain_url($obj->main_url);
			$this->setLigado($obj->ligado);
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
	
	public function getUrl($search){
		if (!isset($this->xmlObject)){
			if (isset($this->xml)){
				var_dump($this->xml);
				$this->xmlObject = $this->toObject($this->xml);
				var_dump($this->xmlObject); 
			}
			else return; 
		}
			$base = "";

			foreach ($this->xmlObject->uri->url as $url){
					if (strcmp($url->url,"AW_SEARCH_VALUE") != 0){
						$base .= $url;
					}else{
						$base .= $search; 
					}
			}
			if (isset($this->xmlObject->query)){
				$base .= '?'; 
				foreach ($this->xmlObject->query as $q){
					$base .= $q->id; 
					if (isset($q->value)){
						$base .= $search;
					}
				}	
			}
			return $base;
		}
}

?>