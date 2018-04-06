<?php
	if(!defined('simple_cms')) exit();
	function str_check($str, $type){
		if($type === 'id'){
			if(!preg_match('/[^a-z0-9]/', $str) && strlen($str) >= 3 && strlen($str)<=10){
				return true;
			}
		}
		else if($type === 'email' && strlen($str) <= 50){		
			if(filter_var($str, FILTER_VALIDATE_EMAIL)){
				return true;
			}
		}
		return false;
	}
	function get_search_query($column, $search, $operator){
		$column = explode('|', $column);
		$result = '';
		for($i=0; $i<count($column); $i++){
			if(trim($column[$i]) === ''){
				continue;				
			}
			$result .= " LOWER({$column[$i]}) like '%{$search}%' {$operator}";
		}
		$result = trim(substr($result, 0 , strrpos($result, $operator)));
		return $result;
	}
	function xss_block($str){
		return htmlspecialchars($str, ENT_QUOTES);
	}
	function check_image($path){
		$info = getimagesize($path);
		$file_type = $info['mime'];
		$allow_list = array('image/png', 'image/jpeg', 'image/jpg');

		if(!in_array(strtolower($file_type), $allow_list)) return false;

		return true;
	}
	function check_filename($fn){
		$fn = preg_replace('/[^a-z0-9A-Z\.]/i', '', $fn);	
		if(preg_match("/\.(ph|htm|py|rb|ruby|jsp|asp|cgi|ht|htaccess)/is", $fn)){
			return false;
		}
		return $fn;
	}
	function set_filename($fn){
		$fn = array_pop(explode('.', $fn));
		$fn = bin2hex(rand_str(15)) . '_'. ip2long($_SERVER['REMOTE_ADDR']) . '.' . $fn;

		return $fn;
	}
	function rand_str($length = 10) {
	    $char_list = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $_length = strlen($char_list);
	    $result = '';
	    for ($i = 0; $i < $length; $i++) {
	        $result .= $char_list[rand(0, $_length - 1)];
	    }
	    return $result;
	}
	function is_login(){
		if($_SESSION['is_login']){
			return true;
		}
		return false;
	}
	function get_class_list($path){
		$result = array();
		$i = 0;
		foreach (scandir($path) as $file) {
			if($file === '.' || $file === '..'){
				continue;
			}
			$result[$i++] = strtolower(substr($file, 0, strpos($file, '.')));
		}
		return $result;
	}
	function alert($msg, $move=''){
		$msg = str_replace("'", "\\'", $msg);
		$result = '<script>';
		$result .= 'alert(\''.$msg.'\');'; 
		if($move && $move !== 'back'){
			$result .= 'location.href=\''.$move.'\';';
		}
		else if($move === 'back'){
			$result .= 'history.back();';
		}
		$result .= '</script>';
		exit($result);
	}
?>