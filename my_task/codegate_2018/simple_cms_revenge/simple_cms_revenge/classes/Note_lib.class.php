<?php
	if(!defined('simple_cms')) exit();
	class Note_lib{
		function do_write(){
			$content = Context::get('content');
			$to_id = Context::get('to_id');
			$file = $_FILES['image'];

			if(!$to_id || !$content || !str_check($to_id, 'id'))
				alert('check your parameter', 'back');
			if(strlen($content) > 150)
				alert('i hate long string', 'back');
			if(strtolower($to_id) === strtolower($_SESSION['id']))
				alert('easter egg : adm1nkyj is very handsome', 'back');

			$query = array('id'=>$to_id);
			$result = DB::fetch_row('users', $query);
			if(!$result['id'])
				alert('user not found', 'back');

			$file_name = '';
			if($file['name']){
				$file_name = $file['name'];
				$file_size = $file['size'];
				$tmp_file  = $file['tmp_name'];
				
				$file_name = check_filename($file_name);
				if(!$file_name)
					alert('bad file name', 'back');
				$file_name = set_filename($file_name);

				if(!is_dir(CMS_UPLOAD_PATH . 'note/')){
					mkdir(CMS_UPLOAD_PATH . 'note/');
					chmod(CMS_UPLOAD_PATH . 'note/', 755);
					touch(CMS_UPLOAD_PATH . 'note/index.php');
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
				
				if(!move_uploaded_file($tmp_file, CMS_UPLOAD_PATH . 'note/' . $file_name))
					alert('error!', 'back');
			}

			$query = array(
				'content' => $content,
				'from_id' => $_SESSION['id'],
				'to_id' => $to_id,
				'file' => $file_name,
				'read_ck' => 'x',
				'token' => bin2hex(rand_str(15))
			);
			if(DB::insert('note', $query))
				alert('send!', 'index.php?act=note&mid=default');
			else
				alert('error!', '');
		}
	}
?>