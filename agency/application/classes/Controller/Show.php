<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Show extends Controller_Base {
	
	public function action_list()
	{
		$items = DB::select('*')
			->from('images')
			->where('agency_id', '=', $this->auth->agency_id)
			->execute()
			->as_array();
		
		$page = View::factory('show/list')
			->set('items', $items);
		$this->output($page, 'agency');
	}
	
	public function action_add()
	{
		$upload_dir = $this->get_upload_dir('show');
		Session::instance()->set('upload_dir', $upload_dir);
		
		$page = View::factory('show/add')
			->set('session_id', Session::instance()->id())
			->set('upload_dir', $upload_dir);

		$this->output($page, 'agency');
	}
	
	public function action_edit() 
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('images')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/show/list/');
		}
		
		$upload_dir = $this->get_upload_dir('show');
		Session::instance()->set('upload_dir', $upload_dir);
		
		$page = View::factory('show/edit')
			->set('item', $items[0])
			->set('session_id', Session::instance()->id())
			->set('upload_dir', $upload_dir);

		$this->output($page, 'agency');
	}
		
	public function action_save()
	{
		$data = array();
		$data['title']   = $this->request->post('title');
		$data['url']     = $this->request->post('url');
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$id = intval( $addr = $this->request->post('id') );
		try {
			if ( $id ) {
				$rows = DB::update('images')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('images', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/show/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::delete('images')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/show/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
