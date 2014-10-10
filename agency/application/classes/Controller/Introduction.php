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
		
		if ( empty($items) ) {
			HTTP::redirect('/login/index');
		}
		
							
		$page = View::factory('contact/index')
			->set('item', $items[0]);

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
		} catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_UPDATE;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
	
}
