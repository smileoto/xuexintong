<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student extends Controller_Base {
	
	public function action_list()
	{		
		$entity   = $this->request->query('entity');
		$school   = $this->request->query('school');
		$grade    = $this->request->query('grade');
		$class    = $this->request->query('class');
		$realname = $this->request->query('realname');
		$sex      = $this->request->query('sex');
		$mobile   = $this->request->query('mobile');
		$father_name   = $this->request->query('father_name');
		$father_mobile = $this->request->query('father_mobile');
		$mother_name   = $this->request->query('mother_name');
		$mother_mobile = $this->request->query('mother_mobile');
		
		$expr = DB::expr('COUNT(0)');
		$queryCount = DB::select($expr)
			->from('students')
			->where('students.agency_id', '=', $this->auth->agency_id);
		
		
		$queryList = DB::select('students.*',array('schools.name', 'school'),array('grades.name','grade'),array('courses.name', 'class'))
			->from('students')
			->where('students.agency_id', '=', $this->auth->agency_id)
			->join('schools', 'LEFT')
			->on('students.school_id', '=', 'schools.id')
			->join('grades', 'LEFT')
			->on('students.grade_id', '=', 'grades.id')
			->join('students_courses', 'LEFT')
			->on('students.id', '=', 'students_courses.student_id')
			->join('courses', 'LEFT')
			->on('students_courses.course_id', '=', 'courses.id');
				
		if ( $entity ) {
			$queryList->where('students.entity_id',  '=', $entity);
			$queryCount->where('students.entity_id', '=', $entity);
		}
		
		if ( $school ) {
			$queryList->where('students.school_id',  '=', $school);
			$queryCount->where('students.school_id', '=', $school);
		}
		if ( $grade ) {
			$queryList->where('students.grade_id',  '=', $grade);
			$queryCount->where('students.grade_id', '=', $grade);
		}
		if ( $class ) {
			$queryList->where('students_courses.course_id', '=', $class);
			$queryCount->join('students_courses', 'LEFT')
				->on('students.id', '=', 'students_courses.student_id')
				->where('students_courses.course_id', '=', $class);
		}
		if ( $realname ) {
			$queryList->where('students.realname', '=', $realname);
			$queryCount->where('students.realname', '=', $realname);
		}
		if ( $sex != '' ) {
			$queryList->where('students.sex', '=', $sex);
			$queryCount->where('students.sex', '=', $sex);
		}
		if ( $mobile ) {
			$queryList->where('students.mobile', '=', $mobile);
			$queryCount->where('students.mobile', '=', $mobile);
		}
		if ( $father_name ) {
			$queryList->where('students.father_name', '=', $father_name);
			$queryCount->where('students.father_name', '=', $father_name);
		}
		if ( $father_mobile ) {
			$queryList->where('students.father_mobile', '=', $father_mobile);
			$queryCount->where('students.father_mobile', '=', $father_mobile);
		}
		if ( $mother_name ) {
			$queryList->where('students.mother_name', '=', $mother_name);
			$queryCount->where('students.mother_name', '=', $mother_name);
		}
		if ( $mother_mobile ) {
			$queryList->where('students.mother_mobile', '=', $mother_mobile);
			$queryCount->where('students.mother_mobile', '=', $mother_mobile);
		}
		
		
		$cnt = $queryCount->execute();			
		$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
		
		$items = $queryList->offset($this->pagenav->offset)
			->limit($this->pagenav->size)
			->execute()
			->as_array();
		
		$pop = Arr::get($_GET, 'pop', 0);
		$viewname = $pop ? 'student/list_for_select' : 'student/list';
		$page = View::factory($viewname)
			->set('items',   $items)
			->set('entities', $this->entities())
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('classes',  $this->courses());
		$page->html_pagenav_content = View::factory('pagenav')
			->set('total', $total)
			->set('page',  $this->pagenav->page)
			->set('size',  $this->pagenav->size);
		$this->output($page, 'student');	
	}
	
	public function action_add()
	{
		$adult = Arr::get($_GET, 'adult', 0);
		
		$viewname = $adult ? 'student/add_adult' : 'student/add';
		$page = View::factory($viewname)
			->set('entities', $this->entities())
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('classes',  $this->courses());			
		$this->output($page, 'student');		
	}
	
	public function action_edit()
	{
		$viewname = 'student/edit';		
		$adult = Arr::get($_GET, 'adult', 0);
		if ( $adult ) {
			$viewname .= '_adult';
		}
		
		$id = intval($this->request->query('id'));
			
		$result = DB::select('course_id')
			->from('students_courses')
			->where('student_id', '=', $id)
			->execute()
			->as_array();
		$data_courses = array();
		foreach ( $result as $v ) {
			$data_courses[$v['course_id']] = 1;
		}
		
		$items = DB::select('*')
			->from('students')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/student/list/');
		}
		
		$page = View::factory($viewname)
			->set('itme',    $items[0])
			->set('schools', $schools)
			->set('grades',  $grades)
			->set('courses', $courses)
			->set('student_courses', $data_courses)
			->set('entities', $this->entities());
			
		$this->output($page, 'student');
	}
	
	public function action_save()
	{
		$data = array();
		
		$data['sex']       = intval($this->request->post('sex'));
		$data['realname']  = $this->request->post('realname');
		$data['mobile']    = $this->request->post('mobile');
		$data['birthday']  = $this->request->post('birthday');
		$data['province']  = intval($this->request->post('province'));
		$data['city']      = intval($this->request->post('city'));
		$data['area']      = intval($this->request->post('area'));
		$data['addr']      = $this->request->post('addr');
		$data['remark']    = $this->request->post('remark');
		$data['signup_by'] = intval($this->request->post('signup_by'));
		
		$data['father_name']    = strval($this->request->post('father_name'));
		$data['father_mobile']  = strval($this->request->post('father_mobile'));
		$data['mother_name']    = strval($this->request->post('mother_name'));
		$data['mother_mobile']  = strval($this->request->post('mother_mobile'));
		
		$data['entity_id']      = intval($this->request->post('entity_id'));
		$data['school_id']      = intval($this->request->post('school_id'));
		$data['grade_id']       = intval($this->request->post('grade_id'));

		$data['email'] = strval($this->request->post('email'));
		$data['QQ']    = strval($this->request->post('QQ'));
		
		$data['modified_at'] = NULL;
		$data['modified_by'] = $this->auth->user_id;
		
		$courses = explode( ',', strval( $this->request->post('class') ) );
		
		$id = intval($this->request->post('id'));
		
		try {
			DB::delete('students_courses')
				->where('student_id', '=', $id)
				->execute();
				
			if ( $id ) {
				$rows = DB::update('students')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = NULL;
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				list($id, $rows) = DB::insert('students', array_keys($data))
					->values($data)
					->execute();
			}
					
			$student_courses = array(
				'student_id'  => $id,
				'course_id'   => 0
			);
			
			if ( $courses ) {
				$insert = DB::insert('students_courses', array_keys($student_courses));
				foreach ($courses as $course_id) {
					if ( empty($course_id) ) continue;
					$student_courses['course_id'] = $course_id;
					$insert->values($student_courses);
				}
				$insert->execute();
			}
			
		} catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_INSERT;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
		
	public function action_del()
	{
		$id = intval($this->request->query('id'));
				
		try {
			DB::update('students')
				->set( array('status'=>STATUS_DELETED, 'modify_t'=>NULL) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/students/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
}
