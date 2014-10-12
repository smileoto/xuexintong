<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Signup extends Controller_Base {

	public function action_list() 
	{
		$class_id = intval($this->request->query('class_id'));
		
		try {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('courses')
				->join('classes')
				->on('courses.class_id', '=', 'classes.id')
				->where('courses.agency_id', '=', $this->auth->agency_id)
				->where('courses.status', '=', STATUS_NORMAL);
			
			$queryItems = DB::select('courses.*', array('classes.name', 'class'))
				->from('courses')
				->join('classes')
				->on('courses.class_id', '=', 'classes.id')
				->where('courses.agency_id', '=', $this->auth->agency_id)
				->where('courses.status', '=', STATUS_NORMAL);
				
			if ( $class_id ) {
				$queryCount->where('courses.class_id', '=', $class_id);
				$queryItems->where('courses.class_id', '=', $class_id);
			}

			
			$count = $queryCount->execute();
			$total = $count->count() ? $count[0]['COUNT(0)'] : 0;
			$items = $queryItems->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			
			$page = View::factory('signup/list')
				->set('items', $items)
				->set('class_id', $class_id)
				->set('classes', $this->classes());
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);
			$this->output($page, 'signup');
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_publish()
	{
		$id = intval($this->request->query('id'));
		
		$data = array();
		$data['signup'] = STATUS_ENABLED;
		
		try {
			DB::update('courses')
				->set($data)
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $id)
				->execute();
			HTTP::redirect('/signup/list/');
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_cancel()
	{
		$id = intval($this->request->query('id'));
		
		$data = array();
		$data['signup'] = STATUS_NORMAL;
		
		try {
			DB::update('courses')
				->set($data)
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $id)
				->execute();
			HTTP::redirect('/signup/list/');
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_explain() 
	{
		$items = DB::select('id', 'content')
			->from('signup_explain')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute()
			->as_array();
			
		$item = array('id' => 0, 'content' => '');
		if ( count($items) ) {
			$item = $items[0];
		}
		
		$page = View::factory('signup/explain')
			->set('item', $item);
		$this->output($page, 'signup');
	}
	
	public function action_save()
	{
		$data = array();
		$data['content']  = $this->request->post('content');
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				DB::update('signup_explain')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('signup_explain', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/signup/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
