<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Entity extends Controller_Base {
	
	public function action_list()
	{
		$items = DB::select('*')
			->from('entities')
			->where('agency_id', '=', $this->auth->agency_id)
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
		
		$data['name']      = $this->request->post('name');
		$data['addr']      = $this->request->post('addr');
		$data['mobile']    = $this->request->post('mobile');
		$data['contact']   = $this->request->post('contact');
		$data['remark']    = strval($this->request->post('remark'));
		$data['email']     = strval($this->request->post('mail'));
		$data['province']  = intval($this->request->post('province'));
		$data['city']      = intval($this->request->post('city'));
		$data['area']      = intval($this->request->post('area'));
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$id = intval( $this->request->post('id') );
		try {
			if ( $id ) {					
				DB::update('entities')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();		
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('entities', array_keys($data))
					->values($data)
					->execute();
			}
			HTTP::redirect('/entity/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
		
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
		
			$data = array(
				'status'      => STATUS_DELETED,
				'modified_at' => date('Y-m-d H:i:s')
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
