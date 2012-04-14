<?php

require_once "Model.php";

/**
  * Classe que representa um local.
  * Pode ser um Distrito, Ilha ou Concelho de Portugal
  */
class Local extends Model{
	
	public function checkValidity(){
		
		if (
		
		preg_match('/\-?\d+\.?\d*;-?\d+\.?\d*/', $this->coordenadas ) == 1  
		)
			return true; 
	}
	 
	public function getKeyFields(){
		return array ('idlocal'); 
	}
	 
	/**
	* Identificador do local
	* @var int
	*/
	var $idlocal;
	
	/**
	* Nome do local
	* @var String
	*/
	var $nome_local;
	
	/**
	* Coordenadas do local
	* @var String
	*/
	var $coordenadas;
	
	/**
	* Contrutor da classe.
	*/
	public function __construct() {
		parent::__construct();
	}
	
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
	 * Transforma um ficheiro xXML em um Objecto da classe
	 * @param String $xml
	 */

/*	public static function fromXml($xml){
		
		//$xml = simplexml_load_string($xml);
		//var_dump($xml);
		
		try {
			$n = new Noticia(); //nova noticia para criar
			$nxml = new SimpleXMLElement($xml);
				
			//check if tags is defined
			if ( $nxml->newNoticia){
	
				//get descrica�ao
				if ($nxml->newNoticia->descricao)
				$n->descricao = addslashes($nxml->newNoticia->descricao);
				else  return null;
	
				//get data de publica�‹o
	
				//get descrica�ao
				if ($nxml->newNoticia->descricao) $n->descricao = addslashes($nxml->newNoticia->descricao);  else  return null;
	
				//get data de publica��o
	
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
	
					// se nao tiver url ent‹o devia ter o corpo da noticia.
					if ($nxml->newNoticia->texto)
					{
						$n->texto = addslashes($nxml->newNoticia->texto);
					} else {
						return null;
					}
	
					// se nao tiver url ent�o devia ter o corpo da noticia.
					if ($nxml->newNoticia->texto) $n->texto = addslashes($nxml->newNoticia->texto);  else return null;
	
				}
			}
			else return null;
		}catch (Exception $e){
			return null;
		}*/
}

?>