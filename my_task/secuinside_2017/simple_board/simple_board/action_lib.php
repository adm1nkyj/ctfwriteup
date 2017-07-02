<?php
	function show_profile($con){
		echo "<a href='index.php'>main</a><br/><br/>";
		echo "change passwrod";
		echo "<form action='index.php?page=myinfo&mode=profile' method='POST'>";
		echo "<input type='password' name='pw'>";
		echo "<input type='submit' value='change'>";
	}
	function show_board($con){
		echo file_get_contents('./template/board_main.tpl');
		$query = mysqli_query($con, sqli_block("SELECT * FROM board limit 0, 50"));
		
		echo '<table><tr><th>idx</th><th>title</th><th>uploader</th></tr>';
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){

			$idx = $row['idx'];
			$title = xss_block($row['title']);
			$uploader = xss_block($row['uploader_nick']);
 			echo "<tr><td><a href='index.php?page=view&idx={$row['idx']}'>{$row['idx']}</a></td><td>{$title}</td><td>{$uploader}</td></tr>";
		}
		echo '</table>';
		return false;
	}
	function show_my_post($con){
		echo "<a href='index.php'>main</a><br/><br/>";
		$query = mysqli_query($con, sqli_block("SELECT * FROM board WHERE uploader_id='{$_SESSION['id']}' limit 0, 15"));
		echo '<table><tr><th>check</th><th>idx</th><th>title</th><th>uploader</th><th>delete</th></tr>';
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){

			$idx = $row['idx'];
			$title = xss_block($row['title']);
			$uploader = xss_block($row['uploader_nick']);
			$uploader_id = xss_block($row['uploader_id']);
 			echo "<tr><td><input type='checkbox' name='delete' value='{$idx}'><td><a href='index.php?page=view&idx={$idx}'>{$idx}</a></td><td>{$title}</td><td>{$uploader}</td><td><a href='index.php?page=delete&mode=single&idx={$idx}&uploader={$uploader_id}'>delete</a></td></tr>";
		}
		echo '</table>';
		echo file_get_contents('./template/my_post.tpl');
		return false;
	}
	function show_post($con, $idx){
		$result = mysqli_fetch_array(mysqli_query($con, sqli_block("SELECT * FROM board where idx='{$idx}';")), MYSQLI_ASSOC);

		echo '<b>uploader</b> : '.xss_block($result['uploader_nick']).'<br/>';
		echo '<b>title</b> : '.xss_block($result['title']).'<br/>';
		echo '<b>content</b> : <br/>'.xss_block($result['content']);
		return false;

	}
	function do_write($con){
		if(!$_POST['title'] || !$_POST['content']) alert('check your parameters');

		$title = $_POST['title'];
		$content = $_POST['content'];
		$uploader_nick = $_SESSION['nick'];
		$uploader_id = $_SESSION['id'];

		$query = sqli_block("INSERT INTO board (title, content, uploader_nick, uploader_id) VALUES ('{$title}', '{$content}', '{$uploader_nick}', '{$uploader_id}');");

		if(mysqli_query($con, $query)) die("<script>alert('write!');location.href='index.php?page=board';</script>");
		else alert('fail');
		return false;
	}
	function do_login($con){
		if(!$_POST['id'] || !$_POST['pw']) alert('check your parameters');

		$id = $_POST['id'];
		$pw = sha1($_POST['pw']."do_you_know_me?");

		if(!vaild_str($id)) alert('try again XD');

		$query = sqli_block("SELECT * FROM member WHERE id='{$id}' AND pw='{$pw}';");
		$result = mysqli_fetch_array(mysqli_query($con, $query), MYSQLI_ASSOC);
		if($result){
			$_SESSION['id'] = $result['id'];
			$_SESSION['pw'] = $result['pw'];
			$_SESSION['nick'] = $result['nick'];

			setcookie('id', $result['id']);
			setcookie('pw', $result['pw']);
			setcookie('nick', $result['nick']);

			die("<script>alert('login!');location.href='index.php';</script>");
		}
		else{
			alert('login fail');
		}

		return false;
	}
	function do_edit_profile($con){
		$pw = sha1($_POST['pw']."do_you_know_me?");

		if(mysqli_query($con, sqli_block("UPDATE member SET pw='{$pw}' WHERE id='{$_SESSION['id']}';"))){
			session_destroy();
			die("<script>alert('update!');location.href='index.php';</script>");
		}
		else{
			alert('error!');
		}
	}
	function do_register($con){
		if(!$_POST['id'] || !$_POST['pw'] || !$_POST['nick']) alert('check your parameters');

		$pw = sha1($_POST['pw']."do_you_know_me?");
		$id = $_POST['id'];
		$nick = $_POST['nick'];
		
		if(!vaild_str($id) || !vaild_str($nick)) alert('try again XD');
		
		$query = sqli_block("SELECT * FROM member WHERE id='{$id}' or nick='{$nick}'");
		$result = mysqli_fetch_array(mysqli_query($con, $query), MYSQLI_ASSOC);
		
		if($result) alert('already exsits id or nick');

		$query = "INSERT INTO member (id, pw, nick) VALUES ('{$id}', '{$pw}', '{$nick}');";

		if(mysqli_query($con, $query)){
			die("<script>alert('register!');location.href='index.php';</script>");
		}
		else{
			alert('something error');
		}
		return false;
	}
	function do_delete($con, $mode){
		if($mode === 'multi'){
			$uploader = $_POST['uploader'];

			$idx_list = array();
			for($i=0; $i<=count($_POST['idx'])-1; $i++){
				$idx = $_POST['idx'][$i];
				$result = mysqli_fetch_array(mysqli_query($con, sqli_block("SELECT * FROM board WHERE idx='{$idx}' AND uploader_id='{$uploader}';")), MYSQLI_ASSOC);				
				if($result['uploader_id'] === $_SESSION['id']){
					$idx_list[] = $idx;
				}
				else{
					alert('are you hacker?');
				}				
			}
			for($i=0; $i<=count($idx_list); $i++){
				mysqli_query($con, sqli_block("DELETE FROM board WHERE idx='{$idx_list[$i]}';"));
			}
			die("<script>alert('Delete!');location.href='index.php';</script>");
		}
		else{
			if(!is_string($_GET['idx'])) alert('hack me if you can');

			$uploader = $_GET['uploader'];
			$idx = $_GET['idx'];

			$result = mysqli_fetch_array(mysqli_query($con, sqli_block("SELECT * FROM board WHERE idx='{$idx}' AND uploader_id='{$uploader}';")), MYSQLI_ASSOC);

			if($result['uploader_id'] === $_SESSION['id']){
				if(mysqli_query($con, sqli_block("DELETE FROM board WHERE idx='{$idx}';"))) die("<script>alert('Delete!');location.href='index.php';</script>");
			}
			else{
				alert('are you hacker?');
			}
		}
		return false;
	}
?>