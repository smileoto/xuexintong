<?php defined('SYSPATH') or die('No direct script access.');

//require_once APPPATH.'../vendor/UploadHandler.php';

class Controller_Upload extends Controller_Base {
	
	public function action_index()
	{
		/*
		$options = array();
		$options['upload_dir']  = DOCROOT.'files/'.Session::instance()->get('upload_dir').'/'.$this->auth->agency_id.'/';
		$options['upload_url']  = '/files/'.Session::instance()->get('upload_dir').'/'.$this->auth->agency_id.'/';
		$options['script_url']  = '/index.php/upload/';
		$options['delete_type'] = 'POST';
		$upload_handler = new UploadHandler($options);
		exit;
		*/
			
		// Define a destination
		$targetFolder = Session::instance()->get('upload_dir'); // Relative to the root

		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
		
		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = __DIR__ . $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
			
			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			
			if (in_array($fileParts['extension'],$fileTypes)) {
				if ( move_uploaded_file($tempFile,$targetFile) ) {
					echo '1';
				} else {
					echo 'move_uploaded_file false';
				}
			} else {
				echo 'Invalid file type.';
			}
		}
		
		exit;
	}
	
}
