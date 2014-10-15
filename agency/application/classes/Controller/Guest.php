<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Guest extends Controller_Base {
	
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
			->from('guests')
			->where('guests.agency_id', '=', $this->auth->agency_id)
			->where('guests.status', '=', GUEST_STATUS_AUDIT);
		
		
		$queryItems = DB::select('guests.*',array('schools.name', 'school'),array('grades.name','grade'),array('courses.name', 'class'))
			->from('guests')
			->join('schools', 'LEFT')
			->on('guests.school_id', '=', 'schools.id')
			->join('grades', 'LEFT')
			->on('guests.grade_id', '=', 'grades.id')
			->join('guests_courses', 'LEFT')
			->on('guests.id', '=', 'guests_courses.guest_id')
			->join('courses', 'LEFT')
			->on('guests_courses.course_id', '=', 'courses.id')
			->where('guests.agency_id', '=', $this->auth->agency_id)
			->where('guests.status', '=', GUEST_STATUS_AUDIT);
				
		if ( $entity ) {
			$queryItems->where('guests.entity_id', '=', $entity);
			$queryCount->where('guests.entity_id', '=', $entity);
		}
		
		if ( $school ) {
			$queryItems->where('guests.school_id', '=', $school);
			$queryCount->where('guests.school_id', '=', $school);
		}
		if ( $grade ) {
			$queryItems->where('guests.grade_id', '=', $grade);
			$queryCount->where('guests.grade_id', '=', $grade);
		}
		if ( $class ) {
			$queryItems->where('guests_courses.course_id', '=', $class);
			$queryCount->join('guests_courses', 'LEFT')
				->on('guests.id', '=', 'guests_courses.guest_id')
				->where('guests_courses.course_id', '=', $class);
		}
		if ( $realname ) {
			$queryItems->where('guests.realname', '=', $realname);
			$queryCount->where('guests.realname', '=', $realname);
		}
		if ( $sex != '' ) {
			$queryItems->where('guests.sex', '=', $sex);
			$queryCount->where('guests.sex', '=', $sex);
		}
		if ( $mobile ) {
			$queryItems->where('guests.mobile', '=', $mobile);
			$queryCount->where('guests.mobile', '=', $mobile);
		}
		if ( $father_name ) {
			$queryItems->where('guests.father_name', '=', $father_name);
			$queryCount->where('guests.father_name', '=', $father_name);
		}
		if ( $father_mobile ) {
			$queryItems->where('guests.father_mobile', '=', $father_mobile);
			$queryCount->where('guests.father_mobile', '=', $father_mobile);
		}
		if ( $mother_name ) {
			$queryItems->where('guests.mother_name', '=', $mother_name);
			$queryCount->where('guests.mother_name', '=', $mother_name);
		}
		if ( $mother_mobile ) {
			$queryItems->where('guests.mother_mobile', '=', $mother_mobile);
			$queryCount->where('guests.mother_mobile', '=', $mother_mobile);
		}
		
		
		$cnt = $queryCount->execute();			
		$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
		
		$items = $queryItems->offset($this->pagenav->offset)
			->limit($this->pagenav->size)
			->execute()
			->as_array();
		
		$page = View::factory('guest/list')
			->set('items',    $items)
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
	
	public function action_audit()
	{		
		$id = intval($this->request->query('id'));
			
		$result = DB::select('course_id')
			->from('guests_courses')
			->where('guest_id', '=', $id)
			->execute()
			->as_array();
		$guest_courses = array();
		foreach ( $result as $v ) {
			$guest_courses[$v['course_id']] = 1;
		}
		
		$items = DB::select('*')
			->from('guests')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/guest/list/');
		}
		
		$page = View::factory('guest/audit')
			->set('item', $items[0])
			->set('schools', $this->schools())
			->set('grades',  $this->grades())
			->set('courses', $this->courses())
			->set('guest_courses', $guest_courses)
			->set('entities', $this->entities());
			
		$this->output($page, 'student');
	}
	
	public function action_save()
	{
		$student_id = intval($this->request->post('student_id'));
		
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
		$data['school_id']      = intval($this->request->post('school'));
		$data['grade_id']       = intval($this->request->post('grade'));

		$data['email'] = strval($this->request->post('email'));
		$data['QQ']    = strval($this->request->post('QQ'));
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$courses = $this->request->post('course');
		
		$id = intval($this->request->post('id'));
		
		try {
			$new_student = false;
			if ( empty( $student_id ) ) {
				$new = $data;
				$new['created_at'] = date('Y-m-d H:i:s');
				$new['created_by'] = $this->auth->user_id;
				$new['agency_id']  = $this->auth->agency_id;
				list($student_id, $rows) = DB::insert('students', array_keys($new))
					->values($new)
					->execute();
				$new_student = true;
			}
			
			DB::delete('guests_courses')
				->where('guest_id',   '=', $id)
				->execute();
			DB::delete('students_courses')
				->where('student_id', '=', $student_id)
				->execute();
			
			$data['status'] = GUEST_STATUS_ENABLED;
			//$data['student_id'] = $student_id;
			$rows = DB::update('guests')
				->set($data)
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $id)
				->execute();
			
			if ( $courses ) {					
				$guest_courses = array(
					'guest_id'  => $id,
					'course_id' => 0
				);
				$insert = DB::insert('guests_courses', array_keys($guest_courses));
				foreach ($courses as $course_id) {
					if ( empty($course_id) ) continue;
					$guest_courses['course_id'] = $course_id;
					$insert->values($guest_courses);
				}
				$insert->execute();
				
				$student_courses = array(
					'student_id' => $student_id,
					'course_id'  => 0
				);
				$insert = DB::insert('students_courses', array_keys($student_courses));
				foreach ($courses as $course_id) {
					if ( empty($course_id) ) continue;
					$student_courses['course_id'] = $course_id;
					$insert->values($student_courses);
				}
				$insert->execute();
			}
			
			HTTP::redirect('/student/notify/?id='.$student_id);
			//HTTP::redirect('/student/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
		
	public function action_del()
	{
		$id = intval($this->request->query('id'));
				
		try {
			DB::update('guests')
				->set( array('status'=>STATUS_DELETED, 'modify_t'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/guest/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
}
