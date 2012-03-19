<?php
/*
 * Created on Mar 15, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class NoticiasClubes{
 	private $idclube; 
	private $idnoticia; 
	private $qualificacao; 
	
	public function getIdClube(){return $this->idclube;}  
	public function getIdNoticia() {return $this->idnoticia; }
	public function getQualificacao() {return $this->qualificao; }
	
	public function setIdClube($p) {$this->idclube = $p; }
	public function setIdNoticia($p) {$this->idnoticia = $p; }
	public function setQualificacao($p) {$this->qualificao = $p; }
	
	public function __construct($idNoticia, $idClube,$qualificao = 0){
		$this->idclube = $idClube; 
		$this->idnoticia = $idNoticia; 		
		$this->qualificacao = $qualificao; 
	}
	
	public function save(){
		$values = NoticiasClubes::toHash($this); 
		$dao = new DAO(); 
		$dao->connect(); 
		
		$rs = $dao->db->AutoExecute("noticia_has_clube", $values, "INSERT"); 
		
		if (!$rs){
			die ($dao->db->ErrorMsg()); 
		}
	}
 		public static function find ($fields){
			$sql = 'select * from noticia_has_clube where ';
			$i = 0;  
			foreach ($fields as $key=>$value){
				$sql .= ' '  . $key . '=' . '\'' . $value  . '\' ';
				$i +=1;
				//se for ultimo adicionar and para proxima clausula 
				if ($i < count($fields)){
					 $sql .=  'AND '; 
				}  
			}
			$sql .= ';'; 

			$dao = new DAO(); 
			$dao->connect(); 
			$rs = $dao->execute($sql);

			if (!$rs){
				die ($dao->db->ErrorMsg());
				//return null; 
			}
			 
			$values = array();
			//echo '<br/> VALUES FROM FIND : <br/>';  
			//			var_dump($rs->fields);
			
			while (!$rs->EOF){
//				echo '<br/> one more <br/>';
				$values[] = Lexico::fromHash($rs->fields);
				$rs->MoveNext(); 
			}
			return $values;  
		}
		
		public static function fromHash($fields){
			$ob = new $LexicoClubes(); 
			$ob->setIdClube($fields["idclube"]); 
			$ob->setIdNoticia($fields["idnoticia"]);
			$ob->setQualificacao($fields["qualificacao"]);  
			return $ob; 
		}
		
		public function update(){
			$sql_where_key =" where idclube = \'" . $this->idclube . "\' AND idnoticia = \'" . $this->idnoticia;
			$query = "select * from noticia_has_clubes" . $sql_where_key;   
			
			$ado = new DAO(); 
			$ado->connect(); 
			$rs = $ado->execute($query); 
			
			if (!$rs){
				die($dao->db->ErrorMsg());
			}
			if ($rs->RecordCount() > 0 ){
				$query = "update noticia_has_clube SET qualificacao = " . $this->qualificacao . $sql_where_key; 
			}
			else {
				$query = "insert into noticia_has_clube values (" . $this->idnoticia . "," . $this->idclube . ", " . $this->qualificacao . ")";
			}
			$rs = $dao->execute($query);
			//TODO check if failed. 
			 
		}
	public static function toHash($objNoticiasClubes){
		$array = array(); 
		$array["idclube"] = $objNoticiasClubes->getIdClube(); 
		$array["idnoticia"] = $obNoticiasClubes->getIdNoticia(); 
		$array["qualificacao"] = $obNoticiasClubes->getQualificacao(); 
	}			
 }	
 ?>
