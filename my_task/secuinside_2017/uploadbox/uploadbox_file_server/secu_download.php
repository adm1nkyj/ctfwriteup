<?php
	error_reporting(0);
	ob_end_clean();

	$filehash = $_GET['filehash'];
	$uploader = $_GET['uploader'];


	if(!is_string($filehash) || !is_string($uploader)) die('no');
	if(preg_match('/[^a-f0-9]/is', $filehash) || preg_match('/[^a-z0-9_]/is', $uploader)) die('no');
	
	$filePath = './secu_upload_dir/uploadbox_files/'.$uploader.'/'.$filehash;
	if(file_exists($filePath)){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$filehash");
		header("Cache-Control: public");
		header("Content-length: " . filesize($filePath));
		header("Pragma: no-cache");
		header("Expires: 0");

		$content = "";
		$download_rate = 10;
		flush();
		$fp = fopen($filePath, 'rb');
		while(!feof($fp)){
			print fread($fp, round($download_rate * 1024));
			flush();
			usleep(1000);
		}
		fclose($fp);
		flush();
	}
	else{
		echo 'no';
	}
?>