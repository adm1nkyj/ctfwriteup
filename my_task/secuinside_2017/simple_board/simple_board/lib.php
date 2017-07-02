<?php #lib.php
	function str_escape($argv){
		if(is_array($argv)){
			foreach ($argv as $key => $value) {
				if(is_array($value)){
					$array[$key] = str_escape($value);
				}
				else{
					$array[$key] = addslashes($value);
				}
			}
		}
		else{
			$array = addslashes($argv);
		}
		return $array;
	}
	function sqli_block($argv){
		$pattern = '/^select.*from.*where.*`?information_schema`?.*$/is';
		if(preg_match($pattern, $argv)) alert('hack me if you can');
		return $argv;
	}
	function xss_block($argv){
		return htmlspecialchars($argv, ENT_QUOTES);
	}
	function login_check(){
		if($_SESSION['id']){
			return true;
		}
		return false;
	}
	function alert($msg){
		die('<script>alert("'.$msg.'");history.back(-1);</script>');
		return false;
	}
	function vaild_str($str){
		if(strlen($str) > 11) return false;
		if(preg_match('/[^a-z0-9_]/', $str)) return false;
		return true;
	}
?>