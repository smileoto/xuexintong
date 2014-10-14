<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Agency extends Controller_Base {
	
	public function action_index()
	{
		$agencies = DB::select('*')
			->from('agencies')
			->where('id', '=', $this->auth->agency_id)
			->limit(1)
			->execute()
			->as_array();
		
		if ( empty($agencies) ) {
			HTTP::redirect('/session/index');
		}
		
							
		$page = View::factory('agency/index')
			->set('agency', $agencies[0]);

		$this->output($page, 'agencies');
	}
		
	public function action_save()
	{		
		$data = array();
		
		$data['addr']     = $this->request->post('addr');
		$data['mobile']   = $this->request->post('mobile');
		$data['contact']  = $this->request->post('contact');
		$data['email']    = $this->request->post('email');
		$data['province'] = intval($this->request->post('province'));
		$data['city']     = intval($this->request->post('city'));
		$data['area']     = intval($this->request->post('area'));
		$data['city']     = intval($this->request->post('city'));
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		
		try {
			$rows = DB::update('agencies')
				->set($data)
				->where('id', '=', $this->auth->agency_id)
				->execute();
			HTTP::redirect('/agency/index/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
