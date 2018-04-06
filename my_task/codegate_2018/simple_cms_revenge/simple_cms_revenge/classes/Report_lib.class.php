<?php
	if(!defined('simple_cms')) exit();
	class Report_lib{
		function do_write(){
			$title = Context::get('title');
			$content = Context::get('content');

			$file = $_FILES['image'];

			if(!$title || !$content || !$file['name'])
				alert('check your parameter', 'back');
			
			if(strlen($title) > 150 || strlen($content) > 150)
				alert('i hate long string', 'back');
			
			$file_name = $file['name'];
			$file_size = $file['size'];
			$tmp_file  = $file['tmp_name'];
			
			$file_name = check_filename($file_name);
			if(!$file_name)
				alert('bad file name', 'back');
			$file_name = set_filename($file_name);

			if(!is_dir(CMS_UPLOAD_PATH . 'report/')){
				mkdir(CMS_UPLOAD_PATH . 'report/');
				chmod(CMS_UPLOAD_PATH . 'report/', 755);
				touch(CMS_UPLOAD_PATH . 'report/index.php');
			}

			if($file_size > 100000)
				alert('file size too big', 'back');
			
			if(!is_uploaded_file($tmp_file))
				alert('error?', 'back');
			
			if(!check_image($tmp_file))
				alert('image only..', 'back');
			
			if(!preg_match_all('/([0-9]+)/i',getimagesize($tmp_file)[3], $match))
				alert('image only...', 'back');
			
			$width = $match[0][0];
			$height = $match[0][1];

			if($width > 400 || $height > 400)
				alert('biiiiiiiiiiiiigggggggggg', 'back');
			
			if(!move_uploaded_file($tmp_file, CMS_UPLOAD_PATH . 'report/' . $file_name))
				alert('error!', 'back');

			$query = array(
				'title' => $title,
				'content' => $content,
				'id' => $_SESSION['id'],
				'file' => $file_name,
				'reply' => '',
				'token' => bin2hex(rand_str(15)),
				'date' => date('Y-m-d h:i:s')
			);
			if(DB::insert('report', $query))
				alert('report!', 'index.php?act=report&mid=default');
			else
				alert('error!', '');
		}
	}
?>