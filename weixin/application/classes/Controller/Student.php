<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student extends Controller_Auth {
	
	protected $data = array();
	
	public function action_infor()
	{
		try {
			$students = DB::select('*')
				->from('register')
				->where('agency_id', '=', $this->agency->get('id'))
				->where('wx_openid', '=',  $this->auth->wx_openid)
				->limit(1)
				->execute()
				->as_array();
			
			$student = array();
			if ( empty($students) ) {
				$student['realname']  = '';
				$student['sex']       = 0;
				$student['role']      = 0;
				$student['school_id'] = 0;
				$student['grade_id']  = 0;
				$student['wx_openid'] = '';
				$student['birthday']  = '';
				$student['mobile']    = '';
				$student['father_name']   = '';
				$student['father_mobile'] = '';
				$student['mother_name']   = '';
				$student['mother_mobile'] = '';
				$student['province']      = 0;
				$student['city']      = 0;
				$student['area']      = 0;
				$student['addr']      = '';
			} else {
				$student = $students[0];
			}
			
			$schools = DB::select('id', 'name')
				->from('agency_schools')
				->where('agency_id', '=', $this->agency->get('id'))
				->execute()
				->as_array();
			
			$grades = DB::select('id', 'name')
				->from('agency_grades')
				->where('agency_id', '=', $this->agency->get('id'))
				->execute()
				->as_array();
			
			$page = View::factory('student/infor')
				->set('student', $student)
				->set('html_title_content', '我的资料')
				->set('schools', $schools)
				->set('grades', $grades);
				
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_save()
	{
		if ( empty($this->auth->wx_openid) ) {
			HTTP::redirect('/agency/index/');
		}
		
		$data = array();
		$data['wx_openid'] = $this->auth->wx_openid;
		$data['realname']  = strval($this->request->post('realname'));
		$data['sex']       = intval($this->request->post('sex'));
		$data['role']      = intval($this->request->post('role'));
		$data['school_id'] = intval($this->request->post('school_id'));
		$data['grade_id']  = intval($this->request->post('grade_id'));
		$data['birthday']  = strval($this->request->post('birthday'));
		$data['mobile']    = strval($this->request->post('mobile'));
		$data['father_name']   = strval($this->request->post('father_name'));
		$data['father_mobile'] = strval($this->request->post('father_mobile'));
		$data['mother_name']   = strval($this->request->post('mother_name'));
		$data['mother_mobile'] = strval($this->request->post('mother_mobile'));
		$data['province']      = intval($this->request->post('province'));
		$data['city']      = intval($this->request->post('city'));
		$data['area']      = intval($this->request->post('area'));
		$data['addr']      = strval($this->request->post('addr'));
		
		try {
			$users = DB::select('id')
				->from('register')
				->where('wx_openid', '=', $this->auth->wx_openid)
				->limit(1)
				->execute();
			if ( $users->count() ) {
				DB::update('register')
					->set($data)
					->where('wx_openid', '=', $this->auth->wx_openid)
					->execute();
			} else {
				$data['agency_id'] = $this->agency->get('id');
				list($id, $rows) = DB::insert('register', array_keys($data))
					->values($data)
					->execute();
			}
			
		} catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_INSERT;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
	
	public function action_signup()
	{
		try {
			$users = DB::select('id')
				->from('register')
				->where('wx_openid', '=', $this->auth->wx_openid)
				->limit(1)
				->execute();
			if ( !$users->count() ) {
				HTTP::redirect('/student/infor/');
			}
			
			$course_id = intval($this->request->query('course_id'));
			if ( empty($course_id) ) {
				HTTP::redirect('/classes/list/');
			}
			
			$courses = DB::select('*')
				->from('students_courses')
				->where('register_id', '=', $users->get('id'))
				->where('course_id', '=', $course_id)
				->execute();
			
			if ( !$courses->count() ) {
				DB::insert('students_courses', array('register_id', 'course_id'))
					->values(array('register_id' => $users->get('id'), 'course_id' => $course_id))
					->execute();
				DB::update('register')
					->set(array('status' => 1))
					->where('agency_id', '=', $this->agency->get('id'))
					->where('id', '=', $users->get('id'))
					->execute();
			}
			
			$page = View::factory('signup/success')
				->set('html_title_content', '递交资料');
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_deny() 
	{
		$page = View::factory('deny');
		$this->output($page);
	}
}
