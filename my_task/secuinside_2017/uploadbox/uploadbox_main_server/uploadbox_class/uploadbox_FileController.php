<?php
	class uploadbox_FileController{
		public function __construct(){
			if(!$_SESSION['loginID']) security::alert('plz login first');
		}
		public static function do_fileUpload(){
			die('this is file upload');
		}
		public function default_page(){
			die('okay');
			#uploadbox_FileController::do_get_image($_GET['url']);
		}
	}
?>