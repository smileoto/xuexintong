<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	protected $auth = array(
		'user_id'   => 0,
		'agency_id' => 0
	);
	
    protected function initialize()
    {
        //$this->tag->prependTitle('INVO | ');
        //$this->view->setTemplateAfter('main');
		$auth = $this->session->get('auth');
		if ( $auth ) {
			$this->auth = $auth;
		}
    }

    protected function forward($uri)
    {
        return $this->response->redirect($uri);
    }
}
