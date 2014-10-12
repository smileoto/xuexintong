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
		$actions = include(APPPATH.'config/action.php')
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
		
		$result = DB::select('name')->from('users_actions')->where('user_id', '=', $id)->execute()->as_array();
		$users_actions = array();
		foreach ($result as $v) {
			$users_actions[$v['name']] = $v['allow'];
		}
		
		$actions = include(APPPATH.'config/action.php')
		$page = View::factory('user/edit')
			->set('item', $items[0])
			->set('users_actions', $users_actions)
			->set('actions', $actions);
		$this->output($page, 'users');
	}
	
	public function action_save()
	{
		$data = array();
		$data['username'] = strval($this->request->post('username'));
		
		$items = DB::select('*')
			->from('users')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('username', '=', $data['username'])
			->limit(1)
			->execute()
			->as_array();
		if ( count($items) ) {
			$this->ajax_result['ret'] = ERR_DB_INSERT;
			$this->ajax_result['msg'] = '用户名重复';
			return;
		}
		
		$data['password'] = md5(strval($this->request->post('password')));
		$data['realname'] = strval($this->request->post('realname'));
		$data['nickname'] = strval($this->request->post('nickname'));
		$data['mobile']   = strval($this->request->post('mobile'));
		$data['mail']     = strval($this->request->post('mail'));
		$data['remark']   = strval($this->request->post('remark'));
		
		$data['modified_at'] = date('Y-m-d');
		$data['modified_by'] = $this->auth->user_id;
		
		$users_actions = $this->request->post('users_actions');
		
		$id  = intval($this->request->post('id'));
		try {
			if ( $id ) {
				DB::update('users')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = date('Y-m-d');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				list($id, $rows) = DB::insert('users', array_keys($data))
					->values($data)
					->execute();
			}
			
			DB::delete('users_actions')
				->where('user_id', '=', $id)
				->execute();
			
			if ( $users_actions ) {
				$data = array('user_id' => $user_id, 'name' => '', 'allow' => 0);
				$insert = DB::insert('users_actions', array_keys($data));
				foreach ( $users_actions as $name ) {
					$data['user_id'] = $user_id;
					$data['name']    = $name;
					$data['allow']   = 1;
					$insert->values($data);
				}
				$insert->execute();
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
			$data['status']   = STATUS_DELETED;
			$data['modified_at'] = date('Y-m-d H:i:s');
			DB::update('users')
				->set($data)
				->execute();
			HTTP::redirect('/user/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
