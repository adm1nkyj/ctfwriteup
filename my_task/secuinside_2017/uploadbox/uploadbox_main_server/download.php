<?php	
	$con = mysqli_connect('localhost', 'root', 'apmsetup');
	mysqli_select_db($con, 'uploadbox');
	
	if(!is_string($_REQUEST['filehash']) || !$_REQUEST['filehash']) die('check your parameter :(');
	$filehash = addslashes($_REQUEST['filehash']);
	$query_result = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM myboxfile WHERE fileHash='{$filehash}'"), MYSQLI_ASSOC);
	if(!$query_result) die('not found');

	if($query_result['share'] === 'x'){
		if($_COOKIE['user_token'] !== sha1("@salt1111111!".$query_result['uploadUserId']."@salt22222222!")){
			die("you can't access file :(");
		}
	}
	$fn = $query_result['fileName'];
	$hash = $query_result['fileHash'];
	$uploader = $query_result['uploadUserId'];
	
	$url = "http://files.adm1nkyj-kuploadbox.com/secu_download.php?filehash=".$hash."&uploader=".$uploader;

	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "uploadbox bot");
    curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP+CURLPROTO_HTTPS+CURLPROTO_GOPHER);
    $content = curl_exec($ch);
    $filesize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if($httpcode === 500) die('500 server error');
    if($httpcode === 404) die('404 not found');
    if($httpcode === 400) die('400 bad request');
	if($content === 'no') die('file not found');
	
	if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
	    header("content-type: doesn/matter");
	    header("content-length: ".$filesize);
	    header("content-disposition: attachment; file
	    	name=\"$fn\"");
	    header("content-transfer-encoding: binary");
	} else {
	    header("content-type: file/unknown");
	    header("content-length: ".$filesize);
	    header("content-disposition: attachment; filename=\"$fn\"");
	    header("content-description: php generated data");
	}
	header("pragma: no-cache");
	header("expires: 0");
	
	echo $content;
?>