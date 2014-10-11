<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Course extends Controller_Base {

	public function action_list() 
	{
		$class_id  = intval($this->request->query('class_id'));

		try {
			$classes = DB::select('id', 'name', 'content')
				->from('classes')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $class_id)
				->limit(1)
				->execute()
				->as_array();
			if ( empty($classes) ) {
				HTTP::redirect('/class/list/');
			}
		
			$expr = DB::expr('COUNT(0)');
			$cnt = DB::select($expr)
				->from('courses')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('class_id', '=', $class_id)
				->where('status', '=', STATUS_NORMAL)
				->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = DB::select('*')
				->from('courses')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('class_id', '=', $class_id)
				->where('status', '=', STATUS_NORMAL)
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('course/list')
				->set('items', $items)
				->set('class', $classes[0]);
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);
			$this->output($page, 'classes');
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$class_id = intval($this->request->query('class_id'));
		$page = View::factory('course/add')
			->set('class_id', $class_id);			
		$this->output($page, 'classes');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('courses')
			->where('id', '=', $id)
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			// redirect 404
			HTTP::redirect('/class/list/');
		}
			
		$page = View::factory('course/edit')
			->set('item', $items[0]);				
		$this->output($page, 'classes');
	}
	
	public function action_save()
	{
		$data = array();
		$data['class_id']  = $this->request->post('class_id');
		$data['name']      = $this->request->post('name');
		$data['content']   = $this->request->post('content');
		$data['tuition']   = $this->request->post('tuition');
		$data['time']      = $this->request->post('time');
		$data['hours']     = $this->request->post('hours');
		$data['num']       = $this->request->post('num');
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				DB::update('courses')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('courses', array_keys($data))
					->values($data)
					->execute();
			}
			HTTP::redirect('/course/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('courses')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/class/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
