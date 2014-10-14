<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dailynews extends Controller_Base 
{	
	public function action_index()
	{
		try {
			$items = DB::select('daily_news.id','daily_news.title','daily_news.remark','daily_news.modified_at','users.username')
				->from('daily_news')
				->join('users')
				->on('daily_news.created_by', '=', 'users.id')
				->where('daily_news.agency_id', '=', $this->auth->agency_id)
				->where('daily_news.status', '=', STATUS_ENABLED)
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->order_by('id', 'DESC')
				->execute()
				->as_array();
			
			if ( $this->request->is_ajax() ) {
				echo json_encode($items);exit;
			} else {
				$page = View::factory('dailynews/list')
					->set('items', $items)
					->set('page',  $this->pagenav->page);
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
			->from('daily_news')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/dailynews/');
		}
		
		DB::update('daily_news')
			->set( array( 'read_count' => $items[0]['read_count']+1 ) )
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->execute();
		
		$page = View::factory('dailynews/detail')
			->set('item', $items[0]);
			
		$this->output($page);
	}
	
} // End Dailynews
