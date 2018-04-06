<?php
	if(!defined('simple_cms')) exit();
	class Note extends Note_lib{
		function __construct(){
			if(!is_login()){
				alert('login first', '?act=user&mid=login');
			}
		}
		function Default(){	
			include(CMS_SKIN_PATH . 'note.php');
		}
		function action_recv(){	
			$query = array(
				'to_id' => $_SESSION['id']
			);
			$result = DB::fetch_multi_row('note', $query, '', '15', 'idx desc');
			include(CMS_SKIN_PATH . 'recv_note.php');
		}
		function action_sent(){	
			$query = array(
				'from_id' => $_SESSION['id']
			);
			$result = DB::fetch_multi_row('note', $query, '', '15', 'idx desc');
			include(CMS_SKIN_PATH . 'sent_note.php');
		}
		function action_read(){
			$type = Context::get('type');
			$query = array('idx'=>(int)Context::get('idx'));

			if($type === 'recv'){
				$query['to_id'] = $_SESSION['id'];
			}
			else if($type === 'send'){
				$query['from_id'] = $_SESSION['id'];
			}
			else{
				alert('invalid type', 'back');
			}
			$result = DB::fetch_row('note', $query, 'and');
			include(CMS_SKIN_PATH . 'note_post.php');
		}
		function action_write(){	
			$to_id = Context::get('to_id');
			if($_SERVER['REQUEST_METHOD'] === 'GET'){
				include(CMS_SKIN_PATH . 'note_write.php');
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