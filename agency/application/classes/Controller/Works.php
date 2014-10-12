<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Works extends Controller_Base {
	
	public function action_list() 
	{
		$realname = $this->request->query('realname');
		$title    = $this->request->query('title');
		
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		
		try {
				
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('works')
				->join('students')
				->on('works.student_id', '=', 'students.id')
				->join('users')
				->on('works.modified_by', '=', 'users.id')
				->where('works.agency_id', '=', $this->auth->agency_id)
				->where('works.status', '=', STATUS_NORMAL);
			$query = DB::select('works.id', 'works.student_id', 'works.created_at', 'works.modified_at', 'works.title', array('schools.name', 'school'), array('grades.name', 'grade'), 'students.realname', array('users.realname', 'editor'))
				->from('works')
				->join('students')
				->on('works.student_id', '=', 'students.id')
				->join('users')
				->on('works.modified_by', '=', 'users.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->where('works.agency_id', '=', $this->auth->agency_id)
				->where('works.status', '=', STATUS_NORMAL);
			if ( $realname ) {
				$queryCount->where('students.realname', 'like', '%'.$realname.'%');
				$query->where('students.realname', 'like', '%'.$realname.'%');
			}
			if ( $title ) {
				$queryCount->where('works.title', 'like', '%'.$title.'%');
				$query->where('works.title', 'like', '%'.$title.'%');
			}
			if ( $entity ) {
				$queryCount->where('students.entity_id', '=', $entity);
				$query->where('students.entity_id', '=', $entity);
			}
			if ( $school ) {
				$queryCount->where('students.school_id', '=', $school);
				$query->where('students.school_id', '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('students.grade_id', '=', $grade);
				$query->where('students.grade_id', '=', $grade);
			}
			$cnt = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = $query->order_by('works.id', 'DESC')
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('works/list')
				->set('items',    $items)
				->set('entities', $this->entities())
				->set('schools',  $this->schools())
				->set('grades',   $this->grades());
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);	
			$this->output($page, 'works');
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$page = View::factory('works/add');
		$this->output($page, 'works');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('works.*', 'students.realname')
			->from('works')
			->join('students')
			->on('works.student_id', '=', 'students.id')
			->where('works.agency_id', '=', $this->auth->agency_id)
			->where('works.id', '=', $id)
			->execute()
			->as_array();
		if ( !count($items) ) {
			HTTP::redirect('/works/list/');
		}
		
		$page = View::factory('works/edit')
			->set('item', $items[0]);			
		$this->output($page, 'works');
	}
	
	public function action_save()
	{
		$data = array();
		$data['student_id'] = intval($this->request->post('student_id'));
		$data['title']      = $this->request->post('title');
		$data['remark']     = $this->request->post('comment');
		$data['img']        = Arr::get($_POST, 'img', '');
		$data['content']    = Arr::get($_POST, 'content', '');
		
		$data['modified_at']  = date('Y-m-d H:i:s');
		$data['modified_by']  = $this->auth->user_id;
		
		$id = intval($this->request->query('id'));
		try {
			if ( $id ) {
				DB::update('works')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $works_id)
					->execute();
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('works', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/works/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('works')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/works/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
