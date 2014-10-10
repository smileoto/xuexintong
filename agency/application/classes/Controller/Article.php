<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Article extends Controller_Base {
	
	public function action_list()
	{		
		$title   = strval($this->request->query('title'));
		
		try {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('articles')
				->join('users')
				->on('articles.created_by', '=', 'users.id')
				->where('articles.agency_id', '=', $this->auth->agency_id)
				->where('articles.status', '=', STATUS_NORMAL);
			
			$queryList = DB::select('articles.id','articles.title','articles.created_at','articles.modified_at','users.username')
				->from('articles')
				->join('users')
				->on('articles.created_by', '=', 'users.id')
				->where('articles.agency_id', '=', $this->auth->agency_id)
				->where('articles.status', '=', STATUS_NORMAL);
				
			if ( $title ) {
				$queryCount->where('articles.title', 'like', '%'.$title.'%');
				$queryList->where('articles.title', 'like',  '%'.$title.'%');
			}
				
			$cnt = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = $queryList->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute();
			
			$page = View::factory('article/list')
				->set('items', $items);
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);
			$this->output($page, 'knowledge');
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$page = View::factory('articles/add');
		$this->output($page, 'knowledge');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
			
		$items = DB::select('*')
			->from('articles')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/article/list/');
		}
		
		$page = View::factory('article/edit')
			->set('item', $items[0]);
			
		$this->output($page, 'knowledge');
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
				DB::update('articles')
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
				DB::insert('articles', array_keys($data))
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
			DB::update('articles')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>NULL) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/article/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}

} // End Article
