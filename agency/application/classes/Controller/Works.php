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
			$query = DB::select('works.id', 'works.student_id', 'works.created_at', 'works.modified_at', 'works.title','works.entity_id', 'works.school_id', 'works.grade_id', 'students.realname', array('users.realname', 'editor'))
				->from('works')
				->join('students')
				->on('works.student_id', '=', 'students.id')
				->join('users')
				->on('works.modified_by', '=', 'users.id')
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
			
			$items = $query->offset($this->pagenav->offset)
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
		
		$items = DB::select('*')
			->from('works')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $works_id)
			->execute()
			->as_array();
		if ( !count($items) ) {
			HTTP::redirect('/works/list/');
		}
		
		$page = View::factory('works/edit')
			->set('item', $works[0])
			->set('student', $students[0]['realname']);			
		$this->output($page, 'works');
	}
	
	public function action_save()
	{
		$data = array();
		$data['entity_id'] = intval($this->request->post('entity'));
		$data['school_id'] = intval($this->request->post('school'));
		$data['grade_id']  = intval($this->request->post('grade'));
		$data['title']     = $this->request->post('title');
		$data['remark']    = $this->request->post('comment');
		$data['img']       = Arr::get($_POST, 'img', '');
		$data['content']   = Arr::get($_POST, 'content', '');
		
		$data['modified_at']  = NULL;
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
				$data['created_at'] = NULL;
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
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>NULL) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/works/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
