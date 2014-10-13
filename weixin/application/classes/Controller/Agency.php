<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Agency extends Controller_Base
{
	
	public function action_index()
	{
		$items = DB::select('*')
			->from('introductions')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute();
		
		$page = View::factory('agency/index')
			->set('content', $items->count() ? $items->get('content') : '');

		$this->output($page);
	}
	
	public function action_show()
	{
		$items = DB::select('*')
			->from('images')
			->where('agency_id', '=', $this->auth->agency_id)
			->execute()
			->as_array();
		
		$page = View::factory('agency/show')
			->set('items', $items);
		$this->output($page);
	}
	
	public function action_contact()
	{
		$items = DB::select('*')
			->from('contacts')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute();
		
		$page = View::factory('agency/contact')
			->set('content',  $items->count() ? $items->get('content') : '');

		$this->output($page);
	}
	
	public function action_teachers()
	{
		$items = DB::select('*')
			->from('teachers')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute();
		
		$page = View::factory('agency/teachers')
			->set('content', $items->count() ? $items->get('content') : '');

		$this->output($page);
	}
	
}
