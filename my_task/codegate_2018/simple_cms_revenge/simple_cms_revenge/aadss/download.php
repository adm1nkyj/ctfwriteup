<?php
	error_reporting(0);
	session_start();
	define('simple_cms', true);
	if(!is_file('./data/config.php')){
		header('Location: install/');
		exit();	
	}
	include('./data/config.php');
	include('./config/config.inc.php');
	ob_end_clean();

	$board = $_GET['board'];
	$idx = (int)$_GET['idx'];
	$token = $_GET['token'];

	if(!is_login()){
		alert('login first', 'back');
	}
	if(preg_match('/[^a-zA-Z0-9]/is', $board) || preg_match('/[^a-zA-Z0-9]/is', $token)){
		alert('are you hacker?', 'back');
	}

	$Handler = new Handler();
	$Handler->init();

	$file = File::Download($idx, $token, $board);
	$fn = 'image.png';
	$file = CMS_UPLOAD_PATH.$board.'/'.$file['file'];

	if(!is_file($file) || !file_exists($file)){
		alert('file not found', 'back');
	}
	if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
	    header("content-type: doesn/matter");
	    header("content-length: ".filesize("$file"));
	    header("content-disposition: attachment; filename=\"$fn\"");
	    header("content-transfer-encoding: binary");
	} else {
	    header("content-type: file/unknown");
	    header("content-length: ".filesize("$file"));
	    header("content-disposition: attachment; filename=\"$fn\"");
	    header("content-description: php generated data");
	}
	header("pragma: no-cache");
	header("expires: 0");
	flush();

	$fp = fopen($file, 'rb');

	$download_rate = 10;

	while(!feof($fp)) {
	    print fread($fp, round($download_rate * 1024));
	    flush();
	    usleep(1000);
	}
	fclose ($fp);
	flush();

?>