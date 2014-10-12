<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH.'../vendor/UploadHandler.php';

class Controller_Upload extends Controller_Base {
	
	public function action_index()
	{
		$options = array();
		$options['upload_dir']  = DOCROOT.'files/'.Session::instance()->get('upload_dir').'/'.$this->auth->agency_id.'/';
		$options['upload_url']  = '/files/'.Session::instance()->get('upload_dir').'/'.$this->auth->agency_id.'/';
		$options['delete_type'] = 'POST';
		$upload_handler = new UploadHandler($options);
		exit;
	}
	
	public function action_test()
	{
		echo 'Hello world!';exit;
	}
	
}
