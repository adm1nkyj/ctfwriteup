<?php
	if(!defined('simple_cms')) exit();
	class File{
		function __construct(){
			if(!is_login()){
				alert('login first', 'back');
			}
		}
		function Download($idx, $token, $board){
			if(!$idx || !$token || !$board){
				alert('check your parameter', 'back');
			}
			$query = array(
				'idx' => $idx,
				'token' => $token
			);			
			$result = DB::fetch_row($board, $query, 'and');

			if(!$result)
				alert('not found', 'back');
			return $result;
		}
	}