<?php

/**
 * Classe que representa uma not�cia recuperada de fontes de informa��es da Web
 *  (Google News, Sapo News, Twitter, etc.)
 * @author Anderson Barretto - Nr 42541
 * @author F�bio Botelho 	 - Nr 41625
 * @author Jos� Lopes		 - Nr 42437
 * @author Nuno Marques		 - Nr 42809
 * @package backend.classes
 * @version 1.0 20120305
 */ 
class Noticia {
	
	/**
	 * Identificador da noticia
	 * @var int
	 */
	private $idnoticia = null;
	
	/**
	 * Identificador da fonte da not�cia
	 * @var int
	 */
	private $idfonte;
	
	/**
	 * Identificador de uma referencia local da not�cia
	 * @var int
	 */
	private $idlocal;
	
	/**
	 * Data de publica��o da not�cia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	private $data_pub;
	
	/**
	 * Data presente no corpo da not�cia
	 * Formato: AAAA-MM-DD HH:MM:SS
	 * @var Date
	 */
	private $data_noticia;
	
	/**
	 * Assunto da not�cia
	 * @var String
	 */
	private $assunto;
	
	/**
	 * Breve resumo da mensagem
	 * @var String
	 */
	private $descricao;
	
	/**
	 * Texto completo da not�cia
	 * @var String
	 */
	private $texto;
	
	/**
	 * URL contendo a �ntegra da not�cia
	 * @var String
	 */
	private $url;
	
	/**
	 * Define se uma not�cia deve estar vis�vel para o utilizador
	 * @var boolean
	 */
	private $visivel = true;
		
	/**
	 * Contrutor da classe. 
	 */
	public function __construct() {	}
	
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
		$this->assunto = $as;
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
		$this->descricao = $desc;
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
		$this->texto = $t;
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
		$this->url = $u;
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
	

	/**
	 * Cria uma array associativo preparado para entregar ao aodb.    
	 * @return Map de campos de noticia para array indexado pelos nomes dos campos de Noticia na bd.  
	 */

	public function toHash(){
		$myNew = array(); 
		$myNew["idnoticia"] = $this->idnoticia; 						//campo auto increment
		$myNew["idfonte"] = $this->idfonte;         				//identificador da fonte 
		$myNew["idlocal"] = $this->idlocal;					        //@todo buscar ref espacial
		$myNew["data_pub"] = $this->data_pub; 
		$myNew["data_noticia"] = $this->data_noticia;					//@todo buscar ref tempora podem ser v�rias
		$myNew["assunto"] = $this->assunto;                 
		$myNew["descricao"] = $this->descricao;
		$myNew["texto"] = $this->texto; 
		$myNew["url"] = $this->url; 
		$myNew["visivel"] = $this->visivel;
		return $myNew; 			
	}
	
	
	/**
	 * Transforma um array associativo de uma tabela de Noticia para um objecto noticia
	 * @param noticia Array associativo indexados pelos campos da tabela noticia
	 * @return Um objecto noticia. 
	 */
	public static function fromHash($noticia){
		$n = new Noticia(); 
		$n->setIdnoticia($noticia["idnoticia"]); 
		$n->setIdfonte($noticia["idfonte"]); 
		$n->setIdLocal($noticia["idLocal"]);
		$n->setData_pub($noticia["data_pub"]);
		$n->setData_noticia($noticia["data_noticia"]); 
		$n->setAssunto($noticia["assunto"]); 
		$n->setDescricao($noticia["descricao"]);
		$n->setTexto($noticia["texto"]);
		$n->setUrl($noticia["url"]); 
		$n->setVisivel($noticia["visivel"]); 
	}
	
	/**
	 * Adiciona Noticia n�o existente anteriormente � base de dados
	 * 
	 */
	public function add(){
		$dao = new DAO();
		$dao->connect(); 
		
		$fields = $this->toHash(); 
		var_dump ($fields); 
		echo '<br/> inserting in bd <br/>';
		
		$rs = $dao->db->AutoExecute("noticia", $fields, "INSERT");
		if (!$rs){
			//echo $dao->db->ErrorMsg(); 
		    die ($dao->db->ErrorMsg()); 
		}
	}
	
	/**
	 * Insere uma not�cia na Base de Dados
	 * @param Array $fields Array com as not�cias recolhidas da fonte de informa��o.
	 *                      O par�metro deve ser uma array associativo, onde  as chaves devem 
	*                       representar o nome de todas as coluna da tabela 'noticia' e o valor 
	*                       associado a chave deve ser o valor a ser inserido na tabela.
	 * @return String $msg Mensagem com informa��es sobre a execu��o da opera��o
	 */
	public function insert($fields) {
		
		/** Mensagemn de retorno **/
		$msg = "";
		
		/** Conex�o com a base de dados */
		$dao = new DAO();
		$dao->connect();
		
		
		/** Apaga todas as noticias da base de dados associadas � fonte de informa��o **/
		if(count($fields) > 0) {
			$sql = "DELETE FROM noticia WHERE idfonte = ".$fields[0]["idfonte"];
			$rs = $dao->db->Execute($sql) or die($dao->db->ErrorMsg());
		}
		else {
			$msg = "<b>N�o existem not�cias a inserir</b>";
		}
		
		
		/** Insere as not�cias recuperadas da fonte de informa��o **/
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
	 * Fun��o para apagar todas as entradas da tabela noticia na Base de Dados
	 */
	public function clear() {
		$dao = new DAO();
		$dao->connect();
		$sql = "TRUNCATE TABLE noticia";
		$rs = $dao->db->Execute($sql) or die($dao->db->ErrorMsg());
		$dao->disconnect();
		echo "Tabela noticia apagada com sucesso!";
	}
	
	public function getClube(){
			
	}
}

?>