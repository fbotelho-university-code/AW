<?php
/*
 * Created on Mar 26, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class RestRequest {
 	
 	
 	private $request_vars;   //request variables in uri. (TODO: what about request variables in content? Not restfull i know... )
 	private $data;         //content in http body ?
 	private $http_accept;  //response format. 
 	private $method;  //get, put, head, post...
	private $path_info;  //array of path parameters. 
	
 	public function construct(){
		$this->request_vars = array();
		$this->data = '';
		//FINDING THE RESULT. 
		$this->http_accept = (strpos($_SERVER['HTTP ACCEPT'], 'json')) ? 'json' : 'xml';
		$this->method = 'get';
	}
	
	public function setPathInfo($p) { 
		$this->path_info = $p; 
	}
	
	public function getPathInfo(){
		return $this->path_info; 
	}
	
	public function setData($data){
		$this->data = $data;
	}

	public function setMethod($method){
		$this->method = $method;
	}
	public function setRequestVars($request_vars){
		$this->request_vars = $request_vars;
	}
	
	public function getData(){
		return $this->data; 
 	}
 	public function getMethod(){
		return $this->method;
	}
	
	public function setHttpAccept($p){
		$this->http_accept = $p; 
	}
	public function getHttpAccept(){
		return $this->http_accept;
	}

	public function getRequestVars(){
		return $this->request_vars;
	}
 }
?>
