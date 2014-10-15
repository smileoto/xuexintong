<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Feedback extends Controller_Base {
	
	public function action_index()
	{
		$items = DB::select('id', 'title', 'created_at', 'reply')
			->from('feedbacks')
			->where('agency_id',  '=', $this->agency->get('id'))
			->where('created_by', '=', $this->auth->student_id)
			->order_by('id', 'DESC')
			->offset($this->pagenav->offset)
			->limit($this->pagenav->size)
			->execute()
			->as_array();
			
		$page = View::factory('feedback/list')
			->set('items', $items);
			
		$this->output($page);
	}
	
	public function action_add()
	{
		$page = View::factory('feedback/add');
		$this->output($page);
	}
	
	public function action_save()
	{
		$data = array();
		
		$data['title']      = $this->request->post('title');
		$data['content']    = $this->request->post('content');
		
		$data['agency_id']  = $this->auth->agency_id;
		$data['created_by'] = $this->auth->student_id;
		$data['created_at'] = date('Y-m-d H:i:s');
		
		try {
			DB::insert('feedbacks', array_keys($data))
				->values($data)
				->execute();	
			HTTP::redirect('/feedback');
		} catch ( Database_Exception $e ) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_detail()
	{
		$id = $this->request->query('id');
		
		$items = DB::select('feedbacks.*', 'students.realname')
			->from('feedbacks')
			->join('students')
			->on('feedbacks.created_by', '=', 'students.id')
			->where('feedbacks.agency_id', '=', $this->agency->get('id'))
			->where('feedbacks.id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( count($items) == 0 ) {
			HTTP::redirect('/feedback');
		}
		
		$reply_list = DB::select('feedback_reply.id','feedback_reply.created_at','feedback_reply.content',array('users.realname', 'teacher'),array('students.realname','student'))
			->from('feedback_reply')
			->join('users', 'LEFT')
			->on('feedback_reply.created_by', '=', 'users.id')
			->join('students', 'LEFT')
			->on('feedback_reply.student_id', '=', 'students.id')
			->where('feedback_id', '=', $id)
			->execute()
			->as_array();
		
		$page = View::factory('feedback/reply')
			->set('item', $items[0])
			->set('reply_list', $reply_list);
			
		$this->output($page);
	}
	
}
