<?php
	class security{
		public static function class_check($class_name){
			if ($dh = opendir('./uploadbox_class/')){
    			while (($file = readdir($dh)) !== false){
    				if(explode('.php', $file)[0] === $class_name){
    					return $class_name;
    				}
    			}
    			closedir($dh);
			}
			return 'uploadbox_default';
		}
		public static function escape_str($str, $mode){
			if($mode === 'html'){
				return htmlspecialchars($str, ENT_QUOTES);
			}
			else if($mode === 'sql'){
				return addslashes($str);
			}
		}
		public static function alert($msg){
        	die( '<script> alert("' . $msg . '");window.history.back(-1);</script>' );
    	}
		public static function check_image_url($url){
			$url_info = parse_url($url);
			if($url_info['user'] || $url_info['fragment']) return false;
			if($url_info['scheme'] === 'http' || $url_info['scheme'] === 'https'){
				if(!preg_match("/[^a-zA-Z\.\-0-9]/is", $url_info['host']) && preg_match("/^([a-zA-Z-]+\.)?adm1nkyj-kuploadbox\.com$/is", $url_info['host'])){
					return true;
				}
			}
			return false;
		}
		public static function check_image_file($content){
			$info = getimagesizefromstring($content);
			$file_type = $info['mime'];
			$allow_list = array('image/png', 'image/jpeg', 'image/jpg');
			if(!in_array(strtolower($file_type), $allow_list)) return false;
			
			return true;
		}
		public static function check_return_url($url){
			$url_info = parse_url($url);
			if($url_info['user'] || $url_info['fragment']) return false;
			if($url_info['scheme'] === 'http' || $url_info['scheme'] === 'https'){
				if(!preg_match("/[^a-zA-Z\.\-0-9]/is", $url_info['host']) && preg_match("/([a-zA-Z-]+\.)?adm1nkyj-kuploadbox\.com$/is", $url_info['host'])){
					return true;
				}
			}
			return false;			
		}
	}
?>
