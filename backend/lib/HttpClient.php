<?php

 
 /**
  * Check a curl response code. If is not a valid response return false. 
  */
 function checkCurlResponse($ch){
 	$info = curl_getinfo($ch);

 	return isset($info['http_code']) && $info['http_code'] == 200;
 }
function getCurlContentType($ch){
	$info = curl_getinfo($ch);
	if (isset($info['content_type']))
		return $info['content_type']; 	
}

 /**
  * Get a image from an url through curl
  * Returns an associate array with the following : 
  * type : the type of the image. 
  * imagem : the image.
  * Null in case of problems.  
  */
 function getImage($uri){
   $ch= curl_init();
   curl_setopt($ch, 
      CURLOPT_URL, 
      $uri);
 	curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);

   $response = curl_exec($ch);
   
   $info = curl_getinfo($ch);
   
   if (!checkCurlResponse($ch)) return null;
   $result['type'] = getCurlContentType($ch);
   if ($result['type'] == null) return null;
   $result['image'] = addslashes($response);
   return $result;
  }
    

 function getUrlContent($uri, $headers =null){
   // is curl installed?
   if (!function_exists('curl_init')){ 
      die('CURL is not installed!');
   }
   // get curl handle
   $ch= curl_init();
   // set request url
   curl_setopt($ch, 
      CURLOPT_URL, 
      $uri);
	
   curl_setopt($ch, CURLOPT_HEADER, 0); 
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 	
   curl_setopt($ch, 
      CURLOPT_RETURNTRANSFER, 
      true);

   $response = curl_exec($ch);
   if (!checkCurlResponse($ch)) return null;  
   curl_close($ch);
   return $response;
 }
 ?>