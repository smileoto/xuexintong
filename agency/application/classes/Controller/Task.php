<?php defined('SYSPATH') or die('No direct script access.');

class Controller_task extends Controller_Base {
	
	public function action_list()
	{
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		$date   = intval($this->request->query('date'));
		
		try {		
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('tasks')
				->where('agency_id', '=', $this->auth->agency_id);
			$queyrList  = DB::select('id','title','date_t','entity_id','school_id','grade_id','class_id','course_id')
				->from('tasks')
				->where('agency_id', '=', $this->auth->agency_id);
			
			if ( $entity ) {
				$queryCount->where('entity_id', '=', $school);
				$queyrList->where('entity_id',  '=', $school);
			}
			if ( $school ) {
				$queryCount->where('school_id', '=', $school);
				$queyrList->where('school_id',  '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('grade_id', '=', $grade);
				$queyrList->where('grade_id',  '=', $grade);
			}
			if ( $class ) {
				$queryCount->where('course_id', '=', $class);
				$queyrList->where('course_id',  '=', $class);
			}
			if ( $date ) {
				$queryCount->where('date_t', '=', $date);
				$queyrList->where('date_t',  '=', $date);
			}
			
			$cnt   = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = $queyrList->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('task/list')
				->set('items', $items)
				->set('entities', $this->entities())
				->set('schools',  $this->schools())
				->set('grades',   $this->grades())
				->set('classes',  $this->classes())
				->set('courses',  $this->courses());
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);		
			$this->output($page, 'task' );
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$page = View::factory('tasks/add')
			->set('entities', $this->entities())
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('classes',  $this->classes())
			->set('courses',  $this->courses());
			
		$this->output($page, 'task' );
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('tasks')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( !count($items) ) {
			HTTP::redirect('/tasks/list/');
		}
		
		$page = View::factory('tasks/add')
			->set('item',     $items[0])
			->set('entities', $this->entities())
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('classes',  $this->classes())
			->set('courses',  $this->courses());
			
		$this->output($page, 'task' );
	}
	
	public function action_save()
	{
		$data = array();
		$data['date_t']    = intval($this->request->post('date'));
		$data['title']     = $this->request->post('title');
		$data['entity_id'] = intval($this->request->post('entity_id'));
		$data['school_id'] = intval($this->request->post('school_id'));
		$data['grade_id']  = intval($this->request->post('grade_id'));
		$data['course_id'] = intval($this->request->post('course_id'));
		
		$data['content']   = Arr::get($_POST, 'content', '');
		
		$data['modified_at']  = NULL;
		$data['modified_by']  = $this->auth->user_id;
		
		$content = $this->request->post('content');
		
		$id = intval($this->request->query('id'));
		try {
			if ( $id ) {
				DB::update('tasks')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = NULL;
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('tasks', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/task/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
		
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('tasks')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>NULL) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/task/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
