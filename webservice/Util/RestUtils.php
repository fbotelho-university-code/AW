<?php
/*
 * Created on Mar 26, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class RestUtils{
	
	public static function processRequest() {
		
		//get our verb
		$request_method = ($_SERVER['REQUEST_METHOD']); 
		$return_obj = new RestRequest(); 
		//we'll store out data here
		$data = array();
		
		//Check if has path parameters
		$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO']:  null;
		
		$accept = isset($_SERVER['HTTP_ACCEPT'])  ? $_SERVER['HTTP_ACCEPT'] : null; 
		
		if ($accept){
			$accept = explode(',', $accept); 
			
			if (array_search('json', $accept) !==FALSE){
				$accept = 'json'; 
			}
			else{
				$accept ='text/xml'; 
			} 
			//TODO - fix and test this . 
			/*
			else if (array_search('application/xml', $accept) !==FALSE){
				$accept = 'text/xml';
			}*/
			
		}
		
		$return_obj->setHttpAccept($accept); 
		
		if (isset($path)){
 			$path_split_array = explode('/',  $path);
 			$i =0; 
 			foreach ($path_split_array as $p){
 				if ($p == ''){
 					unset($path_split_array[$i]); 
 				}
 				$i++; 
 			}
 			
 			if (count($path_split_array ) ==0){
 				$path_split_array = null; 
 			}
			if ($path_split_array !== FALSE){
				$return_obj->setPathInfo($path_split_array); 
			}
		}
		
		//should hold query variables.  COOKIE is removed. No cookies in rest. 
		$return_obj->setRequestVars(array_diff($_REQUEST, $_COOKIE));
		//TODO - clean up. Do not care if get/post, etc. data should care for http content probably. not request variables encoded in the uri.   
		switch($request_method){
			case 'GET': 
				//$data = $_GET; 
				break; 
			case 'POST':
				//$data = $_POST; 
				break; 
			case 'PUT':
				parse_str(file_get_contents('php://input'), $put_vars);
				$data = $put_vars;
				break;  
		}
		
		//store the method
		$return_obj->setMethod($request_method); 
		if (isset($data)){
			//translate the JSON to an Object for use however you want
			$return_obj->setData($data); 
		}
		return $return_obj; 
	}
	
	public static function sendResponse($status = 200, $vars = array(), $body ='', $content_type = 'text/html'){
		$status_header= 'HTTP/1.1 ' . $status . ' ' . RestUtils::getStatusCodeMessage($status);
		//set the status
		header($status_header); 
		//set the content type
		header('Content-type: ' . $content_type . ' ; charset = utf-8'); 
		
		if ($body!=''){
			echo $body;
			exit; 
		}
		else{
			//create some body message
			$message = '';
		}

		switch($status){
			case 400: 
				$message = 'The request could not be understood';
				if (!isset($vars['unrecognized_req_vars'])){
					die ("Web service error, failed to comply to standards"); 
				}  
				$message = 'The following variables are not recognized: ' . implode(" ", $vars['unrecognized_req_vars']); 
				break;
			case 401: 
				$message = 'You must be authorized to view this page';
				break;
			case 404: 
				$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found'; 
				break;
			case 405 : //  
				//Standards specifies that we must include an ALllow field in the response with the methods supported by this resource. 
				$message = 'The request method ' . $_SERVER['REQUEST_METHOD'] . ' is not supported on this resource';
				if (!isset($vars['allow'])){
					die ("Web service error, failed to comply to standards."); 
				}
				header('Allow:'. implode( " ",$vars['allow'])); 
				break; 
			case 500: 
				$message = 'The server encountered an error processing your request.';
				break;
			case 501:
				$message = 'The requested method is not implemented.';
				break;
		}
		
		//servers don't always have a signature turned on(this is an apache directive "ServerSignature On")'
		$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . 'Servert at' . $_SERVER['SERVER_NAME'] . 'Port' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];  
	
	//this should be templatized in a real world solution 
	
	// this should be templatized in a real−world solution
$body = '<!DOCTYPE HTML PUBLIC ”−//W3C//DTD HTML 4.01//EN” ”http://www.w3.org/TR/html4/strict. dtd”>  ' . 
		'<html> <head> <meta http−equiv=” Content−Type” content=”text/html; charset=utf-8”>  <title>' . $status . ' ' .
          RestUtils::getStatusCodeMessage($status) . '</title> </head> <body> <h1>' . RestUtils::
			getStatusCodeMessage($status) . '</h1>
			<p>' . $message . '</p>
		<hr />
		<address>' . $signature . '</address>
		</body>
</html>';
echo $body;
exit;
}


public static function getStatusCodeMessage($status){
// these could be stored in a .ini ﬁle and loaded
// via parse ini ﬁle()... however, this will suﬃce
// for an example
$codes = Array(
100 => 'Continue',
101 => 'Switching Protocols',
200 => 'OK',
201 => 'Created',
202 => 'Accepted',
203 => 'Non−Authoritative Information',
204 => 'No Content',
205 => 'Reset Content',
206 => 'Partial Content',
300 => 'Multiple Choices',
301 => 'Moved Permanently',
302 => 'Found',
303 => 'See Other',
304 => 'Not Modiﬁed',
305 => 'Use Proxy',
306 => '(Unused)',
307 => 'Temporary Redirect',
400 => 'Bad Request',
401 => 'Unauthorized',
402 => 'Payment Required',
403 => 'Forbidden',
404 => 'Not Found',
405 => 'Method Not Allowed',
406 => 'Not Acceptable',
407 => 'Proxy Authentication Required',
408 => 'Request Timeout',
409 => 'Conﬂict',
410 => 'Gone',
411 => 'Length Required',
412 => 'Precondition Failed',
413 => 'Request Entity Too Large',
414 => 'Request−URI Too Long',
415 => 'Unsupported Media Type',
416 => 'Requested Range Not Satisﬁable',
417 => 'Expectation Failed',
500 => 'Internal Server Error',
501 => 'Not Implemented',
502 => 'Bad Gateway',
503 => 'Service Unavailable',
504 => 'Gateway Timeout',
505 => 'HTTP Version Not Supported'
);
return (isset($codes[$status])) ? $codes[$status] : '';
}
}

?>
