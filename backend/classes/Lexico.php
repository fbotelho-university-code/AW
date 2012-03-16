<?php
/*
 * Created on Mar 15, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
	class Lexico {
		
		private $nucleo; 
		private $contexto; 
		private $entidade; 
		private $tipo; 
		private $pol; // int 
		private $ambiguidade; //int
		private $idlexico ; //int  
		
		public function getNucleo() { return $this->nucleo; }
		public function getContexto() { return $this->contexto; }
		public function getEntidade() { return $this->entidade; }
		public function getTipo() { return $this->tipo; }
		public function getPol() { return $this->pol; }
		public function getAmbiguidade() { return $this->amgibuidade; }
		public function getIdlexico() { return $this->idlexico; }
		
		
		public function setNucleo($p) { $this->nucleo = $p; }
		public function setContexto($p) { $this->contexto = $p; }
		public function setEntidade($p) { $this->entidade = $p;  }
		public function setTipo($p) { $this->tipo = $p;  }
		public function setPol($p) { $this->pol = $p; }
		public function setAmbiguidade($p) { $this->ambiguidade = $p; }
		public function setIdlexico($p) { $this->idlexico = $p;  }
		
		/**
		 * Creates an object Lexico by selecting from the table the first element wich obeys 
		 * the criteria set by the hash pass as argument. 
	   	 * @parm hash Should set the desired table columns and respective values
		 * @return the first element 
		*/
		 public static function getByHash($hash){
			$sql = 'select * from lexico where ';
			$i = 0;  
			foreach ($hash as $key=>$value){
				$sql .= ' '  . $key . '=' . '\'' . $value  . '\' ';
				$i +=1;
				//se for ultimo adicionar and para proxima clausula 
				if ($i < count($hash)){
					 $sql .=  'AND '; 
				}  
			}
			$dao = new DAO(); 
			$dao->connect(); 
			$rs = $dao->execute($sql);
			if (!$rs){
				die ($dao->db->ErrorMsg());
				//return null; 
			} 
			return Lexico::fromHash($rs->fields); 
		}
		
		public static function fromHash($fields){
			$ob = new Lexico(); 
			$ob->setNucleo($fields["nucleo"]); 
			$ob->setContexto($fields["contexto"]); 
			$ob->setEntidade($fields["entidade"]); 
			$ob->setTipo($fields["tipo"]); 
			$ob->setPol($fields["pol"]); 
			$ob->setAmbiguidade($fields["ambiguidade"]); 
			$ob->setIdlexico($fields["idlexico"]); 
			return $ob; 
		}
		
		public static function find ($fields){
			$sql = 'select * from lexico where ';
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
//			echo $sql; 
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
		
		public static function getAll(){
		$dao = new DAO(); 
		$dao->connect(); 
		
		$sql = "SELECT  * FROM lexico";

		//TODO - does not dies ? 
		$rs = $dao->db->execute($sql);
		if (!$rs){
			//echo 'ERROR'; 
		   die ($dao->db->ErrorMsg()); 
		}
		
		$lexicos = array(); // array de locais para retornar
		
		while (!$rs->EOF){
			$lexicos[] = Lexico::fromHash($rs->fields);
			$rs->MoveNext();
		}

		$rs->Close(); 
		$dao->disconnect();
		return $lexicos;		
	}
	
	}
	
?>
