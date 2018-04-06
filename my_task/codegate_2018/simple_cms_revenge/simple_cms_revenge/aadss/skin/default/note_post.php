<?php
	if(!defined('simple_cms')) exit();
	echo '<b>content</b> : <br/>'.xss_block($result['content']);
	if($result['file']){
		echo '<br/><img src="download.php?idx='.$result['idx'].'&board=note&token='.$result['token'].'">';
	}
	echo '<br/><br/><br/>';
	echo str_repeat('=',50);
	echo '<br/><br/><br/>';
	echo '<b>';
	echo '<a href="?act=note&mid=write&to_id='.xss_block($result['from_id']).'">reply</a>';
	echo '</b>';
	if($type === 'recv'){
		if($result['read_ck'] === 'x'){
			$replace = array(
				'read_ck' => 'o'
			);
			$query = array(
				'idx' => $result['idx']
			);
			DB::update('note', $replace, $query);
		}
	}
?>