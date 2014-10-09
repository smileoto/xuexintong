<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Classes extends Controller_Base {
	
	public function action_list()
	{
		try {			
			$classes = $this->classes();
			$groups_classes = array();
			foreach ( $classes as $v ) {
				if ( !isset($groups_classes) ) {
					$groups_classes[$v['entity_id']] = array();
				}
				$groups_classes[$v['entity_id']][] = $v;
			}
			
			$page = View::factory('class/list')
				->set('groups_classes', $groups_classes)
				->set('entities', $this->entities());
				
			$this->output($page, 'classes');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_add()
	{
		$page = View::factory('class/add')
			->set('entities', $this->entities())
			->set('agency_id', $agency_id);
		$this->output($page, 'classes');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('classes')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/class/list/');
		}
			
		$page = View::factory('class/edit')
			->set('entities', $this->entities())
			->set('item', $items[0]);
		$this->output($page, 'classes');
	}
	
	public function action_save()
	{
		$name = $this->request->post('name');
		if (empty($name)) {
			$this->ajax_result['ret'] = ERR_NOT_PARAMS;
			$this->ajax_result['msg'] = 'need name param';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		$data = array();
		$data['name']      = $name;
		$data['remark']    = Arr::get($_POST, 'remark', '');
		$data['detail']    = Arr::get($_POST, 'detail', '');
		$data['entity_id'] = intval(Arr::get($_POST, 'entity_id', 0));
		
		$data['modified_at'] = NULL;
		
		$id = intval(Arr::get($_POST, 'id', 0));
		
		if ( $id ) {
			try {
				DB::update('classes')
					->set($data)
					->where('id', '=', $id)
					->execute();
				DB::update('class_detail')
					->set(array('content' => Arr::get($_POST, 'content', '')))
					->where('class_id', '=', $id)
					->execute();
			} catch (Database_Exception $e) {
				$this->ajax_result['ret'] = ERR_DB_UPDATE;
				$this->ajax_result['msg'] = $e->getMessage();
			}
		} else {
			$data['agency_id']   = $this->auth->agency_id;
			$data['created_at']  = NULL;
			try {
				DB::insert('classes', array_keys($data))
					->values($data)
					->execute();
			} catch (Database_Exception $e) {
				$this->ajax_result['ret'] = ERR_DB_UPDATE;
				$this->ajax_result['msg'] = $e->getMessage();
			}
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('classes')
				->set( array('status'=>STATUS_DELETED) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/class/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
