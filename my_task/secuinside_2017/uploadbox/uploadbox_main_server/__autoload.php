<?php
	function class_loader($classname){
		include('./uploadbox_class/'.$classname.'.php');
	}
	spl_autoload_register('class_loader')
?>