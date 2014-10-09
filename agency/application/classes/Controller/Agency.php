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
			HTTP::redirect('/login/index');
		}
		
							
		$page = View::factory('agency/index')
			->set('agency', $agencies[0]);

		$this->output($page, 'agencies');
	}
		
	public function action_edit()
	{		
		$data = array();
		
		$data['addr']     = $this->request->post('addr');
		$data['mobile']   = $this->request->post('mobile');
		$data['contacts'] = $this->request->post('contacts');
		$data['mail']     = $this->request->post('mail');
		$data['province'] = intval($this->request->post('province'));
		$data['city']     = intval($this->request->post('city'));
		$data['area']     = intval($this->request->post('area'));
		$data['city']     = intval($this->request->post('city'));
		
		$data['modify_t'] = NULL;
		
		try {
			$rows = DB::update('agencies')
				->set($data)
				->where('id', '=', $this->auth->agency_id)
				->execute();
		} catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_UPDATE;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
	
}
