<?php
	class uploadbox_member{
		public function do_login(){
			if($_SESSION['loginID']){
				echo "<script>alert('already login'); history.go(-1);</script>";
				return false;
			}
			$url = $_REQUEST['returnURL'];
			$id = security::escape_str($_REQUEST['id'], 'sql');
			$pw = $_REQUEST['pw'];
			$login_bool = false;
			if($id && $pw && $url){
				$pw = sha1($pw.'thisissaltlol!!');
				$query_result = uploadbox_mysql::select_query("loginID='{$id}' and loginPW='{$pw}'", "member");
				if(!$query_result['loginID']){
					echo "<script>alert('login fail..'); history.go(-1);</script>";
					return false;
				}
				foreach ($query_result as $key => $value) {
					$_SESSION[$key] = security::escape_str($value, "sql");
				}

				if($_SESSION['loginID']){
					setcookie("user_token", sha1("@salt1111111!".$_SESSION['loginID']."@salt22222222!"), time()+3600, "/", "adm1nkyj-kuploadbox.com");
					if(security::check_return_url($url)){
						header('Location: '.$url);
					}
					else{
						header('Location: index.php');
					}
				}
				else{
					echo 'login false';
				}
			}
			else{
				echo "<script>alert('plz check parameter'); location.href='index.php?ad=member&page=login';</script>";
				return false;
			}
		}
		public function do_register(){
			if($_SESSION['loginID']){
				echo "<script>alert('already login'); history.go(-1);</script>";
				return false;
			}
			$id = security::escape_str($_REQUEST['id'], 'sql');
			$pw = security::escape_str($_REQUEST['pw'], 'sql');
			$nick = security::escape_str($_REQUEST['nick'], 'sql');

			if($id && $pw && $nick){
				if(strlen($id) > 10 || strlen($nick) > 10){
					echo "<script>alert('long parameter'); history.go(-1);</script>";
					return false;
				}
				if(preg_match("/[^a-z0-9_]/is", $id) || preg_match("/[^a-z0-9_]/is", $nick)){
					echo "<script>alert('nick and id only allow a-z0-9_'); history.go(-1);</script>";
					return false;
				}
				if(uploadbox_mysql::select_query("loginID='{$id}' or userNick='{$nick}'", "member")){
					echo "<script>alert('nick or id already exists'); history.go(-1);</script>";
					return false;
				}
				$input = array(
							'userNick' => $nick,
							'loginID' => $id,
							'loginPW' => sha1($pw.'thisissaltlol!!'),
							'userIP' => $_SERVER['REMOTE_ADDR'],
							'userImage' => 'http://files.adm1nkyj-kuploadbox.com/files/base_image.jpg',
							'lastLogin' => time()
						);

				if(uploadbox_mysql::insert_query($input, 'member')){
					echo "<script>alert('register success'); location.href='index.php';</script>";
				}
				return false;
			}
			else{
				echo "<script>alert('plz check parameter'); history.go(-1);;</script>";
			}
			return false;

		}
		public function do_profile(){
			if(!$_SESSION['loginID']){
				security::alert('plz login first');
			}
			if(!$_REQUEST['pw'] || !$_REQUEST['nick'] || !$_REQUEST['profile']) die('error! check parameters');

			$pw = sha1($_REQUEST['pw'].'thisissaltlol!!');
			$nick = security::escape_str($_REQUEST['nick'], 'sql');
			$imageURL = $_REQUEST['profile'];

			if(strlen($nick) > 10) die("<script>alert('long parameter'); history.go(-1);</script>");
			if(!is_string($pw) || !is_string($imageURL) || !is_string($nick)) die('error! some wrong');
			if(!security::check_image_url($imageURL)) die('error! check image url');
			if(preg_match("/[^a-z0-9_]/is", $nick)) die('error! check nick name only allow [a-z0-9_]');
			if(uploadbox_mysql::select_query("userNick='{$nick}'", "member")) die('error! nick already exists');

			$image = do_get_image($imageURL);
			if($image === 'error! 404 not found') die('error! 404 not found');
			if(!security::check_image_file($image)) die('error! check file type');
			
			$condition = "loginID='{$_SESSION['loginID']}'";
			$table = "member";
			$update = array("loginPW"=>$pw, "userNick"=>$nick, "userImage"=>$imageURL);

			if(uploadbox_mysql::update_query($condition, $table, $update)){
				die('update');
			}
			else{
				die('error! update error');
			}
			return false;
		}
		public function do_logout(){
			session_destroy();
			header('Location: index.php');
		}
		public static function default_page(){
			$page = $_REQUEST['page'];
			if($page && !$_SESSION['loginID']){
				if($page === 'login'){
					$referer = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : 'index.php';
					echo 'do you want login?';
					echo <<<END
<br/>
<form action="?ad=member&mi=login" method="POST">
	<input type="text" name="id">
	<input type="text" name="pw">
	<input type="hidden" id="returnURL" name="returnURL" value="">
	<input type="submit" name="send" value="login">
</form>
END;
				}
				else if($page === 'register'){
					echo <<<END
<br/>
<form action="?ad=member&mi=register" method="POST">
	id : <input type="text" name="id"><br/>
	pw : <input type="text" name="pw"><br/>
	nick : <input type="text" name="nick"><br/>
	<input type="submit" name="send" value="register">
</form>
END;
				}
				else{
					header('Location: index.php?ad=member');
				}
			}
			else{
				if($_SESSION['loginID']){
					if($page === 'profile'){
						echo <<<END
<br/>
	pw : <input type="text" name="pw"><br/>
	nick : <input type="text" name="nick" value="{$_SESSION['userNick']}"><br/>
	profile : <input type="file" id="profile" name="profile" value="{$_SESSION['userImage']}" onchange="image_upload(this, $('#cma_image'));"><br/>
	<div id="cma_image" style="width:100%;max-width:100%;border:1px solid #000;display:none;"></div><br/>
	<input type="button" id="profileupdate" value="update">
END;
					}
					else{
						header('Location: index.php?ad=member&page=profile');
					}
				}
				else{
					echo 'login plz or register plz<br/>';
					echo '<a href="index.php?ad=member&page=login">login</a> | <a href="index.php?ad=member&page=register">register</a>';
				}
			}
			return false;
		}
	}
?>
