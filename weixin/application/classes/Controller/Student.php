<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student extends Controller_Base {
	
	protected $data = array();
	
	public function action_infor()
	{
		try {
			$items = DB::select('*')
				->from('guests')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('wx_openid', '=', $this->auth->wx_openid)
				->limit(1)
				->execute()
				->as_array();
			
			if ( empty($items) ) {
				$items = array();
				$v = array();
				$v['agency_id'] = $this->auth->agency_id;
				$v['realname']  = '';
				$v['sex']       = 0;
				$v['signup_by'] = 0;
				$v['agency_id'] = 0;
				$v['entity_id'] = 0;
				$v['school_id'] = 0;
				$v['grade_id']  = 0;
				$v['wx_openid'] = '';
				$v['birthday']  = '';
				$v['mobile']    = '';
				$v['father_name']   = '';
				$v['father_mobile'] = '';
				$v['mother_name']   = '';
				$v['mother_mobile'] = '';
				$v['province']      = 0;
				$v['city']          = 0;
				$v['area']          = 0;
				$v['addr']          = '';
				$items[] = $v;
			}
			
			$page = View::factory('student/infor')
				->set('item',    $items[0])
				->set('schools', $this->schools())
				->set('grades',  $this->grades());
				
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
		$data['signup_by'] = intval($this->request->post('signup_by'));
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
			$items = DB::select('id')
				->from('guests')
				->where('wx_openid', '=', $this->auth->wx_openid)
				->limit(1)
				->execute();
			if ( $items->count() ) {
				DB::update('guests')
					->set($data)
					->where('wx_openid', '=', $this->auth->wx_openid)
					->execute();
			} else {
				$data['agency_id'] = $this->auth->agency_id;
				list($id, $rows) = DB::insert('guests', array_keys($data))
					->values($data)
					->execute();
			}
			
			Session::instance()->set('realname', $data['realname']);			
			HTTP::redirect('/student/infor/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_signup()
	{
		try {
			$user = DB::select('id')
				->from('guests')
				->where('wx_openid', '=', $this->auth->wx_openid)
				->limit(1)
				->execute();
			if ( $user->count() == 0 ) {
				HTTP::redirect('/student/infor/');
			}
			
			$course_id = intval($this->request->query('course_id'));
			if ( empty($course_id) ) {
				HTTP::redirect('/classes/list/');
			}
			
			$courses = DB::select('*')
				->from('guests_courses')
				->where('guest_id',  '=', $user->get('id'))
				->where('course_id', '=', $course_id)
				->execute();
			
			if ( $courses->count() == 0 ) {
				DB::insert('guests_courses', array('guest_id', 'course_id'))
					->values(array('guest_id' => $user->get('id'), 'course_id' => $course_id))
					->execute();
				DB::update('guests')
					->set(array('status' => GUEST_STATUS_AUDIT))
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $user->get('id'))
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
	
	public function action_valid()
	{
		$page = View::factory('student/valid');
		$this->output($page);
	}
	
	public function action_auth()
	{
		$code = strval($this->request->post('code'));
		if ( empty($code) ) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = '请输入验证码';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		$item = DB::select('*')
			->from('student_valid')
			->where('code',  '=', $code)
			->limit(1)
			->execute();
		if ( $item->count() == 0 ) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = '验证码不存在';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		$student_id = $item->get('student_id');
		if ( $student_id == 0 ) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = '验证码无效，请联系机构重发';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		try {
			$data = array();
			$data['status'] = GUEST_STATUS_ENABLED;
			$data['student_id']  = $student_id;
			$data['created_at']  = date('Y-m-d H:i:s');
			$data['modified_at'] = date('Y-m-d H:i:s');
			DB::update('guests')
				->set($data)
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $this->auth->user_id)
				->execute();
			$this->auth->student_id = $student_id;
			Session::instance()->set('student_id', $student_id);
		}  catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_UPDATE;
			$this->ajax_result['msg'] = $e->getMessage();
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
}
