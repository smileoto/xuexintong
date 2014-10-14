<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Article extends Controller_Base 
{	
	public function action_index()
	{
		try {
			$items = DB::select('articles.id','articles.title','articles.remark','articles.modified_at','users.username')
				->from('articles')
				->join('users')
				->on('articles.created_by', '=', 'users.id')
				->where('articles.agency_id', '=', $this->auth->agency_id)
				->where('articles.status', '=', STATUS_ENABLED)
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->order_by('articles.id', 'DESC')
				->execute()
				->as_array();
			
			if ( $this->request->is_ajax() ) {
				echo json_encode($items);exit;
			} else {
				$page = View::factory('article/list')
					->set('items', $items)
					->set('page',  $this->pagenav->page)
					->set('size',  $this->pagenav->size);
				$this->output($page);
			}
			
		} catch (Database_Exception $e) {
			if ( $this->request->is_ajax() ) {
				echo json_encode(array());exit;
			} else {
				$this->response->body($e->getMessage());
			}
		}
	}
	
	public function action_detail()
	{
		$id = intval($this->request->query('id'));
			
		$items = DB::select('*')
			->from('articles')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( count($items) == 0 ) {
			HTTP::redirect('/article/');
		}
		
		DB::update('articles')
			->set( array( 'read_count' => $items[0]['read_count']+1 ) )
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->execute();
		
		$page = View::factory('article/detail')
			->set('item', $items[0]);
			
		$this->output($page);
	}
	
} // End Article
