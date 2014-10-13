<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Course extends Controller_Auth {

	public function action_list() 
	{
		$class_id  = intval($this->request->query('class_id'));
		
		try {
			$classes = DB::select('id','name')
				->from('classes')
				->where('agency_id', '=', $this->agency->get('agency_id'))
				->where('id', '=', $class_id)
				->limit(1)
				->execute();
			if ( $classes->count() == 0 ) {
				HTTP::redirect('/classes/list/');
			}
				
			$items = DB::select('id', 'name'))
				->from('courses')
				->where('agency_id', '=', $this->agency->get('agency_id'))
				->where('class_id', '=', $class_id)
				->execute()
				->as_array();
			
			$page = View::factory('course/list')
				->set('class',   $classes->get('name'))
				->set('items',   $items);
				
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_detail()
	{
		$id = intval($this->request->query('id'));
		
		try {
			$courses = DB::select('*')
				->from('courses')
				->where('agency_id', '=', $this->agency->get('agency_id'))
				->where('id', '=', $id)
				->limit(1)
				->execute()
				->as_array();
			if ( empty($courses) ) {
				HTTP::redirect('/course/list/');
			}
			
			$classes = DB::select('id','name')
				->from('classes')
				->where('id', '=', $courses[0]['class_id'])
				->execute();
			
			$page = View::factory('course/detail')
				->set('item',  $courses[0])
				->set('class', $classes->get('name'));
				
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
}
