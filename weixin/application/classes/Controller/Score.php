<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Score extends Controller_Auth {
	
	public function action_list()
	{
		$page_no   = intval($this->request->query('page_no'));
		$page_size = intval($this->request->query('page_size'));
				
		$page_no   = ($page_no < 1) ? 1 : $page_no;
		$page_size = ($page_size <= 0 ) ? 10 : $page_size;
		$offset    = ($page_no - 1) * $page_size;
		
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		$date   = intval($this->request->query('date'));
		
		try {
			$schools = DB::select('id', 'name')
				->from('agency_schools')
				->where('agency_id', '=', $this->agency->get('id'))
				->where('id', '=', $this->auth->school_id)
				->execute()
				->as_array();
				
			$grades = DB::select('id', 'name')
				->from('agency_grades')
				->where('agency_id', '=', $this->agency->get('id'))
				->where('id', '=', $this->auth->school_id)
				->execute()
				->as_array();
				
			$courses = DB::select('courses.id', 'courses.name')
				->from('courses')
				->join('students_courses')
				->on('courses.id', '=', 'students_courses.course_id')
				->where('courses.agency_id', '=', $this->agency->get('id'))
				->where('students_courses.student_id', '=', $this->auth->user_id)
				->execute()
				->as_array();
		
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('student_score')
				->join('students')
				->on('student_score.student_id', '=', 'students.id')
				->where('student_score.agency_id', '=', $this->agency->get('id'))
				->where('student_score.student_id', '=', $this->auth->user_id)
				->where('student_score.status', '=', STATUS_NORMAL);
			$queyrList  = DB::select('*')
				->from('student_score')
				->join('students')
				->on('student_score.student_id', '=', 'students.id')
				->where('student_score.agency_id', '=', $this->agency->get('id'))
				->where('student_score.student_id', '=', $this->auth->user_id)
				->where('student_score.status', '=', STATUS_NORMAL);
			
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
			
			$list = $queyrList->offset($offset)
				->limit($page_size)
				->execute()
				->as_array();
			
			$page = View::factory('score/list')
				->set('list',  $list)
				->set('total', $total)
				->set('pages', intval($total / $page_size) + 1)
				->set('page_no', $page_no)
				->set('schools', $schools)
				->set('grades', $grades)
				->set('courses', $courses)
				->set('realname', $this->auth->realname);
				
			$this->output($page, 'score');
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
}
