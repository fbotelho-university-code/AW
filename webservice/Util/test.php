<?php
@header('Content-Type: text/html; charset=utf-8');
/*
 * Created on Mar 26, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 include ('./RestUtils.php'); 
 include ('./RestRequest.php'); 
 
 $ret = RestUtils::processRequest();
  var_dump($ret);  
?>
