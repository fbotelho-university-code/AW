<?php
/*
 * Created on Mar 15, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class LexicoClubes{
	private $idclube; 
	private $idlexico; 
	
	
	public function getIdClube(){return $this->idclube;}  
	public function getIdLexico() {return $this->idlexico; }
	public function setIdClube($p) {$this->idclube = $p; }
	public function setIdLexico($p) {$this->idlexico = $p; }
	
	
 		public static function find ($fields){
			$sql = 'select * from clubes_lexico where ';
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
				$values[] = LexicoClubes::fromHash($rs->fields);
				$rs->MoveNext(); 
			}
			return $values;  
		}
		
		public static function fromHash($fields){
			$ob = new LexicoClubes(); 
			$ob->setIdClube($fields["idclube"]); 
			$ob->setIdLexico($fields["idlexico"]); 
			return $ob; 
		}
		
 }	
?>
