<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dailynews extends Controller_Base {
	
	public function action_list()
	{		
		$title   = strval($this->request->query('title'));
		
		try {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('daily_news')
				->join('users')
				->on('daily_news.created_by', '=', 'users.id')
				->where('daily_news.agency_id', '=', $this->auth->agency_id)
				->where('daily_news.status', '=', STATUS_NORMAL);
			
			$queryList = DB::select('daily_news.id','daily_news.title','daily_news.created_at','daily_news.modified_at','users.username')
				->from('daily_news')
				->join('users')
				->on('daily_news.created_by', '=', 'users.id')
				->where('daily_news.agency_id', '=', $this->auth->agency_id)
				->where('daily_news.status', '=', STATUS_NORMAL);
				
			if ( $title ) {
				$queryCount->where('daily_news.title', 'like', '%'.$title.'%');
				$queryList->where('daily_news.title', 'like',  '%'.$title.'%');
			}
				
			$cnt = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = $queryList->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute();
			
			$page = View::factory('dailynews/list')
				->set('items', $items);
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);
			$this->output($page, 'dailynews');
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$page = View::factory('dailynews/add');
		$this->output($page, 'dailynews');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('daily_news')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/dailynews/list/');
		}
		
		$page = View::factory('dailynews/edit')
			->set('item', $items[0]);
			
		$this->output($page, 'dailynews');
	}
	
	public function action_save()
	{
		$data = array();
		
		$data['title']       = $this->request->post('title');
		$data['content']     = $this->request->post('content');
		$data['src']         = strval($this->request->post('from'));
		$data['img']         = strval($this->request->post('img'));
		$data['modified_by'] = $this->auth->user_id;
		$data['modified_at'] = date('Y-m-d H:i:s');
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				// edit 
				DB::update('daily_news')
					->set( $data )
					->where('id', '=', $id)
					->where('agency_id', '=', $this->auth->agency_id)
					->execute();
			} else {
				// add 
				$data['agency_id']   = $this->auth->agency_id;
				$data['created_by']  = $this->auth->user_id;
				$data['created_at']  = date('Y-m-d H:i:s');
				DB::insert('daily_news', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/dailynews/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('daily_news')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/dailynews/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}

} // End Article
