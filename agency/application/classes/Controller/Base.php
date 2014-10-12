<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH.'code.php';

class Auth_User {
	public $user_id;
	public $username;
	public $nickname;
	public $realname;
	public $role_id;
	public $agency_id;
	public $agency_name;
}

class Pagenav {
	public $page;
	public $size;
	public $total_items;
	public $total_pages;
}

class Controller_Base extends Controller {
	
	protected $auth;
	protected $ajax_result;
		
	public function before() 
	{
		$this->auth = new Auth_User;
		
		$this->auth->user_id     = intval( Session::instance()->get('user_id') );
		$this->auth->username    = strval( Session::instance()->get('username') );
		$this->auth->nickname    = strval( Session::instance()->get('nickname') );
		$this->auth->realname    = strval( Session::instance()->get('realname') );
		$this->auth->role_id     = intval( Session::instance()->get('role_id') );
		$this->auth->agency_id   = intval( Session::instance()->get('agency_id') );
		$this->auth->agency_name = strval( Session::instance()->get('agency_name') );
		
		$this->ajax_result = array('ret' => 0, 'msg' => 'success');
		
		$this->pagenav = new Pagenav;
		$this->pagenav->page = intval($this->request->query('page'));
		$this->pagenav->size = intval($this->request->query('size'));
				
		$this->pagenav->page   = ($this->pagenav->page < 1)  ? 1  : $this->pagenav->page;
		$this->pagenav->size   = ($this->pagenav->size < 1 ) ? 10 : $this->pagenav->size;
		$this->pagenav->offset = ($this->pagenav->page - 1) * $this->pagenav->size;

		if ( $this->auth->role_id == AGENCY_ADMIN or $this->request->controller() == 'Session' ) {
			return true;
		}

		if ( $this->request->is_ajax() ) {
			$this->ajax_result['ret'] = ERR_NOT_LOGIN;
			$this->ajax_result['msg'] = 'need login';
			echo json_encode($this->ajax_result);
			exit;
		} else {
			// redirect
			if ( $this->auth->user_id == 0 ) {
				HTTP::redirect('/session/index/');
			} else {
				// HTTP::redirect('/login/out/');
				echo 'permission deny';exit;
			}
		}
	}
	
	public function generate_left_menu()
	{		
		$query = DB::select('name')
			->from('agency_users_groups')
			->where('user_id', '=', $this->auth->user_id)
			->execute()
			->as_array();
		$this->allowed_menu_items = array();
		foreach ( $query as $rs ) {
			$this->allowed_menu_items[$rs] = 1;
		}
	}
	
	public function output(&$page, $menu = '')
	{		
		$page->html_head_content = View::factory('head')
			->set('agency_name', $this->auth->agency_name)
			->set('username', $this->auth->username);
		$page->html_left_content = View::factory('left')
			->set('active', $menu);
		if ( isset($page->html_pagenav_content) ) {
			$base_url = URL::base(NULL, TRUE).$this->request->controller().'/'.$this->request->action().'/';
			$page->html_pagenav_content->set('base_url', $base_url);
		}
		
		$upload_url = URL::base().'upload.php';
		$xheditor = "xheditor {tools:'full',width:'600',height:'400',cleanPaste:3,upBtnText:'上传',upImgUrl:'$upload_url'}";
		$page->set('xheditor_config', $xheditor);
		$page->render();
		$this->response->body($page);
	}
	
	public function save_to_bcs($filepath)
	{
		require_once APPPATH.'../lib/bcs/bcs.class.php';
		
		$baiduBCS = new BaiduBCS ( BCS_AK, BCS_SK, BCS_HOST );
		$ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
		$object =  '/images/'.date('Ymd').'_'. uniqid().'.'.$ext;
		$response = @$baiduBCS->create_object( BCS_BUCKET, $object, $filepath );
		$url = '';
		if ( $response->isOK() ) {
			$opt = array ();
			$opt["time"] = time() + 3600;
			$url = $baiduBCS->generate_get_object_url( BCS_BUCKET, $object, $opt );
		}
		
		@unlink($filepath);
		
		return $url;
	}
	
	public function entities() 
	{
		$entities = array();
		$entities[] = array('id' => 0, 'name' => '');
		
		$items = DB::select('id', 'name')
			->from('entities')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$entities[$v['id']] = $v;
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
	
	public function get_upload_dir ($module) 
	{
		@mkdir(DOCROOT.'files');
		@chmod(DOCROOT.'files', 0777);
		
		@mkdir(DOCROOT.'files/'.$module);
		@chmod(DOCROOT.'files/'.$module, 0777);
		
		@mkdir(DOCROOT.'files/'.$module.'/'.$this->auth->agency_id);
		@chmod(DOCROOT.'files/'.$module.'/'.$this->auth->agency_id, 0777);
		
		return '/files/'.$module.'/'.$this->auth->agency_id;
	}
}
