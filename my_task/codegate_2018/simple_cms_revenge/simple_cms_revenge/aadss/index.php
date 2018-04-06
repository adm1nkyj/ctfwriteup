<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);

	define('simple_cms', true);
	session_start();
	if(!is_file('./data/config.php')){
		header('Location: install/');
		exit();	
	}
	include('./data/config.php');
	include('./config/config.inc.php')	;

	$Context = Context::getInstance();
	$Context->init();
	
	$Handler = new Handler();
	if($Handler->init()){
		include(CMS_PATH . 'header.php');
		$Handler->mainModule();
		include(CMS_PATH . 'tail.php');
	}
	else{
		exit('error');
	}
?>

