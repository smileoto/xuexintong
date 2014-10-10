<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Introduction extends Controller_Base {
	
	public function action_index()
	{
		$items = DB::select('*')
			->from('introductions')
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
							
		$page = View::factory('introduction/index')
			->set('item', $item);

		$this->output($page, 'agency');
	}
		
	public function action_save()
	{
		$data = array();
		$data['agency_id'] = $this->auth->agency_id;
		$data['content']   = Arr::get($_POST, 'content', '');
		
		try {
			$rows = DB::update('introductions')
				->set($data)
				->where('id', '=', $this->auth->agency_id)
				->execute();
			if ( empty($rows) ) {
				DB::insert('introductions', array_keys($data))
				->values($data)
				->execute();
			}
			HTTP::redirect('/introduction/index/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
