<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment extends Controller_Base {
	
	public function action_index()
	{
		$items = DB::select('*')
			->from('comments')
			->join('users')
			->on('comments.created_by', '=', 'users.id')
			->where('comments.agency_id',  '=', $this->agency->get('id'))
			->where('comments.student_id', '=', $this->auth->student_id)
			->order_by('comments.id', 'DESC')
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
