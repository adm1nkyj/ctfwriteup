<?php error_reporting(0); ?>
<html>
	<!-- made by adm1nkyj-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Uplaod Box</title>
		<script src="./js/jquery-3.2.1.min.js"></script>
		<script src="./js/member.js"></script>
	</head>
	<body>
		<center>
		<?php
			session_start();
			include('__autoload.php');
			include('./uploadbox_lib/security.php');
			include('./uploadbox_lib/util.php');

			$ad = security::class_check('uploadbox_'.$_REQUEST['ad']);
			$mi = 'do_'.$_REQUEST['mi'];
			$action = new $ad;

			if(method_exists($action, $mi)){
				$action->$mi();
			}
			else{
				$action->default_page();
			}
		?>
		</center>
	</body>
</html>