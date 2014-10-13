<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Feedback extends Controller_Base {
	
	public function action_list()
	{
		$items = DB::select('id', 'title', 'created_at')
			->from('comments')
			->where('agency_id',  '=', $this->agency->get('id'))
			->where('student_id', '=', $this->auth->student_id)
			->offset($this->pagenav->offset)
			->limit($this->pagenav->size)
			->execute()
			->as_array();
			
		$page = View::factory('comment/list')
			->set('items', $items);
			
		$this->output($page);
	}
	
	public function action_detail()
	{
		$id = $this->request->query('id');
		
		$items = DB::select('comments.*', 'users.realname')
			->from('comments')
			->join('users')
			->on('comments.created_by', '=', 'users.id')
			->where('comments.agency_id', '=', $this->agency->get('id'))
			->where('comments.id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( count($items) == 0 ) {
			HTTP::redirect('/comment/list/');
		}
		
		$page = View::factory('comment/reply')
			->set('items', $items[0]);
			
		$this->output($page);
	}
	
}
