<?php
	function rand_str($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	function do_get_image($url){
		if(!security::check_image_url($url)) security::alert('check url');
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url );
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_USERAGENT, "uploadbox bot");
	    curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP+CURLPROTO_HTTPS+CURLPROTO_GOPHER);
	    $data = curl_exec($ch);
	    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($http_status === 404){
			return 'error! 404 not found';
		}
		return $data;
	}
?>