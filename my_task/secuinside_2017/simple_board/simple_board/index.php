<?php #made by adm1nkyj
	error_reporting(0);
	session_start();

	include('config.php');
	include('lib.php');
	include('header.php');
	include('action_lib.php');
?>
	<body>
		<center>
		<?php
			echo 'Hello '.$_SESSION['nick'].'('.$_SESSION['id'].')<br/>';
			if($_GET['page'] === 'board'){
				if(!login_check()) alert('login first');
				if($_GET['mode'] === 'write'){
					if($_POST){
						do_write($db_con);
					}
					else{
						echo file_get_contents('./template/write_mode.tpl');
					}
				}
				else{
					show_board($db_con);
				}
			}
			else if($_GET['page'] ==='view' && $_GET['idx']){
				show_post($db_con, $_GET['idx']);
			}
			else if($_GET['page'] === 'myinfo'){
				if(!login_check()) alert('login first');	
				if($_GET['mode'] === 'mypost'){
					show_my_post($db_con);
				}
				else if($_GET['mode'] === 'profile'){
					if($_POST){
						do_edit_profile($db_con);
					}
					else{
						show_profile($db_con);
					}
				}
				else{
					echo file_get_contents('./template/myinfo_main.tpl');
				}
			}
			else if($_GET['page'] === 'delete'){
				if(!login_check()) alert('login first');
				if($_GET['mode'] === 'multi' && $_POST){
					do_delete($db_con, 'multi');
				}
				else if($_GET['mode'] === 'single' && !$_POST){
					do_delete($db_con, 'single');
				}
				else{
					alert('check your paramemters');
				}
			}
			else if($_GET['page'] === 'logout'){
				if(!login_check()) alert('login first');
				session_destroy();
				alert('logout!');
			}
			else if($_GET['page'] === 'login'){
				if(login_check()) alert('already login');
				do_login($db_con);
			}
			else if($_GET['page'] === 'register'){	
				if(login_check()) alert('already login');
				do_register($db_con);
			}
			else{
				if(login_check()){
					echo file_get_contents('./template/main.tpl');
				}
				else{
					include('./template/login.tpl');
				}
			}
		?>
		</center>
	</body>
<?php
	include('footer.php');
?>