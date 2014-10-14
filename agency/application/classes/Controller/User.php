<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Base {

	public function action_list()
	{
		$items = DB::select('id','username', 'realname')
			->from('users')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		
		$rights = array();
		
		$page = View::factory('user/list')
			->set('items',  $items);
		$this->output($page, 'users');
	}
	
	public function action_add()
	{
		$actions = include_once(APPPATH.'config/action.php');
		$page = View::factory('user/add')
			->set('actions', $actions);
		$this->output($page, 'users');
	}
	
	public function action_edit()
	{
		$id  = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('users')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( !count($items) ) {
			HTTP::redirect('user/list');
		}
		
		$result = DB::select('content')->from('user_rights')->where('user_id', '=', $id)->execute();
		$keys = explode(',', $result->get('content'));
		$user_rights = array();
		foreach ($keys as $k) {
			$user_rights[$k] = 1;
		}
		
		$actions = include_once(APPPATH.'config/action.php');
		$page = View::factory('user/edit')
			->set('item', $items[0])
			->set('user_rights', $user_rights)
			->set('actions', $actions);
		$this->output($page, 'users');
	}
	
	public function action_save()
	{
		$data = array();
		$data['username'] = $this->request->post('username');
		$data['password'] = md5(strval($this->request->post('password')));
		$data['realname'] = strval($this->request->post('realname'));
		$data['nickname'] = strval($this->request->post('nickname'));
		$data['mobile']   = strval($this->request->post('mobile'));
		$data['email']    = strval($this->request->post('email'));
		$data['remark']   = strval($this->request->post('remark'));
		
		$data['modified_at'] = date('Y-m-d');
		$data['modified_by'] = $this->auth->user_id;
		
		$user_rights = array();
		$rights = $this->request->post('user_rights');
		$actions = include_once(APPPATH.'config/action.php');
		foreach ($rights as $key) {
			if ( !isset($actions[$key]) ) {
				continue;
			}
			
			if ( isset($actions[$key]['bind']) ) {
				foreach ($actions[$key]['bind'] as $act) {
					$user_rights[$act] = 1;
				}
			} else {
				$user_rights[$key] = 1;
			}
		}
		
		$id  = intval($this->request->post('id'));
		try {
			if ( $id ) {
				$items = DB::select('id')
					->from('users')
					->where('agency_id', '=', $this->auth->agency_id)
					->where('username',  '=', $data['username'])
					->where('id', '<>', $id)
					->limit(1)
					->execute();
				if ( $items->count() ) {
					HTTP::redirect('/user/edit/?id='.$id);
				}
			
				DB::update('users')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$items = DB::select('id')
					->from('users')
					->where('agency_id', '=', $this->auth->agency_id)
					->where('username', '=', $data['username'])
					->limit(1)
					->execute();
				if ( $items->count() ) {
					HTTP::redirect('/user/add/');
				}
			
				$data['created_at'] = date('Y-m-d');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				list($id, $rows) = DB::insert('users', array_keys($data))
					->values($data)
					->execute();
			}
			
			if ( empty($user_rights) ) {
				$user_rights = array();
			}
			
			$str_user_rights = implode(',', array_keys($user_rights));
			$rows = DB::update('user_rights')
				->set( array( 'content' => $str_user_rights ) )
				->where('user_id', '=', $id)
				->execute();
			if ( empty($rows) ) {
				DB::insert('user_rights', array('user_id', 'content'))
					->values( array( 'user_id' => $id, 'content' => $str_user_rights ) )
					->execute();
			}
			
			HTTP::redirect('/user/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
		
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			$data = array();
			$data['status']      = STATUS_DELETED;
			$data['modified_at'] = date('Y-m-d H:i:s');
			DB::update('users')
				->set($data)
				->where('agency_id', '=', $this->auth->agency_id)
				->where('user_id', '=', $id)
				->execute();
			HTTP::redirect('/user/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_deny()
	{
		$page = View::factory('user/deny');
		$this->output($page, 'users');
	}
	
}
