<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Report extends Controller_Base {
	
	public function action_index()
	{
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		$date   = intval($this->request->query('date'));
		
		try {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('reports')
				->join('students')
				->on('reports.student_id', '=', 'students.id')
				->where('reports.agency_id', '=', $this->auth->agency_id)
				->where('reports.student_id', '=', $this->auth->student_id)
				->where('reports.status', '=', STATUS_NORMAL);
			$queryItems = DB::select('*')
				->from('reports')
				->join('students')
				->on('reports.student_id', '=', 'students.id')
				->where('reports.agency_id', '=', $this->auth->agency_id)
				->where('reports.student_id', '=', $this->auth->student_id)
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
			
			$items = $queryItems->order_by('reports.id', 'DESC')
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('report/list')
				->set('items', $items)
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('page',  $this->pagenav->size)
				->set('realname', $this->auth->realname);
				
			$this->output($page);
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
}
