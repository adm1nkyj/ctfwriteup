<?php if(!defined('simple_cms')) exit(); ?>

			<form action='index.php?act=report&mid=write' id='form' method='POST' enctype='multipart/form-data'>
				title : <input type='text' name='title' style="width:500px"><br/>
				content : <textarea name='content' rows='10' style="width:500px"></textarea><br/>
				Image : <input type='file' name='image'><br/>
				<input type='submit' value="write" style="width:500px"><br/>
			</form>