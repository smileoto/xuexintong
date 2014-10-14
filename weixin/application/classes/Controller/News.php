<?php defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Base 
{	
	public function action_index()
	{
		try {			
			$images = DB::select('id','img','title')
				->from('news')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('status',    '=', STATUS_ENABLED)
				->where('show_type', '=', STATUS_ENABLED)
				->offset(0)
				->limit(4)
				->order_by('id', 'DESC')
				->execute()
				->as_array();
				
			$items = DB::select('news.id','news.title','news.remark','news.img','news.read_count','news.modified_at','users.realname')
				->from('news')
				->join('users')
				->on('news.created_by', '=', 'users.id')
				->where('news.agency_id', '=', $this->auth->agency_id)
				->where('news.status',    '=', STATUS_ENABLED)
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->order_by('news.id', 'DESC')
				->execute()
				->as_array();
			
			if ( $this->request->is_ajax() ) {
				echo json_encode($items);exit;
			} else {
				$page = View::factory('news/list')
					->set('items',  $items)
					->set('page',   $this->pagenav->page)
					->set('size',   $this->pagenav->size)
					->set('images', $images);
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
			->from('news')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/news/');
		}
		
		DB::update('news')
			->set( array( 'read_count' => $items[0]['read_count']+1 ) )
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->execute();
		
		$page = View::factory('news/detail')
			->set('item', $items[0]);
			
		$this->output($page);
	}
	
} // End News
