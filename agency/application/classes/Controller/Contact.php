<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contact extends Controller_Base {
	
	public function action_index()
	{
		$items = DB::select('*')
			->from('contacts')
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
							
		$page = View::factory('contact/index')
			->set('item', $item);

		$this->output($page, 'agency');
	}
		
	public function action_save()
	{
		$data = array();
		$data['agency_id'] = $this->auth->agency_id;
		$data['content']   = Arr::get($_POST, 'content', '');
		
		try {
			$rows = DB::update('contacts')
				->set($data)
				->where('id', '=', $this->auth->agency_id)
				->execute();
			if ( empty($rows) ) {
				DB::insert('contacts', array_keys($data))
				->values($data)
				->execute();
			}
			HTTP::redirect('/contact/index/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
