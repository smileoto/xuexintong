<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Task extends Controller_Base {

	public function action_index()
	{		
		try {
			$items = DB::select('tasks.id','tasks.title','tasks.date_str',array('courses.name', 'class'),array('schools.name', 'school'),array('grades.name', 'grade'))
				->from('tasks')
				->join('students_courses')
				->on('tasks.course_id', '=', 'students_courses.course_id')
				->join('courses', 'LEFT')
				->on('tasks.course_id', '=', 'courses.id')
				->join('schools', 'LEFT')
				->on('tasks.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('tasks.grade_id', '=', 'grades.id')
				->where('students_courses.student_id', '=', $this->auth->student_id)
				->where('tasks.agency_id', '=', $this->auth->agency_id)
				->where('tasks.status', '=', STATUS_NORMAL)
				->order_by('tasks.id', 'DESC')
				->offset($this->pagenav->page)
				->limit(1)
				->execute();
			
			$items = $items->count() ? $items->as_array() : array(array('id'=>0));
			
			$page = View::factory('task/index')
				->set('item', $items[0]);
				
			$this->output($page);
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
}
