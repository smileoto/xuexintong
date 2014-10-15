<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Top extends Controller_Base {
	
	public function action_list()
	{		
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
				
		$expr = DB::expr('COUNT(0)');
		$queryCount = DB::select($expr)
			->from('tops')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '>', STATUS_DELETED);
			
		$queyrList = DB::select('*')
			->from('tops')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '>', STATUS_DELETED);
			
		if ( $entity ) {
			$queryCount->where('entity_id', '=', $school);
			$queyrList->where('entity_id',  '=', $school);
		}
		if ( $school ) {
			$queryCount->where('school_id', '=', $school);
			$queyrList->where('school_id',  '=', $school);
		}
		if ( $grade ) {
			$queryCount->where('grade_id', '=', $grade);
			$queyrList->where('grade_id',  '=', $grade);
		}
		if ( $class ) {
			$queryCount->where('course_id', '=', $class);
			$queyrList->where('course_id',  '=', $class);
		}
			
		$cnt   = $queryCount->execute();
		$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
		
		$items = $queyrList->order_by('tops.id', 'DESC')
			->offset($this->pagenav->offset)
			->limit($this->pagenav->size)
			->execute()
			->as_array();
		
		$tops_students = array();
		foreach ($items as $v) {
			$students = DB::select('students.realname')
				->from('tops_students')
				->join('students')
				->on('tops_students.student_id', '=', 'students.id')
				->where('tops_students.top_id', '=', $v['id'])
				->execute()
				->as_array();
			$arr = array();
			foreach ($students as $student) {
				$arr[] = $student['realname'];
			}
			$tops_students[$v['id']] = implode(',', $arr);
		}
		
		$page = View::factory('top/list')
			->set('items',    $items)
			->set('students', $tops_students)
			->set('entities', $this->entities())
			->set('schools',  $this->schools())
			->set('grades',   $this->grades());
		$page->html_pagenav_content = View::factory('pagenav')
			->set('total', $total)
			->set('page',  $this->pagenav->page)
			->set('size',  $this->pagenav->size);
		$this->output($page, 'top');
	}
	
	public function action_add()
	{
		$upload_dir = $this->get_upload_dir('news');
		Session::instance()->set('upload_dir', $upload_dir);
		
		$page = View::factory('top/add')
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('courses',  $this->courses())
			->set('session_id', Session::instance()->id())
			->set('upload_dir', $upload_dir);

		$this->output($page, 'top');
	}
	
	public function action_edit()
	{
		$upload_dir = $this->get_upload_dir('news');
		Session::instance()->set('upload_dir', $upload_dir);
		
		$id = intval($this->request->query('id'));
	
		$items = DB::select('*')
			->from('tops')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/top/list/');
		}
		
		$tops_students = DB::select('students.id', 'students.realname', 'tops_students.reason', 'tops_students.avatar')
			->from('tops_students')
			->join('students')
			->on('tops_students.student_id', '=', 'students.id')
			->where('tops_students.top_id', '=', $id)
			->execute()
			->as_array();
			
		$page = View::factory('top/edit')
			->set('item', $items[0])
			->set('tops_students', $tops_students)
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('courses',  $this->courses())
			->set('session_id', Session::instance()->id())
			->set('upload_dir', $upload_dir);

		$this->output($page, 'top');
	}
	
	public function action_save()
	{
		$data = array();
		$data['begin_str'] = strval($this->request->post('begin'));
		$data['end_str']   = strval($this->request->post('end'));
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$data['status'] = STATUS_NORMAL;
		
		$student_id = intval($this->request->post('student_id'));
		$avatar = strval($this->request->post('avatar'));
		$reason = $this->request->post('reason');
		
		$new = false;
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				DB::update('tops')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id'] = $this->auth->agency_id;
				list($id, $rows) = DB::insert('tops', array_keys($data))
					->values($data)
					->execute();
				$new = true;
			}
				
			if ( $student_id ) {
				$rows = DB::select('top_id')
					->from('tops_students')
					->where('top_id', '=', $id)
					->where('student_id', '=', $student_id)
					->limit(1)
					->execute();
				if ( $rows->count() == 0 ) {
					$data = array(
						'student_id' => $student_id, 
						'top_id' => $id, 
						'avatar' => $avatar, 
						'reason' => $reason
					);
					DB::insert('tops_students', array_keys($data))
						->values($data)
						->execute();
				}
			}
			
			if ( $new ) {
				HTTP::redirect('/top/edit/?id='.$id);
			} else {
				HTTP::redirect('/top/list/');
			}
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}		
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('tops')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/top/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
		
	public function action_del_student()
	{
		$top_id     = intval($this->request->query('top_id'));
		$student_id = intval($this->request->query('student_id'));
		
		$items = DB::select('id')
			->from('tops')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $top_id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/top/list/');
		}
		
		try {
			DB::delete('tops_students')
				->where('top_id',    '=', $top_id)
				->where('student_id','=',$student_id)
				->execute();
			HTTP::redirect('/top/edit/?id='.$top_id);
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_publish()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('tops')
				->set( array('status'=>STATUS_ENABLED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/top/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_cancel()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('tops')
				->set( array('status'=>STATUS_NORMAL, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/top/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
