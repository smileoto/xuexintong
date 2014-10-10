<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Grade extends Controller_Base {
	
	public function action_list()
	{
		try {
			$expr = DB::expr('COUNT(0)');
			$cnt = DB::select($expr)
				->from('grades')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('status', '=', STATUS_NORMAL)
				->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
				
			$items = DB::select('*')
				->from('grades')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('status', '=', STATUS_NORMAL)
				->offset($this->pagenav->offset)
				->limit($$this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('grade/list')
				->set('items', $items);
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);				
			$this->output($page, 'setting');			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}		
	}
	
	public function action_add()
	{
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
		
		$data['modified_at'] = NULL;
		$data['modified_by'] = $this->auth->user_id;
		
		$id = intval( $addr = $this->request->post('id') );
		try {
			if ( $id ) {
				$grades = DB::select('name')
					->from('grades')
					->where('agency_id', '=', $this->auth->agency_id)
					->where('name', '=', $name)
					->where('id', '<>', $id)
					->limit(1)
					->execute();
				
				if ( $grades->count() ) {
					$this->ajax_result['ret'] = ERR_DB_UPDATE;
					$this->ajax_result['msg'] = '年级名字重复';
					$this->response->body( json_encode($this->ajax_result) );
					return;
				}
				
				DB::update('grades')
					->set($data)
					->execute();
			} else {
				$grades = DB::select('name')
					->from('grades')
					->where('agency_id', '=', $this->auth->agency_id)
					->where('name', '=', $name)
					->limit(1)
					->execute();
				
				if ( $grades->count() ) {
					$this->ajax_result['ret'] = ERR_DB_INSERT;
					$this->ajax_result['msg'] = '年级名字重复';
					$this->response->body( json_encode($this->ajax_result) );
					return;
				}
				
				$data['created_at'] = NULL;
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
