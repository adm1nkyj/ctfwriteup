<?php if(!defined('simple_cms')) exit(); ?>
			
			<form action='index.php?act=note&mid=write' id='form' method='POST' enctype='multipart/form-data'>
				content : <textarea name='content' rows='10' style="width:500px"></textarea><br/>
				Image : <input type='file' name='image'><br/>
				to : <input type='text' name='to_id' value='<?=($to_id ? xss_block($to_id) : '')?>'><br/>
				<input type='submit' value="write" style="width:500px"><br/>
			</form>