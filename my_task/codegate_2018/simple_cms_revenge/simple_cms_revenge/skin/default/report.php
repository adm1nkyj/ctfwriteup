<?php if(!defined('simple_cms')) exit(); ?>
			<b>My report list</b>
			<br/>
			<table border="1" align="center">
				<tr>
					<th>idx</th><th>title</th><th>reply</th><th>date</th>
				</tr>
				<?php
					if(!$result){
						echo '<tr>';
						echo '<td>Did</td>';
						echo '<td>you</td>';
						echo '<td>find</td>';
						echo '<td>a bug?</td>';
						echo '</tr>';
					}
					else{
						for($i=0; $i<count($result); $i++){
							$idx = "<a href='index.php?act=report&mid=read&idx={$result[$i]['idx']}'>{$result[$i]['idx']}</a>";
							$title = xss_block($result[$i]['title']);
							$reply = $result[$i]['reply'] ? 'o' : 'x';
							echo "<tr><td>{$idx}</td><td>{$title}</td><td>{$reply}</td><td>{$result[$i]['date']}</td>";
						}
					}
				?>

			</table>
			<br/>
			<form action='index.php' method='GET'>
					Search : 
					<input type='hidden' name='act' value='report'>
					<input type='hidden' name='mid' value='search'>
					<input type='hidden' name='col' value='title'>
					<select name="type">	
  						<option value="1">or</option>
  						<option value="2">and</option>
					</select>
					<input type='text' name='search' value=''>
					<input type='submit' value='search!'>
				</form>
			<br/>
			<br/>
			<a href='index.php?act=report&mid=write'><b>write</b></a>