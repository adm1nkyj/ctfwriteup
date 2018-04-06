<?php
	if(!defined('simple_cms')) exit();
	class Report extends Report_lib{
		function __construct(){
			if(!is_login()){
				alert('login first', '?act=user&mid=login');
			}
		}
		function Default(){	
			$query = array(
				'id'=>$_SESSION['id']
			);
			$result = DB::fetch_multi_row('report', $query, '', '0, 15', 'idx desc');
			include(CMS_SKIN_PATH . 'report.php');
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

			$query = "id='{$_SESSION['id']}' and ".$query;
			$result = DB::fetch_multi_row('report', '', '', '0, 10','idx desc', $query);
			include(CMS_SKIN_PATH . 'report.php');
		}
		function action_read(){
			$idx = Context::get('idx');
			if(!$idx)
				alert('not found', 'back');
			
			$query = array(
				'idx' => $idx,
				'id'  => $_SESSION['id']
			);

			$result = DB::fetch_row('report', $query, 'and');
			if(!$result)
				alert('not found', 'back');			
			include(CMS_SKIN_PATH . 'report_post.php');	
		}
		function action_write(){
			if($_SERVER['REQUEST_METHOD'] === 'GET'){
				include(CMS_SKIN_PATH . 'report_write.php');
			}
			else if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$this->do_write();	
			}
			else{
				alert('~_~', './');
			}
		}
	}
?>