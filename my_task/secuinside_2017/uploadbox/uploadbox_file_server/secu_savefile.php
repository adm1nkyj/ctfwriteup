<?php
	error_reporting(0);

	$uploader = $_POST['userID'];
	$type = $_POST['type'];
	
	if(!is_string($_FILES['file']['name']) || !is_string($uploader)) die('error');
	if(preg_match('/[^a-f0-9]/is', $_FILES['file']['name']) || preg_match('/[^a-z0-9_]/is', $uploader)) die('error');

	if($type === 'profile')
		$upload_mode = 'profile';
	else
		$upload_mode = 'uploadbox_files';

	$dirPath = '/secu_upload_dir/'.$upload_mode.'/'.$uploader;

	if($type === 'profile'){
		$info = getimagesize($_FILES['file']['tmp_name']);
		$file_type = $info['mime'];
		$allow_list = array('image/png', 'image/jpeg', 'image/jpg');
		if(!in_array(strtolower($file_type), $allow_list)) die('error');
	}
	if(!is_dir('.'.$dirPath))
		mkdir('.'.$dirPath, 0777);

	if(move_uploaded_file($_FILES['file']['tmp_name'], '.'.$dirPath.'/'.$_FILES['file']['name']))
		if($type === 'profile')
			die('http://'.$_SERVER['HTTP_HOST'].$dirPath.'/'.$_FILES['file']['name']);
		else
			die('ok');
	else
		die('error');
?>