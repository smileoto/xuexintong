<?php defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Base 
{	
	public function action_list()
	{
		try {
			$items = DB::select('news.id','news.title','news.created_at','news.modified_at','users.username')
				->from('news')
				->join('users')
				->on('news.created_by', '=', 'users.id')
				->where('news.agency_id', '=', $this->agency->get('agency_id'))
				->where('news.status', '=', STATUS_NORMAL)
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->order_by('id', 'DESC')
				->execute()
				->as_array();
			
			$page = View::factory('news/list')
				->set('items', $items)
				->set('page',  $this->pagenav->page)
				->set('images', $this->images);
			$this->output($page);
			
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
			->where('agency_id', '=', $this->agency->get('agency_id'))
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/news/list/');
		}
		
		$page = View::factory('news/detail')
			->set('item', $items[0]);
			
		$this->output($page);
	}
	
} // End News
