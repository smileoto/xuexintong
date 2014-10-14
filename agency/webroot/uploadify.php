<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

//session_start();

// Define a destination
//$targetFolder = $_SESSION['upload_dir']; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = __DIR__ . $targetFolder;
	$targetPath = '/alidata/www/xuexintong/agency/webroot/files';
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
?>