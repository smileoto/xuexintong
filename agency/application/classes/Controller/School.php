<?php defined('SYSPATH') or die('No direct script access.');

class Controller_School extends Controller_Base {
	
	public function action_list()
	{
		$items = DB::select('*')
			->from('schools')
			->where('agency_id', '=', $this->auth->agency_id)
			->execute()
			->as_array();
									
		$page = View::factory('school/list')
			->set('items', $items);

		$this->output($page, 'setting');
	}
	
	public function action_add()
	{
		$page = View::factory('school/add');
		$this->output($page, 'setting');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('schools')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/school/list/');
		}
			
		$page = View::factory('school/edit')
			->set('item', $items[0]);
		$this->output($page, 'setting');
	}
	
	public function action_save()
	{
		$data = array();
		$data['name']    = $this->request->post('name');
		$data['addr']    = $this->request->post('addr');
		$data['mobile']  = $this->request->post('mobile');
		$data['contact'] = $this->request->post('contact');
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$id = intval( $addr = $this->request->post('id') );
		try {
			if ( $id ) {
				$schools = DB::select('name')
					->from('schools')
					->where('agency_id', '=', $this->auth->agency_id)
					->where('name', '=', $data['name'])
					->where('id', '<>', $id)
					->limit(1)
					->execute();
				
				if ( $schools->count() ) {
					$this->response->body( '学校名字重复' );
					return;
				}
				
				$rows = DB::update('schools')
					->set($data)
					->execute();
			} else {
				$schools = DB::select('name')
					->from('schools')
					->where('agency_id', '=', $this->auth->agency_id)
					->where('name', '=', $data['name'])
					->limit(1)
					->execute();
				
				if ( $schools->count() ) {
					$this->response->body( '学校名字重复' );
					return;
				}
				
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('schools', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/school/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('schools')
				->set( array('status'=>STATUS_DELETED) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/school/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
