<?php #header.php
	$_GET = str_escape($_GET);
	$_POST = str_escape($_POST);
?>
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		<title>simple board XD</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style>
			table, th, td {
			    border: 1px solid black;
			}
		</style>
	</head>
