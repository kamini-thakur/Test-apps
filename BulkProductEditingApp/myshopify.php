<?php

	function generateURL($shop_domain,$api_key,$password) {
	
	$url = 'https://'.$api_key.':'.$password.'@'.$shop_domain;
	return $url;
	}
	
	function initiate_request($shop_url, $request_type,$resource_type, $data_string) {
	
	$request_url = $shop_url.$resource_type;
	
	$curl_response = initiate_curl_request($request_url,$request_type, $data_string);
	return $curl_response;
		
	}
	
	
	function initiate_curl_request($request_url,$request_type, $data_string) {
	$ch = curl_init($request_url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	if($request_type == 'GET') {
	curl_setopt($ch,CURLOPT_HTTPGET, 1);
	
	}
	else if($request_type == 'POST') 
	{
	curl_setopt($ch,CURLOPT_POST, 1);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data_string);
	}
     elseif ($request_type== 'PUT') {
     	# code...
     	 
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
          curl_setopt($ch,CURLOPT_POSTFIELDS,$data_string);
     }
	curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

	$output = curl_exec($ch);
    var_dump(curl_error($ch));
	return json_decode($output, TRUE);
	}
	
	
	
	function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}
	 