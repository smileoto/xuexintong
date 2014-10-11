<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Feedback extends Controller_Auth {
	
	public function action_from_teachers()
	{
		$page_no   = intval($this->request->query('page_no'));
		$page_size = intval($this->request->query('page_size'));
				
		$page_no   = ($page_no < 1) ? 1 : $page_no;
		$page_size = ($page_size <= 0 ) ? 10 : $page_size;
		$offset    = ($page_no - 1) * $page_size;
		
		try {
			$comments = DB::select('comment.*', array('agency_users.realname', 'teacher'))
				->from('comment')
				->join('agency_users')
				->on('comment.teacher_id', '=', 'agency_users.id')
				->where('comment.agency_id',  '=', $this->agency->get('id'))
				->where('comment.student_id', '=', $this->auth->student_id)
				->offset($offset)
				->limit($page_size)
				->execute()
				->as_array();
				
			$page = View::factory('feedback/from_teachers')
				->set('list', $comments);
				
			$this->output($page);
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_to_agency()
	{
		$page_no   = $this->request->query('page_no');   if (empty($page_no))   $page_no = 1;
		$page_size = $this->request->query('page_size'); if (empty($page_size)) $page_size = 10;
				
		$page_no   = ($page_no < 1) ? 1 : $page_no;
		$page_size = ($page_size < 0 ) ? 1 : $page_size;
		$offset    = ($page_no - 1) * $page_size;
		
		try {
			$comments = DB::select('feedback.*')
				->from('feedback')
				->where('feedback.agency_id',  '=', $this->agency->get('id'))
				->where('feedback.student_id', '=', $this->auth->student_id)
				->offset($offset)
				->limit($page_size)
				->execute()
				->as_array();
				
			$page = View::factory('feedback/to_agency')
				->set('list', $comments);
				
			$this->output($page);
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		if ( !$this->request->is_ajax() ) {
			$page = View::factory('feedback/add');
			$this->output($page);
			return;
		}
		
		$data = array();
		$data['title']     = $this->request->post('title');
		$data['content']   = $this->request->post('content');
		
		$data['agency_id']  = $this->auth->agency_id;
		$data['student_id'] = $this->auth->student_id;
		$data['add_t']      = NULL;
		
		try {
			list($id, $rows) = DB::insert('feedback', array_keys($data))
				->values($data)
				->execute();
			$this->ajax_result['msg'] = $id;
		} catch ( Database_Exception $e ) {
			$this->ajax_result['ret'] = ERR_DB_INSERT;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
	
	public function action_detail()
	{
		$feedback_id = $this->request->query('id');
		
		$topics = DB::select('feedback.*', array('students.realname', 'student'), array('students.id', 'student_id'))
			->from('feedback')
			->where('feedback.agency_id', '=', $this->agency->get('id'))
			->join('students')
			->on('feedback.student_id', '=', 'students.id')
			->where('feedback.id', '=', $feedback_id)
			->execute()
			->as_array();
		if ( !count($topics) ) {
			HTTP::redirect('/feedback/to_agency/');
		}
		
		$reply_list = DB::select('feedback_reply.id','feedback_reply.add_t','feedback_reply.content',array('agency_users.realname', 'teacher'),array('students.realname','student'))
			->from('feedback_reply')
			->join('students')
			->on('feedback_reply.student_id', '=', 'students.id')
			->join('agency_users')
			->on('feedback_reply.teacher_id', '=', 'agency_users.id')
			->where('agency_users.agency_id', '=', $this->agency->get('id'))
			->where('feedback_id', '=', $feedback_id)
			->execute()
			->as_array();
		
		$page = View::factory('feedback/reply')
			->set('topic', $topics[0])
			->set('reply_list', $reply_list);
			
		$this->output($page);
	}
	
}
