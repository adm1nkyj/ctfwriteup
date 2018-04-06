<?php if(!defined('simple_cms')) exit(); ?>
			<b>My Note list</b>
			<br/>
			<table border="1" align="center">
				<tr>
					<th>idx</th><th>to</th><th>read</th>
				</tr>
				<?php
					if(!$result){
						echo '<tr>';
						echo '<td>no</td>';
						echo '<td>no</td>';
						echo '<td>no</td>';
						echo '</tr>';
					}
					else{
						for($i=0; $i<count($result); $i++){
							$idx = "<a href='?act=note&mid=read&type=send&idx={$result[$i]['idx']}'&from={$result[$i]['from_id']}>{$result[$i]['idx']}</a>";
							$to_id = xss_block($result[$i]['to_id']);
							$read = $result[$i]['read_ck'] === 'o' ? 'o' : 'x';
							echo "<tr><td>{$idx}</td><td>{$to_id}</td><td>{$read}</td>";
						}
					}
				?>

			</table>
			<br/>
			<br/>
			<a href='index.php?act=note&mid=write'><b>write</b></a>