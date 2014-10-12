<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH.'../vendor/UploadHandler.php';

class Controller_Upload extends Controller_Base {
	
	public function action_index()
	{
		$options = array();
		$options['upload_dir']  = DOCROOT.'files/'.$this->auth->agency_name.'/'.Session::instance()->get('upload_dir').'/';
		$options['delete_type'] = 'POST';
		$upload_handler = new UploadHandler($options);
	}
	
	public function action_test()
	{
		echo 'Hello world!';exit;
	}
	
}
