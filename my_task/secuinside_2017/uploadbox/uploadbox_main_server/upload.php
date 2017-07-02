<?php
	error_reporting(0);
	session_start();

	include('uploadbox_lib/security.php');
	include('uploadbox_lib/util.php');

	if(!$_SESSION['loginID']) die('error! plz login first');

	if(!$_FILES) die('error! check your parameter :(');

	$type = $_REQUEST['type'];
	$fileName = security::escape_str($_FILES['file']['name'], 'sql');
	$fileHash = sha1(rand_str().$fileName.rand_str());
	$filePath = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];
	$date = time();
	$share = $_REQUEST['share'] ? $_REQUEST['share'] : 'x';
	if($fileSize > 2000000) die('error! allow 2m file');
	if($type === 'profile'){
		$info = getimagesize($filePath);
		$file_type = $info['mime'];
		$allow_list = array('image/png', 'image/jpeg', 'image/jpg');
		if(!in_array(strtolower($file_type), $allow_list)) die('error! only allow png, jpg');
	}
	else{
		$type === 'uploadbox';
	}

	if($type === 'profile'){
		$share = 'x';
	}
	else{
		if($share === 'o' || $share === 'x') $share = 'x';
	}

	$content = "";
	$download_rate = 10;
	$fp = fopen($filePath, 'rb');
	while(!feof($fp)){
		$content .= fread($fp, round($download_rate * 1024));
		usleep(1000);
	}
	fclose($fp);

	$target_url = 'http://files.adm1nkyj-kuploadbox.com/secu_savefile.php';

    $send_filename = $fileHash;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$target_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $args['type'] = $type;
    $args['userID'] = $_SESSION['loginID'];
    $args['file'] = new CurlFile($filePath, $fileType, $send_filename);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args); 
    $result = curl_exec($ch);
	curl_close ($ch);
	
	if($result !== 'error'){
		if($type === 'profile'){
			die($result);
		}
		else{
			$con = mysqli_connect('localhost', 'root', 'apmsetup');
			mysqli_select_db($con, 'uploadbox');

			$query = "INSERT INTO myboxfile (uploadUserId, uploadUserNick, fileName, fileHash, share, uploadDate, userIP) VALUES ('{$_SESSION['loginID']}', '{$_SESSION['userNick']}', '{$fileName}', '{$fileHash}', '{$share}', '{$date}', '{$_SERVER['REMOTE_ADDR']}');";
			if(mysqli_query($con, $query)){
				security::alert('upload success');
			}
			else{
				die(mysqli_error($con));
			}
		}
	}
	else die('error! upload error');

?>