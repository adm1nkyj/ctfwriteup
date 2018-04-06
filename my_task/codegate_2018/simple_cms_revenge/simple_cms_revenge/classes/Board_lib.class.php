<?php
	if(!defined('simple_cms')) exit();
	class Board_lib{
		function do_write(){
			$title = Context::get('title');
 			$content = Context::get('content');
			$id = $_SESSION['id'];
			if(!$title || !$content)
				alert('check your parameter', 'back');
			$query = array(
				'title'=>$title,
				'content'=>$content,
				'id'=>$id,
				'date'=>date('Y-m-d h:i:s')
			);
			if(DB::insert('board', $query)){
				alert('write!', 'index.php?act=board&mid=Default');
			}
			else{
				alert('some error!', 'back');
			}
		}
		function do_edit(){
			$title = Context::get('title');
			$content = Context::get('content');
			$id = $_SESSION['id'];

			if(!$title || !$content)
				alert('check your parameter', 'back');
			$replace = array(
				'title'=>$title,
				'content'=>$content,
				'date'=>date('Y-m-d h:i:s')
			);

			$query = array(
				'idx'=>Context::get('idx'),
				'id' =>$_SESSION['id']
			);

			if(DB::update('board', $replace, $query, 'and'))
				alert('edit', '?act=board&mid=read&idx='.Context::get('idx'));
			else
				alert('error', 'back');
		}
	}
?>