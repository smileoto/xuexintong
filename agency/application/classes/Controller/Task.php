<?php defined('SYSPATH') or die('No direct script access.');

class Controller_task extends Controller_Base {
	
	public function action_list()
	{
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		$date   = strtotime($this->request->query('date'));
		
		try {		
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('tasks')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('status', '>', STATUS_DELETED);
			$queyrList  = DB::select('tasks.id','tasks.status','tasks.title','tasks.date_str',array('entities.name', 'entity'),array('schools.name', 'school'),array('grades.name', 'grade'),array('classes.name', 'class'),array('courses.name', 'course'))
				->from('tasks')
				->where('tasks.agency_id', '=', $this->auth->agency_id)
				->join('entities', 'LEFT')
				->on('tasks.entity_id', '=', 'entities.id')
				->join('schools', 'LEFT')
				->on('tasks.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('tasks.grade_id', '=', 'grades.id')
				->join('courses', 'LEFT')
				->on('tasks.course_id', '=', 'courses.id')
				->join('classes', 'LEFT')
				->on('courses.class_id', '=', 'classes.id');
			
			if ( $entity ) {
				$queryCount->where('tasks.entity_id', '=', $school);
				$queyrList->where('tasks.entity_id',  '=', $school);
			}
			if ( $school ) {
				$queryCount->where('tasks.school_id', '=', $school);
				$queyrList->where('tasks.school_id',  '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('tasks.grade_id', '=', $grade);
				$queyrList->where('tasks.grade_id',  '=', $grade);
			}
			if ( $class ) {
				$queryCount->where('tasks.course_id', '=', $class);
				$queyrList->where('tasks.course_id',  '=', $class);
			}
			if ( $date ) {
				$queryCount->where('tasks.date_str', '=', $date);
				$queyrList->where('tasks.date_str',  '=', $date);
			}
			
			$cnt   = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = $queyrList
				->where('tasks.agency_id', '=', $this->auth->agency_id)
				->where('tasks.status', '>', STATUS_DELETED)
				->order_by('tasks.id', 'DESC')
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('task/list')
				->set('items', $items)
				->set('entities', $this->entities())
				->set('schools',  $this->schools())
				->set('grades',   $this->grades())
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
		$page = View::factory('task/add')
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
		
		$page = View::factory('task/edit')
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
		$data['date_str']  = $this->request->post('date_str');
		$data['title']     = $this->request->post('title');
		$data['entity_id'] = intval($this->request->post('entity_id'));
		$data['school_id'] = intval($this->request->post('school_id'));
		$data['grade_id']  = intval($this->request->post('grade_id'));
		$data['course_id'] = intval($this->request->post('course_id'));
		
		$data['content']   = Arr::get($_POST, 'content', '');
		
		$data['modified_at']  = date('Y-m-d H:i:s');
		$data['modified_by']  = $this->auth->user_id;
		
		$data['status'] = STATUS_NORMAL;
		
		$content = $this->request->post('content');
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				DB::update('tasks')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
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
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/task/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_publish()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('tasks')
				->set( array('status'=>STATUS_ENABLED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/task/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_cancel()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('tasks')
				->set( array('status'=>STATUS_NORMAL, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/task/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
