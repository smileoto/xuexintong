<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Report extends Controller_Auth {
	
	public function action_list()
	{
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		$date   = intval($this->request->query('date'));
		
		try {				
			$courses = DB::select('courses.id', 'courses.name')
				->from('courses')
				->join('students_courses')
				->on('courses.id', '=', 'students_courses.course_id')
				->where('courses.agency_id', '=', $this->agency->get('id'))
				->where('students_courses.student_id', '=', $this->auth->student_id)
				->execute()
				->as_array();
		
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('reports')
				->join('students')
				->on('reports.student_id', '=', 'students.id')
				->where('reports.agency_id', '=', $this->agency->get('id'))
				->where('reports.student_id', '=', $this->auth->user_id)
				->where('reports.status', '=', STATUS_NORMAL);
			$queryItems = DB::select('*')
				->from('reports')
				->join('students')
				->on('reports.student_id', '=', 'students.id')
				->where('reports.agency_id', '=', $this->agency->get('id'))
				->where('reports.student_id', '=', $this->auth->user_id)
				->where('reports.status', '=', STATUS_NORMAL);
			
			if ( $school ) {
				$queryCount->where('students.school_id', '=', $school);
				$queryItems->where('students.school_id',  '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('students.grade_id', '=', $grade);
				$queryItems->where('students.grade_id',  '=', $grade);
			}
			if ( $class ) {
				$queryCount->where('students_courses.course_id', '=', $class);
				$queryItems->where('students_courses.course_id',  '=', $class);
			}
			
			$count = $queryCount->execute();
			$total = $count->count() ? $count[0]['COUNT(0)'] : 0;
			
			$items = $queryItems->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('report/list')
				->set('items', $items)
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('page',  $this->pagenav->size)
				->set('schools',  $this->schools())
				->set('grades',   $this->grades())
				->set('courses',  $courses)
				->set('realname', $this->auth->realname);
				
			$this->output($page, 'report');
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
}
