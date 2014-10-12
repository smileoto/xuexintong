<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Show extends Controller_Base {
	
	public function action_index()
	{
		$items = DB::select('*')
			->from('shows')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute()
			->as_array();
		
		$item = null;
		if ( empty($items) ) {
			$item = array('content' => '');
		} else {
			$item = $items[0];
		}
							
		$page = View::factory('show/index')
			->set('item', $item);

		$this->output($page, 'agency');
	}
	
	public function action_images()
	{
		$upload_dir = $this->get_upload_dir('show');
		Session::instance()->set('upload_dir', $upload_dir);
		$page = View::factory('show/images');
		$this->output($page, 'agency');
	}
		
	public function action_save()
	{
		$data = array();
		$data['agency_id'] = $this->auth->agency_id;
		$data['content']   = Arr::get($_POST, 'content', '');
		
		try {
			$rows = DB::update('shows')
				->set($data)
				->where('id', '=', $this->auth->agency_id)
				->execute();
			if ( empty($rows) ) {
				DB::insert('shows', array_keys($data))
				->values($data)
				->execute();
			}
			HTTP::redirect('/show/index/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
