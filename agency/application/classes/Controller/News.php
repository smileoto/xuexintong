<?php defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Base {
	
	public function action_list()
	{		
		$title   = strval($this->request->query('title'));
		
		try {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('news')
				->join('users')
				->on('news.created_by', '=', 'users.id')
				->where('news.agency_id', '=', $this->auth->agency_id)
				->where('news.status', '=', STATUS_NORMAL);
			
			$queryList = DB::select('news.id','news.title','news.created_at','news.modified_at','users.username')
				->from('news')
				->join('users')
				->on('news.created_by', '=', 'agency_users.id')
				->where('news.agency_id', '=', $this->auth->agency_id)
				->where('news.status', '=', STATUS_NORMAL);
				
			if ( $title ) {
				$queryCount->where('news.title', 'like', '%'.$title.'%');
				$queryList->where('news.title', 'like',  '%'.$title.'%');
			}
				
			$cnt = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$news = $queryList->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute();
			
			$page = View::factory('article/list')
				->set('news', $news);
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);
			$this->output($page, 'news');
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		Session::instance()->set('upload_dir', 'news');
		$page = View::factory('news/add');
		$this->output($page, 'news');
	}
	
	public function action_edit()
	{
		Session::instance()->set('upload_dir', 'news');
		
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('news')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/article/list/');
		}
		
		$page = View::factory('article/edit')
			->set('item', $items[0]);
			
		$this->output($page, 'news');
	}
	
	public function action_save()
	{
		$data = array();
		
		$data['title']       = $this->request->post('title');
		$data['content']     = $this->request->post('content');
		$data['src']         = strval($this->request->post('from'));
		$data['img']         = strval($this->request->post('img'));
		$data['modified_by'] = $this->auth->user_id;
		$data['modified_at'] = NULL;
		
		$id = intval($this->request->post('id'));
		if ( $id ) {
			// edit 
			try {
				DB::update('news')
					->set( $data )
					->where('id', '=', $id)
					->where('agency_id', '=', $this->auth->agency_id)
					->execute();
			} catch (Database_Exception $e) {
				$this->ajax_result['ret'] = ERR_DB_UPDATE;
				$this->ajax_result['msg'] = $e->getMessage();
			}
		} else {
			// add 
			$data['agency_id']   = $this->auth->agency_id;
			$data['created_by']  = $this->auth->user_id;
			$data['created_at']  = NULL;
			try {
				DB::insert('news', array_keys($data))
					->values($data)
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
			DB::update('news')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>NULL) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/article/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}

} // End News
