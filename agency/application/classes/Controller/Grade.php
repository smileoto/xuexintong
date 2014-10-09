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
		$name = $this->request->post('name');
		
		$id = intval( $addr = $this->request->post('id') );
		
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
			
			try {
				$rows = DB::update('agency_Grades')
					->set(array('name'=>$name))
					->execute();
				$this->ajax_result['msg'] = $rows;
			} catch (Database_Exception $e) {
				$this->ajax_result['ret'] = ERR_DB_UPDATE;
				$this->ajax_result['msg'] = $e->getMessage();
			}
		} else {
			$grades = DB::select('name')
				->from('agency_Grades')
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
			
			try {
				DB::insert('Grades', array('agency_id', 'name'))
					->values(array('agency_id'=>$this->auth->agency_id, 'name'=>$name))
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
