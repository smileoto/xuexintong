<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH.'code.php';

class Auth_User {
	public $user_id;
	public $student_id;
	public $wx_openid;
	public $agency_id;
	public $username;
	public $realname;
	public $school_id;
	public $grade_id;
	public $class_id;
}

class Pagenav {
	public $page;
	public $size;
	public $total_items;
	public $total_pages;
}

class Controller_Base extends Controller {
	
	protected $need_auth = false;
	protected $agency;
	protected $auth;
	protected $ajax_result = array('ret' => 0, 'msg' => 'success');
	
	public function before() 
	{
		$this->auth = new Auth_User;
		
		$this->auth->user_id     = intval( Session::instance()->get('user_id') );
		$this->auth->student_id  = intval( Session::instance()->get('student_id') );
		$this->auth->wx_openid   = strval( Session::instance()->get('wx_openid') );
		$this->auth->agency_id   = intval( Session::instance()->get('agency_id') );
		$this->auth->username    = strval( Session::instance()->get('username') );
		$this->auth->realname    = strval( Session::instance()->get('realname') );
		$this->auth->school_id   = intval( Session::instance()->get('school_id') );
		$this->auth->grade_id    = strval( Session::instance()->get('grade_id') );
		
		$this->init_agency();//$this->auth->wx_openid = 'abcdefg';
		if ( $this->request->action() != 'wx_login' and empty($this->auth->wx_openid) ) {
			Session::instance()->set('callback_url', '/'.$this->request->controller().'/'.$this->request->action().'/');
			$this->wx_auth();
		}
		
		$this->pagenav = new Pagenav;
		$this->pagenav->page = intval($this->request->query('page'));
		$this->pagenav->size = intval($this->request->query('size'));
				
		$this->pagenav->page   = ($this->pagenav->page < 1)  ? 1  : $this->pagenav->page;
		$this->pagenav->size   = ($this->pagenav->size < 1 ) ? 10 : $this->pagenav->size;
		$this->pagenav->offset = ($this->pagenav->page - 1) * $this->pagenav->size;
		
		//$this->auth->student_id = 5;
		if ( empty( $this->auth->student_id ) and !$this->refresh_student_infor() ) {
			switch ( $this->request->controller() ) {
				case 'Feedback':
				case 'Comment':
				case 'task':
				case 'report': HTTP::redirect('/student/deny/');
				default:return;
			}
		}
	}
	
	public function init_agency()
	{
		if ( empty($this->auth->agency_id) ) {
			$this->auth->agency_id = intval($this->request->query('aid'));
			//Session::instance()->set('agency_id', $this->auth->agency_id);
		}
		
		try {
			$this->agency = DB::select('*')
				->from('agencies')
				->where('id', '=', $this->auth->agency_id)
				->limit(1)
				->execute();
				
			Session::instance()->set('agency_id', $this->auth->agency_id);
		} catch ( Database_Exception $e ) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function wx_auth() 
	{
		$aid  = $this->agency->get('id');
		$data = array();
		$data['appid']         = $this->agency->get('wx_appid');
		$data['response_type'] = 'code';
		$data['scope']         = 'snsapi_userinfo';
		$data['state']         = $this->agency->get('id');
		$data['redirect_uri']  = urlencode( URL::base('http', true) . 'auth/wx_login/' );
		
		$params = array();
		foreach ($data as $key => $val) {
			$params[] = $key.'='.$val;
		}
		
		$auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?' . implode('&', $params) .'#wechat_redirect';
		header('Location: '.$auth_url);
		exit;
	}
	
	public function action_wx_login()
	{
		$data = array();
		$data['appid']   = $this->agency->get('wx_appid');
		$data['secret']  = $this->agency->get('wx_secret');
		$data['code']    = $_GET['code'];
		$data['grant_type'] = 'authorization_code';
		
		$params = array();
		foreach ($data as $key => $val) {
			$params[] = $key.'='.$val;
		}
		
		$access_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?' . implode('&', $params);
		
		//初始化
		$ch = curl_init();
		//设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, $access_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//执行并获取HTML文档内容
		$jsonStr = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		
		$result = json_decode($jsonStr, true);
		if ( isset($result['errcode']) ) {
			HTTP::redirect('/agency/index/');
			echo 'wx_openid: ',$this->auth->wx_openid,'<br />';
			echo 'openid: ',Session::instance()->get('wx_openid'),'<br />';
			echo '<pre>';
			print_r($_GET);
			echo '</pre>';
			echo $access_url,'<br />';
			echo '<pre>';
			print_r($result);
			echo '</pre>';
			exit;
		}

		$r1 = $this->auto_login( $result['openid'] );
		$r2 = $this->save_wx_userinfo( $result['openid'], $result['access_token'] );
		
		if ( $r1 and $r2 ) {
			$callback_url = Session::instance()->get('callback_url');
			if ( empty($callback_url) ) {
				$callback_url = '/agency/index/';
			}
			HTTP::redirect($callback_url);
		}
	}
	
	public function auto_login( $wx_openid )
	{
		Session::instance()->set('wx_openid', $wx_openid);
		
		try {
			$user = DB::select('*')
				->from('guests')
				->where('agency_id', '=', $this->agency->get('id'))
				->where('wx_openid', '=', $wx_openid)
				->limit(1)
				->execute();
			if ( $user->count() ) {
				$this->auth->user_id    = $user->get('id');
				$this->auth->student_id = $user->get('student_id');
				$this->auth->wx_openid  = $user->get('wx_openid');
				$this->auth->agency_id  = $user->get('agency_id');
				$this->auth->username   = $user->get('username');
				$this->auth->realname   = $user->get('realname');
				$this->auth->school_id  = $user->get('school_id');
				$this->auth->grade_id   = $user->get('grade_id');
				
				Session::instance()->set('user_id',    $this->auth->user_id);
				Session::instance()->set('student_id', $this->auth->student_id);
				Session::instance()->set('agency_id',  $this->auth->agency_id);
				Session::instance()->set('username',   $this->auth->username);
				Session::instance()->set('realname',   $this->auth->realname);
				Session::instance()->set('school_id',  $this->auth->school_id);
				Session::instance()->set('grade_id',   $this->auth->grade_id);
			} else {
				//Session::instance()->set('wx_openid', $this->auth->wx_openid);
				Session::instance()->set('agency_id', $this->auth->agency_id);
			}
			
			return true;
			
		} catch ( Database_Exception $e ) {
			$this->response->body($e->getMessage());
			return false;
		}
	}
	
	protected function save_wx_userinfo($wx_openid, $access_token)
	{
		try {
			$wx_user = DB::select('*')
				->from('wx_users')
				->where('openid', '=', $wx_openid)
				->limit(1)
				->execute();
			if ( $wx_user->count() ) {
				return true;
			}
			
			
			$access_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $wx_openid . '&lang=zh_CN';
			
			//初始化
			$ch = curl_init();
			//设置选项，包括URL
			curl_setopt($ch, CURLOPT_URL, $access_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			//执行并获取HTML文档内容
			$jsonStr = curl_exec($ch);
			//释放curl句柄
			curl_close($ch);
			
			$result = json_decode($jsonStr, true);
			if ( isset($result['errcode']) ) {
				echo $access_url,'<br />';
				echo '<pre>';
				print_r($result);
				echo '</pre>';
				exit;
			}
		
			$user = array();
			$user['openid']     = $result['openid'];
			$user['nickname']   = $result['nickname'];
			$user['sex']        = $result['sex'];
			$user['province']   = $result['province'];
			$user['country']    = $result['country'];
			$user['headimgurl'] = $result['headimgurl'];
			$user['privilege']  = implode( ',', $result['privilege'] );
			DB::insert('wx_users', array_keys($user))
				->values($user)
				->execute();
				
			return true;
			
		} catch ( Database_Exception $e ) {
			$this->response->body($e->getMessage());
			return false;
		}
	}
	
	public function refresh_student_infor()
	{
		$user = DB::select('*')
				->from('guests')
				->where('agency_id', '=', $this->agency->get('id'))
				->where('id', '=', $this->auth->user_id)
				->limit(1)
				->execute();
		if ( $user->count() ) {
			$this->auth->user_id    = $user->get('id');
			$this->auth->student_id = $user->get('student_id');
			$this->auth->wx_openid  = $user->get('wx_openid');
			$this->auth->agency_id  = $user->get('agency_id');
			$this->auth->username   = $user->get('username');
			$this->auth->realname   = $user->get('realname');
			$this->auth->school_id  = $user->get('school_id');
			$this->auth->grade_id   = $user->get('grade_id');
			
			Session::instance()->set('user_id',    $this->auth->user_id);
			Session::instance()->set('student_id', $this->auth->student_id);
			Session::instance()->set('agency_id',  $this->auth->agency_id);
			Session::instance()->set('username',   $this->auth->username);
			Session::instance()->set('realname',   $this->auth->realname);
			Session::instance()->set('school_id',  $this->auth->school_id);
			Session::instance()->set('grade_id',   $this->auth->grade_id);
			
			return $this->auth->student_id;
		} 
		
		return false;
	}
	
	public function output(&$page)
	{
		$page->html_footer_content = View::factory('footer')
			->set('agency', $this->agency);
		$page->render();
		$this->response->body($page);
	}
	
	public function entities() 
	{
		$entities = array();
		
		$items = DB::select('id', 'name')
			->from('entities')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$entities[$v['id']] = $v;
		}
		
		if ( count($entities) == 0 ) {
			$entities[] = array('id' => 0, 'name' => '总部');
		}
		
		return $entities;
	}
	
	public function schools()
	{
		$schools = array();
		
		$items = DB::select('id', 'name')
			->from('schools')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$schools[$v['id']] = $v;
		}
		
		return $schools;
	}
	
	public function grades()
	{
		$grades = array();
		
		$items = DB::select('id', 'name')
			->from('grades')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$grades[$v['id']] = $v;
		}
		
		return $grades;
	}
	
	public function classes()
	{
		$classes = array();
		
		$items = DB::select('id', 'name', 'entity_id')
			->from('classes')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$classes[$v['id']] = $v;
		}
		
		return $classes;
	}
	
	public function courses()
	{
		$courses = array();
		
		$items = DB::select('id', 'name', 'class_id')
			->from('courses')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$courses[$v['id']] = $v;
		}
		
		return $courses;
	}
}
