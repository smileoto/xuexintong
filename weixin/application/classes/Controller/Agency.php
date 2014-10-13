<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller_Auth 
{
	
	public function action_index()
	{
		$items = DB::select('*')
			->from('agencies')
			->where('id', '=', $this->auth->agency_id)
			->limit(1)
			->execute()
			->as_array();
		
		$content = '';
		if ( empty($items) ) {
			$content = &$items[0]['content'];
		}
									
		$page = View::factory('agency/index')
			->set('content', $content);

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
			->execute()
			->as_array();
		
		$content = '';
		if ( empty($items) ) {
			$content = &$items[0]['content'];
		}
							
		$page = View::factory('agency/contact')
			->set('content', $content);

		$this->output($page);
	}
	
	public function action_teachers()
	{
		$items = DB::select('*')
			->from('teachers')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute()
			->as_array();
		
		$content = '';
		if ( empty($items) ) {
			$content = &$items[0]['content'];
		}
							
		$page = View::factory('agency/teachers')
			->set('content', $content);

		$this->output($page);
	}
	
}
