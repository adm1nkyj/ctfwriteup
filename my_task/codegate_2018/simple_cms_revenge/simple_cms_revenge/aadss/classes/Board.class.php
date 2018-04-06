<?php
	if(!defined('simple_cms')) exit();	
	class Board extends Board_lib{
		function __construct(){
			if(!is_login()){
				alert('login first', 'back');
			}
		}
		function Default(){
			$result = DB::fetch_multi_row('board', '', '' , '0, 15', 'idx desc');
			include(CMS_SKIN_PATH . 'board.php');
		}
		function action_write(){
			if($_SERVER['REQUEST_METHOD'] === 'GET'){
				include(CMS_SKIN_PATH . 'write.php');
			}
			else if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$this->do_write();	
			}
			else{
				alert('~_~', './');
			}
		}
		function action_search(){
			$column = Context::get('col');
			$search = Context::get('search');
			$type = strtolower(Context::get('type'));
			$operator = 'or';
			
			if($type === '1'){
				$operator = 'or';
			}
			else if($type === '2'){
				$operator = 'and';
			}
			if(preg_match('/[^a-zA-Z0-9\|]/is', $column)){
				$column = 'title';
			}
			$query = get_search_query($column, $search, $operator);
			$result = DB::fetch_multi_row('board', '', '', '0, 10','idx desc', $query);
			include(CMS_SKIN_PATH . 'board.php');
		}
		function action_delete(){
			$idx = Context::get('idx');
			if(!$idx)
				alert('not found', 'back');
			$query = array('idx'=>$idx);

			$result = DB::fetch_row('board', $query);
			if(!$result)
				alert('not found', 'back');
			if($result['id'] !== $_SESSION['id'])
				alert('you don\'t have permission', 'back');
			
			$result = DB::delete('board', $query);

			if($result)
				alert('delete!', './');
			else
				alert('error..?', 'back');

		}
		function action_edit(){
			$idx = Context::get('idx');
			if(!$idx)
				alert('not found', 'back');
			
			$query = array('idx'=>$idx);
			$result = DB::fetch_row('board', $query);

			if(!$result)
				alert('not found', 'back');
			if($result['id'] !== $_SESSION['id'])
				alert('you don\'t have permission', 'back');
			$edit_mode = true;
			if($_SERVER['REQUEST_METHOD'] === 'GET'){
				include(CMS_SKIN_PATH . 'write.php');
			}
			else if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$this->do_edit();	
			}
			else{
				alert('~_~', './');
			}

		}
		function action_read(){
			$idx = Context::get('idx');
			if(!$idx)
				alert('not found', 'back');
			$query = array('idx'=>$idx);

			$result = DB::fetch_row('board', $query);
			if(!$result)
				alert('not found', 'back');
			include(CMS_SKIN_PATH . 'post.php');	
		}
	}
?>