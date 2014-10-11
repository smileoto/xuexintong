<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Works extends Controller_Auth {
	
	public function action_list() 
	{
		try {
			$items = DB::select('works.*',array('students.realname', 'student'),array('courses.name', 'class'))
				->from('works')
				->join('students')
				->on('works.student_id', '=', 'students.id')
				->join('students_courses')
				->on('students.id', '=', 'students_courses.student_id')
				->join('courses')
				->on('students_courses.course_id', '=', 'courses.id')
				->where('works.agency_id', '=', $this->agency->get('agency_id'))
				->where('works.status', '=', STATUS_NORMAL)
				->order_by('works.id', 'DESC')
				->offset($this->pagenav->page)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('works/list')
				->set('item', $items)
				->set('page', $this->pagenav->page);
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_detail()
	{
		$id = intval($this->request->query('id'));
		
		try {
			$items = DB::select('works.*',array('students.realname', 'student'),array('schools.name', 'school'),array('grades.name', 'grade'))
				->from('works')
				->join('students')
				->on('works.student_id', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades',  'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->where('works.agency_id', '=', $this->agency->get('agency_id'))
				->where('works.id', '=',  $id)
				->limit(1)
				->execute()
				->as_array();
			if ( empty($items) ) {
				HTTP::redirect('works/list');
			}
			
			$page = View::factory('works/detail')
				->set('item', $items[0]);
			$this->output($page);
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
}
