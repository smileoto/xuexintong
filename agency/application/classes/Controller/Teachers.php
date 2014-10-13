<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teachers extends Controller_Base {
	
	public function action_index()
	{
		$items = DB::select('*')
			->from('teachers')
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
							
		$page = View::factory('teachers/index')
			->set('item', $item);

		$this->output($page, 'teachers');
	}
		
	public function action_save()
	{
		$data = array();
		$data['agency_id'] = $this->auth->agency_id;
		$data['content']   = Arr::get($_POST, 'content', '');
		
		try {
			$rows = DB::update('teachers')
				->set($data)
				->where('id', '=', $this->auth->agency_id)
				->execute();
			if ( empty($rows) ) {
				DB::insert('teachers', array_keys($data))
				->values($data)
				->execute();
			}
			HTTP::redirect('/teachers/index/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
