<?php 
	class uploadbox_default{
		function default_page(){
			if(!$_SESSION['loginID']){
				header('Location: index.php?ad=member');
				return false;
			}
			$result = uploadbox_mysql::select_query("loginID='{$_SESSION['loginID']}'", "member");
			echo 'main page<br/>';
			echo <<<END
<a href='?ad=mybox'>MyBox</a> | <a href='?ad=member'>Profile</a> | <a href='?ad=member&mi=logout'>logout</a><br/><br/><br/><br/>
<img src='{$result['userImage']}' width='500' heigth='500'><br/>
Hello {$result['userNick']}
END;
			return false;
		}
	}
?>
