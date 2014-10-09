<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Report extends Controller_Base {
	
	public function action_list()
	{
		$realname = strval($this->request->query('realname'));
		
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		
		try {		
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('reports')
				->join('students')
				->on('reports.student_id', '=', 'students.id')
				->where('reports.agency_id', '=', $this->auth->agency_id)
				->where('reports.status', '=', STATUS_NORMAL);
			$queyrList  = DB::select('reports.id','reports.modified_at','students.realname',array('schools.name', 'school'),array('grades.name', 'grade'),array('courses.name', 'course'),array('classes.name', 'class'))
				->from('student_score')
				->join('students')
				->on('student_score.student_id', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'agency_schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id', '=', 'agency_grades.id')
				->join('courses', 'LEFT')
				->on('students.id', '=', 'students_courses.student_id')
				->join('courses', 'LEFT')
				->on('courses.course_id', '=', 'courses.id')
				->join('classes', 'LEFT')
				->on('courses.class_id', '=', 'classes.id')
				->where('reports.agency_id', '=', $this->auth->agency_id)
				->where('reports.status',    '=', STATUS_NORMAL);
			
			if ( $realname ) {
				$queryCount->where('students.realname', 'like', '%'.$realname.'%');
				$queyrList->where('students.realname',  'like', '%'.$realname.'%');
			}
			if ( $school ) {
				$queryCount->where('students.school_id', '=', $school);
				$queyrList->where('students.school_id',  '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('students.grade_id', '=', $grade);
				$queyrList->where('students.grade_id',  '=', $grade);
			}
			if ( $class ) {
				$queryCount->where('students_courses.course_id', '=', $class);
				$queyrList->where('students_courses.course_id',  '=', $class);
			}
			
			$cnt   = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = $queyrList->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('report/list')
				->set('items',   $items)
				->set('schools', $this->schools())
				->set('grades',  $this->grades())
				->set('courses', $this->courses());
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);	
			$this->output($page, 'score');
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$page = View::factory('score/add')
			->set('schools', $this->schools())
			->set('grades',  $this->grades())
			->set('courses', $this->courses());
			
		$this->output($page, 'score');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('reports')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/report/list/');
		}
		
		$students = DB::select('id', 'realname')
			->from('students')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $items[0]['student_id'])
			->execute()
			->as_array();
		if ( empty($students) ) {
			HTTP::redirect('/report/list/');
		}
		
		$page = View::factory('report/edit')
			->set('item',     $items[0])
			->set('student',  $students[0])
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('courses',  $this->courses());
			
		$this->output($page, 'score');
	}
	
	public function action_save()
	{
		$data = array();
		$data['student_id'] =  intval($this->request->post('student_id'));
		$data['content']     = Arr::get($_POST, 'content', '');
		$data['modified_at'] = NULL;
		
		$id = intval($this->request->query('id'));
		if ( $id ) {
			try {
				DB::update('reports')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $works_id)
					->execute();
			} catch (Database_Exception $e) {
				$this->ajax_result['ret'] = ERR_DB_UPDATE;
				$this->ajax_result['msg'] = $e->getMessage();
			}
		} else {
			$data['created_at'] = NULL;
			$data['created_by'] = $this->auth->user_id;
			$data['agency_id']  = $this->auth->agency_id;
			try {
				DB::insert('reports', array_keys($data))
					->values($data)
					->execute();
			} catch (Database_Exception $e) {
				$this->ajax_result['ret'] = ERR_DB_INSERT;
				$this->ajax_result['msg'] = $e->getMessage();
			}
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		$data = array();
		$data['modified_at'] = NULL;
		$data['status']      = STATUS_DELETED;
		
		try {
			$rows = DB::update('reports')
				->set($data)
				->execute();
			HTTP::redirect('/report/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
