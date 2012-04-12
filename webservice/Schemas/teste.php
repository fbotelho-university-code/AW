<?php

$xml = new DOMDocument();
$xml->load('./espaco.xml');

if (!$xml->schemaValidate('./espaco.xsd')) {
   echo "invalid<p/>";
}
else {
   echo "validated<p/>";
}

?>