<?php if(!defined('simple_cms')) exit(); ?>
		<?php 
			if(!$edit_mode){
		?>
			<form action='index.php?act=board&mid=write' id='form' method='POST'>
				title : <input type='text' name='title' style="width:500px"><br/>
				content : <textarea name='content' rows='10' style="width:500px"></textarea><br/>
				<input type='submit' value="write" style="width:500px"><br/>
			</form>
		<?php
			}
			else{
		?>
			<form action='index.php?act=board&mid=edit&idx=<?=$idx;?>' id='form' method='POST'>
				title : <input type='text' name='title' style="width:500px" value='<?=xss_block($result['title']);?>'><br/>
				content : <textarea name='content' rows='10' style="width:500px"><?=xss_block($result['content']);?></textarea><br/>
				<input type='submit' value="write" style="width:500px"><br/>
			</form>
		<?php
			}
		?>
