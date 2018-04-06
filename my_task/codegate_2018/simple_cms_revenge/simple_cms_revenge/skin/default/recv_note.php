<?php if(!defined('simple_cms')) exit(); ?>
			<b>My Note list</b>
			<br/>
			<table border="1" align="center">
				<tr>
					<th>idx</th><th>from</th>
				</tr>
				<?php
					if(!$result){
						echo '<tr>';
						echo '<td>no</td>';
						echo '<td>no</td>';
						echo '</tr>';
					}
					else{
						for($i=0; $i<count($result); $i++){
							$idx = "<a href='?act=note&mid=read&type=recv&idx={$result[$i]['idx']}'&from={$result[$i]['from_id']}>{$result[$i]['idx']}</a>";
							$from_id = xss_block($result[$i]['from_id']);
							echo "<tr><td>{$idx}</td><td>{$from_id}</td>";
						}
					}
				?>

			</table>
			<br/>
			<br/>
			<a href='index.php?act=note&mid=write'><b>write</b></a>