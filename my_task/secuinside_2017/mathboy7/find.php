<?php
	$i = 0;
	while(true){
		$tmp = crypt($i, 'AD');	

		if(preg_match('/admin/i', $tmp)){
			echo "find : ".$tmp;
			break;

		}
		$i++;
	}
	echo "\ni : ".$i."\n";
?>