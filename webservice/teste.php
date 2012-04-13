<?php require_once ('../model/Clube.php'); 

	$clube = new Clube();
	
	$xmlString = "<?xml version='1.0' encoding='UTF-8'?>
<clube>
  <idclube>1</idclube>
  <idlocal>1</idlocal>
  <idcompeticao>1</idcompeticao>
  <nome_clube>Bahia</nome_clube>
  <nome_oficial>Esporte Clube Bahia</nome_oficial>
</clube>";
	
	$clube->validateXMLbyXSD($xmlString);

$m = new Noticia();
//$m->execute("insert into noticia (texto) values (m�o)");
	  $teste = "<clube><idclube>1</idclube> <idlocal>133</idlocal> <idcompeticao>1</idcompeticao> <nome_clube>Benfica</nome_clube> <nome_oficial>sport lisboa e benfica </nome_oficial></clube>";
	
	validateXMLbyXSD($teste); 
   function validateXMLbyXSD($xmlString) {
        // Transformação da String em DOM
        $xmlDOM = new DOMDocument();
        $xmlDOM->loadXML($xmlString);
        
        //Manipulação do nome da classe chamadora
        $class = 'clube'; 
        if($class == "local") {
            $class = "espaco";
        }
        
        //Alteração do cabeçalho XML para inclusão das referências para o XSD
        $rootElement = $xmlDOM->getElementsByTagName("clube");
        
        $xmlnsAttribute = $xmlDOM->createAttribute("xmlns");
        $xmlnsAttribute->value = "http://localhost/AW-3/workspace/Schemas/".$class.".xsd";
        
        $xmlnsXsiAttribute = $xmlDOM->createAttribute("xmlns:xsi");
        $xmlnsXsiAttribute->value = "http://www.w3.org/2001/XMLSchema-instance";
        
        $schemaLocationAttribute = $xmlDOM->createAttribute("xsi:schemaLocation");
        $schemaLocationAttribute->value = "http://localhost/AW-3/workspace/Schemas/".$class.".xsd ".$class."xsd ";
        
        $rootElement->appendChild($xmlnsAttribute);
        $rootElement->appendChild($xmlnsXsiAttribute);
        $rootElement->appendChild($schemaLocationAttribute);
        $xmlDOM->appendChild($rootElement);
        
        //Validação do XML usando o ficheiro XSD
        $pathToXSD = "../webservice/Schemas/";
        $pathToXSD .= $class.".xsd";
        if($xmlDOM->schemaValidate($pathToXSD)) {
            echo "validated<br>";
        }
        else {
            echo "Error!!<br>";
        }
    }
?>