<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Task extends Controller_Auth {

	public function action_index()
	{		
		try {
			$items = DB::select('tasks.id','tasks.title','tasks.date_str',array('courses.name', 'class'))
				->from('tasks')
				->join('students_courses')
				->on('tasks.course_id', '=', 'students_courses.course_id')
				->join('courses', 'LEFT')
				->on('tasks.course_id', '=', 'courses.id')
				->where('students_courses.student_id', '=', $this->auth->student_id)
				->where('tasks.agency_id', '=', $this->agency->get('agency_id'))
				->where('tasks.status', '=', STATUS_NORMAL)
				->order_by('tasks.id', 'DESC')
				->offset($this->pagenav->page)
				->limit(1)
				->execute();
			
			$items = $items->count() ? $items->as_array() : array('id'=>0);
			
			$page = View::factory('tasks/index')
				->set('item',    $items[0])
				->set('schools', $this->schools())
				->set('grades',  $this->grades());
				
			$this->output($page);
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
}
