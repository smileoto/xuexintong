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
			->where('status', '=', STATUS_NORMAL);
			
		$queyrList = DB::select('*')
			->from('tops')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL);
			
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
			->set('courses',  $this->courses());

		$this->output($page, 'top');
	}
	
	public function action_edit()
	{
		Session::instance()->set('upload_dir', 'avatar');
		
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
			->set('courses',  $this->courses());

		$this->output($page, 'top');
	}
	
	public function action_save()
	{
		$data = array();
		$data['title']     = $this->request->post('title');
		$data['begin_str'] = strval($this->request->post('begin'));
		$data['end_str']   = strval($this->request->post('end'));
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$cnt = 0;
		$tops_students = array();
		foreach ( $_POST['id'] as $id ) {
			if ( !isset($tops_students[$cnt]) ) {
				$tops_students[$cnt] = array(
					'student_id' => 0, 
					'avatar' => '', 
					'reason' => ''
				);
			}
			$tops_students[$cnt]['student_id'] = $id;
			$cnt++;
		}
		
		$cnt = 0;
		foreach ( $_POST['reason'] as $reason ) {
			$tops_students[$cnt]['reason'] = $reason;
			$cnt++;
		}
		
		$cnt = 0;
		foreach ( $_POST['avatar'] as $avatar ) {
			$tops_students[$cnt]['avatar'] = $avatar;
			$cnt++;
		}
		
		$id = intval($this->request->post('top_id'));
		try {
			DB::delete('tops_students')
				->where('top_id', '=', $id)
				->execute();
				
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
			}
				
			if ( $tops_students ) {
				$d = array('top_id' => $id, 'student_id' => 0, 'avatar' => '', 'reason' => '');
				$insert = DB::insert('tops_students', array_keys($d));
				foreach ($tops_students as $v) {
					$d['student_id'] = $v['student_id'];
					$d['avatar']     = $v['avatar'];
					$d['reason']     = $v['reason'];
					$insert->values($d);
				}
				$insert->execute();
			}
			
			HTTP::redirect('/top/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}		
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('tops')
				->set( array('status'=>STATUS_DELETED, 'modify_t'=>NULL) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/top/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	protected function save_avatar(&$file, &$msg)
	{
		if ( empty($_FILES) ) {
			$msg = '没上传文件';
			return false;
		}

		Upload::$default_directory = APPPATH.'../htdocs/upload/avatar_'.date('Ymd').'/'; //默认保存文件夹
		Upload::$remove_spaces     = true;  //上传文件删除空格
		
		@mkdir(Upload::$default_directory, 0777);
		
		if( !Upload::valid( $file ) ) {
			$msg = '非法图片';
			return false;
		}
		
		if( Upload::not_empty($file) ) {
			if ( Upload::size($file, "1M") ) {
				if ( Upload::type($file, array('jpg', 'png', 'gif')) ) {
					$filepath = Upload::save($file, NULL, NULL, 777);
					if( $filepath ) {
						return $this->save_to_bcs($filepath);
					} else {
						$msg = '保存失败';
						return false;
					}
				} else {
					$msg = '图片类型不支持';
					return false;
				}
			} else {
				$msg = '图片大于1M';
				return false;
			}
		} else {
			$msg = '无效文件';
			return false;
		}
	}

}
