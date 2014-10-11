<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment extends Controller_Base {
	
	public function action_list()
	{
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		$realname = intval($this->request->query('realname'));
		
		try {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('comments')
				->join('students')
				->on('comments.student_id', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->join('students_courses', 'LEFT')
				->on('students.id', '=', 'students_courses.student_id')
				->join('courses', 'LEFT')
				->on('students_courses.course_id', '=', 'courses.id')
				->join('classes', 'LEFT')
				->on('courses.class_id', '=', 'classes.id')
				->where('comments.agency_id', '=', $this->auth->agency_id)
				->where('comments.status', '=', STATUS_NORMAL);
			$queyrList  = DB::select('comments.id','comments.created_at','students.realname',array('schools.name', 'school'),array('grades.name', 'grade'),array('courses.name', 'course'),array('classes.name', 'class'))
				->from('comments')
				->join('students')
				->on('comments.student_id', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->join('students_courses', 'LEFT')
				->on('students.id', '=', 'students_courses.student_id')
				->join('courses', 'LEFT')
				->on('students_courses.course_id', '=', 'courses.id')
				->join('classes', 'LEFT')
				->on('courses.class_id', '=', 'classes.id')
				->where('comments.agency_id', '=', $this->auth->agency_id)
				->where('comments.status', '=', STATUS_NORMAL);
			
			if ( $school ) {
				$queryCount->where('schools.id', '=', $school);
				$queyrList->where('schools.id',  '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('grades.id', '=', $grade);
				$queyrList->where('grades.id',  '=', $grade);
			}
			if ( $class ) {
				$queryCount->where('students_courses.course_id', '=', $class);
				$queyrList->where('students_courses.course_id',  '=', $class);
			}
			if ( $realname ) {
				$queryCount->where('students.realname', '=', $realname);
				$queyrList->where('students.realname',  '=', $realname);
			}
			
			$cnt   = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = $queyrList->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('comment/list')
				->set('items',   $items)
				->set('entities', $this->entities())
				->set('schools',  $this->schools())
				->set('grades',   $this->grades())
				->set('classes',  $this->classes());
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);
			$this->output($page, 'comment' );
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$page = View::factory('comment/add');				
		$this->output($page, 'comment');
	}
		
	public function action_save()
	{
		$data = array();
		$data['student_id'] = intval($this->request->post('student_id'));
		$data['content']    = $this->request->post('content');
		
		$data['agency_id']  = $this->auth->agency_id;
		$data['created_by'] = $this->auth->user_id;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['modified_at'] = $this->auth->user_id;
		$data['modified_by'] = date('Y-m-d H:i:s');
		
		try {
			list($id, $rows) = DB::insert('comments', array_keys($data))
				->values($data)
				->execute();
			HTTP::redirect('/comment/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('comments')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>NULL) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/comment/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
