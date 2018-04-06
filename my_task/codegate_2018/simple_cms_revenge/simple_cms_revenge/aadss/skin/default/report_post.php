<?php
	if(!defined('simple_cms')) exit();
	echo '<br/><br/>';
	echo '<b>title</b> : '.xss_block($result['title']).'<br/>';
	echo '<b>content</b> : <br/>'.xss_block($result['content']);
	if($result['file']){
		echo '<br/><img src="download.php?idx='.$result['idx'].'&board=report&token='.$result['token'].'">';
	}
	echo '<br/><br/><br/>';
	echo str_repeat('=',50);
	echo '<br/><br/><br/>';
	echo '<b>';
	if($result['reply']){
		echo xss_block($result['reply']);
	}
	else{
		echo 'not yet';
	}
	echo '</b>';
?>