<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Class extends Controller_Base {

	public function action_list()
	{
		$entity_id = intval($this->request->query('entity_id'));
				
		try {			
			$list = DB::select('id','name')
				->from('classes')
				->where('agency_id', '=', $agency_id);
			if ( $entity_id ) {
				$list->where('entity_id', '=', $entity_id);
			}
			$items = $list->execute();
			
			$page = View::factory('classes/list')
				->set('items',  $items)
				->set('entities', $this->entities());
				
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
