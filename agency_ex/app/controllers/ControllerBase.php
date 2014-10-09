<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    protected function initialize()
    {
        //$this->tag->prependTitle('INVO | ');
        //$this->view->setTemplateAfter('main');
		$auth = $this->session->get('auth');
		if ( $auth ) {
			$this->persistent->auth = $auth;
		} else {
			$this->persistent->auth = array(
				'user_id'   => 0,
				'agency_id' => 0,
				'agency_name' => '',
				'username'    => ''
			);
		}
		
		$this->view->setVar('agency_name', $this->persistent->auth['agency_name']);
		$this->view->setVar('login_name',  $this->persistent->auth['username']);
    }

    protected function forward($uri)
    {
        return $this->response->redirect($uri);
    }
	
	protected function pagenav($items, $total, $page, $size)
	{
		$this->view->setVar('items', $items);
		$this->view->setVar('total_items', $total);
		$this->view->setVar('page',  $page);
		$count = ($total % $size) ? ( intval($total / $size) + 1 ) : intval($total / $size);
		$this->view->setVar('total_pages', $count);
		
		//$nextUrl = $this->
	}
}
