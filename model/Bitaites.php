<?php
require_once ('Model.php'); 
class Bitaites extends Model{
	
	/* (non-PHPdoc)
	 * @see Model::checkValidity()
	 */public function checkValidity() {
			return true; 
		}

	/* (non-PHPdoc)
	 * @see Model::getKeyFields()
	 */public function getKeyFields() {
			return ("idbitaite"); 
		}
}
?>