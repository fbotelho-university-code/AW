<?php
class Integrante_imagem extends Model{
	
	/* (non-PHPdoc)
	 * @see Model::checkValidity()
	 */public function checkValidity() {
		return true; 
	}

	/* (non-PHPdoc)
	 * @see Model::getKeyFields()
	 */public function getKeyFields() {
		return array("idintegrante"); 	
	}
	
}