<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Entity extends Controller_Base {
	
	public function action_list()
	{
		$items = DB::select('*')
			->from('entities')
			->where('parent_id', '=', $this->auth->agency_id)
			->execute()
			->as_array();
									
		$page = View::factory('entity/list')
			->set('items', $items);

		$this->output($page, 'setting');
	}
	
	public function action_add()
	{
		$page = View::factory('entity/add');
		$this->output($page, 'setting');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('entities')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/entity/list/');
		}
		
		$page = View::factory('entity/edit')
			->set('item', $items[0]);
		$this->output($page, 'setting');
	}
	
	public function action_save()
	{
		$data = array();
		
		$data['realname']  = $this->request->post('realname');
		$data['remark']    = strval($this->request->post('remark'));
		$data['addr']      = $this->request->post('addr');
		$data['mobile']    = $this->request->post('mobile');
		$data['contact']   = $this->request->post('contact');
		$data['email']     = strval($this->request->post('mail'));
		$data['province']  = intval($this->request->post('province'));
		$data['city']      = intval($this->request->post('city'));
		$data['area']      = intval($this->request->post('area'));
		
		$data['modified_at'] = NULL;
		
		$id = intval( $this->request->post('id') );
		if ( $id ) {
			try {		
				DB::update('entities')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();		
			} catch (Database_Exception $e) {
				$this->ajax_result['ret'] = ERR_DB_UPDATE;
				$this->ajax_result['msg'] = $e->getMessage();
			}
		} else {
			$data['agency_id']   = $this->auth->agency_id;
			$data['created_at']  = NULL;
			try {
				DB::insert('entities', array_keys($data))
					->values($data)
					->execute();				
			} catch (Database_Exception $e) {
				$this->ajax_result['ret'] = ERR_DB_INSERT;
				$this->ajax_result['msg'] = $e->getMessage();
			}
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
		
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
		
			$data = array(
				'status'      => STATUS_DELETED,
				'modified_at' => NULL
			);
			
			DB::update('entities')
				->set($data)
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $id)
				->execute();
				
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
			return;
		}
		
		HTTP::redirect('/entity/list/');
	}
	
}
