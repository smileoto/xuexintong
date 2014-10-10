<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Session extends Controller_Base {
	
	protected function set_session(&$user, &$agency)
	{
		$session = Session::instance();
		$session->set('user_id',   $user->get('id'));
		$session->set('agency_id', $user->get('agency_id'));
		$session->set('role_id',   $user->get('role_id'));
		$session->set('username',  $user->get('username'));
		$session->set('nickname',  $user->get('nickname'));
		$session->set('weixin',    $user->get('weixin'));
		$session->set('category',  $user->get('category'));
		$session->set('add_t',     $user->get('add_t'));
		$session->set('modify_t',  $user->get('modify_t'));
		
		$session->set('agency_name',  $agency->get('realname'));
	}
	
	public function action_index()
	{
		$page = View::factory('login')->render();
		
		$this->response->body($page);
	}

	public function action_start()
	{		
		$agency_sid = $this->request->post('agency_sid');
		$username   = $this->request->post('username');
		$password   = $this->request->post('password');
		
		if ( !$username or !$password ) {
		}
				
		try {
			$agencies = DB::select('id', 'status', 'realname')
				->from('agencies')
				->where('username', '=', $agency_sid)
				->limit(1)
				->execute();
			if ( !$agencies->count() ) {
				$this->ajax_result['ret'] = ERR_DB_SELECT;
				$this->ajax_result['msg'] = '机构不存在';
				$this->response->body( json_encode($this->ajax_result) ); 
				return;
			}
			
			if ( $agencies->get('status') == STATUS_DISABLED ) {
				$this->ajax_result['ret'] = ERR_USER_PASS;
				$this->ajax_result['msg'] = '机构已停用';
				$this->response->body( json_encode($this->ajax_result) ); 
				return;
			}
			
			$user = DB::select('*')
				->from('users')
				->where('agency_id', '=', $agencies->get('id'))
				->where('username', '=', $username)
				->where('password', '=', $password)
				->limit(1)
				->execute();
				
			if ( $user->count() ) {
				$this->set_session($user, $agencies);
				$this->ajax_result['url'] = URL::base(NULL, TRUE).'agency/index/';
			} else {
				$this->ajax_result['ret'] = ERR_USER_PASS;
				$this->ajax_result['msg'] = '账号或密码错误';
			}
		} catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) ); 
	}
	
	public function action_end()
	{
		Session::instance()->destroy();
		HTTP::redirect('/session/index/');
	}

	public function action_pswd()
	{		
		if ( !$this->request->is_ajax() ) {
			$page = View::factory('pswd');
			$this->output($page, 'change_password');			
			return;
		}
		
		$pswd1 = $this->request->post('pswd1');
		$pswd2 = $this->request->post('pswd2');
		if ( empty($pswd1) or $pswd1 != $pswd2 ) {
			$this->ajax_result['ret'] = ERR_NEW_PASSWORD;
			$this->ajax_result['msg'] = 'new password error!';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		try {
			$row = DB::update('users')
				->set(array('password' => $pswd1))
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $this->auth->user_id)
				->execute();
		} catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_UPDATE;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}

}
