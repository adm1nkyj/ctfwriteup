<?php
	class uploadbox_mybox{
		public function __construct(){
			if(!$_SESSION['loginID']) die('<script>alert("plz login first");location.href="index.php?ad=member&page=login";</script>' );
    	}
		public static function default_page(){
			echo <<<END
my file list<br/>
<form action="upload.php" method="POST" enctype="multipart/form-data">
	<input type="file" name="file">
	<input type="hidden" name="type" value="uploadbox">
	<input type="submit" value="upload">
</form>
<br/>
END;
			$query = "uploadUserId='{$_SESSION['loginID']}';";
			$query_result = uploadbox_mysql::select_fetch_query($query, "myboxfile");
			echo "<br/><br/>";
			if($query_result){
				for($i=0; $i<count($query_result); $i++){	
					$query_result[$i]['fileName'] = security::escape_str($query_result[$i]['fileName'], 'html');
					echo "File : <a href='download.php?filehash={$query_result[$i]['fileHash']}'>{$query_result[$i]['fileName']}</a> | <a href=''><br/>\n";
				}
			}
			else{
				echo "plz upload file XD";
			}
			return false;
		}
	}
?>