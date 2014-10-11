<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Grade extends Controller_Base {
	
	public function action_list()
	{
		$items = DB::select('*')
			->from('grades')
			->where('agency_id', '=', $this->auth->agency_id)
			->execute()
			->as_array();
									
		$page = View::factory('grade/list')
			->set('items', $items);

		$this->output($page, 'setting');
	}
	
	public function action_add()
	{
		$page = View::factory('grade/add');
		$this->output($page, 'setting');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('grades')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/grade/list/');
		}
			
		$page = View::factory('grade/edit')
			->set('item', $items[0]);
		$this->output($page, 'setting');
	}
	
	public function action_save()
	{
		$data = array();
		$data['name']    = $this->request->post('name');
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$id = intval( $addr = $this->request->post('id') );
		try {
			if ( $id ) {
				$grades = DB::select('name')
					->from('grades')
					->where('agency_id', '=', $this->auth->agency_id)
					->where('name', '=', $data['name'])
					->where('id', '<>', $id)
					->limit(1)
					->execute();
				
				if ( $grades->count() ) {
					$this->response->body( '年级名字重复' );
					return;
				}
				
				DB::update('grades')
					->set($data)
					->execute();
			} else {
				$grades = DB::select('name')
					->from('grades')
					->where('agency_id', '=', $this->auth->agency_id)
					->where('name', '=', $data['name'])
					->limit(1)
					->execute();
				
				if ( $grades->count() ) {
					$this->response->body( '年级名字重复' );
					return;
				}
				
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('grades', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/grade/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('grades')
				->set( array('status'=>STATUS_DELETED) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/grade/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
