<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Top extends Controller_Base {

	public function action_index()
	{		
		try {
			$offset = ($this->pagenav->page > 0) ? ($this->pagenav->page - 1) : 0;
			$items = DB::select('tops.*')
				->from('tops')
				->where('tops.agency_id', '=',  $this->auth->agency_id)
				->where('tops.status', '=', STATUS_ENABLED)
				->order_by('tops.id', 'DESC')
				->offset($offset)
				->limit(1)
				->execute();
			
			$items = $items->count() ? $items->as_array() : array(array('id' => 0, 'begin_str' => '--', 'end_str' => '--' ));
			$item  = $items[0];
			
			$students = DB::select('tops_students.*','students.*',array('schools.name', 'school'),array('grades.name', 'grade'))
				->from('tops_students')
				->join('students')
				->on('tops_students.student_id', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades',  'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->where('tops_students.top_id', '=', $item['id'])
				->execute()
				->as_array();
					
			$page = View::factory('top/index')
				->set('item', $item)
				->set('page', $this->pagenav->page)
				->set('students', $students);
				
			$this->output($page);
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}

}
