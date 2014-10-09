<?php defined('SYSPATH') or die('No direct script access.');

class Controller_School extends Controller_Base {
	
	public function action_list()
	{
		try {
			$expr = DB::expr('COUNT(0)');
			$cnt = DB::select($expr)
				->from('schools')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('status', '=', STATUS_NORMAL)
				->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
				
			$items = DB::select('*')
				->from('schools')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('status', '=', STATUS_NORMAL)
				->offset($this->pagenav->offset)
				->limit($$this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('school/list')
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
		$name = $this->request->post('name');
		$addr = $this->request->post('addr');
		
		$id = intval( $addr = $this->request->post('id') );
		
		if ( $id ) {
			$schools = DB::select('name')
				->from('schools')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('name', '=', $name)
				->where('id', '<>', $id)
				->limit(1)
				->execute();
			
			if ( $schools->count() ) {
				$this->ajax_result['ret'] = ERR_DB_UPDATE;
				$this->ajax_result['msg'] = '学校名字重复';
				$this->response->body( json_encode($this->ajax_result) );
				return;
			}
			
			try {
				$rows = DB::update('agency_schools')
					->set(array('name'=>$name, 'addr'=>$addr))
					->execute();
				$this->ajax_result['msg'] = $rows;
			} catch (Database_Exception $e) {
				$this->ajax_result['ret'] = ERR_DB_UPDATE;
				$this->ajax_result['msg'] = $e->getMessage();
			}
		} else {
			$schools = DB::select('name')
				->from('agency_schools')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('name', '=', $name)
				->limit(1)
				->execute();
			
			if ( $schools->count() ) {
				$this->ajax_result['ret'] = ERR_DB_INSERT;
				$this->ajax_result['msg'] = '学校名字重复';
				$this->response->body( json_encode($this->ajax_result) );
				return;
			}
			
			try {
				DB::insert('schools', array('agency_id', 'name', 'addr'))
					->values(array('agency_id'=>$this->auth->agency_id, 'name'=>$name, 'addr'=>$addr))
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
