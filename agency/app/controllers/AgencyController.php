<?php

class AgencyController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('学信通管理平台');
        parent::initialize();
    }

    public function indexAction()
    {
		$agency = Agencies::findFirst('id='.$this->persistent->auth['agency_id'].' AND status=0');
		if ( !$agency ) {
			$this->flash->error('机构不存在或已停用');
			return $this->forward('session/index');
		}
		
		echo '<pre>';print_r($agency->viewname);echo '</pre>';exit;
    }
	
	public function saveAction()
	{
		$agency = Agencies::findFirst('id='.$this->persistent->auth['agency_id'].' AND status=0');
		if ( !$agency ) {
			$this->flash->error('机构不存在或已停用');
			return $this->forward('session/index');
		}
		
		$agency->province = $this->request->getPost('province', 'int');
		$agency->city = $this->request->getPost('city', 'int');
		$agency->area = $this->request->getPost('area', 'int');
		$agency->addr = $this->request->getPost('area', array('string', 'striptags'));
		$agency->contact = $this->request->getPost('contact', array('string', 'striptags'));
		$agency->mobile  = $this->request->getPost('mobile',  array('string', 'striptags'));
		$agency->email   = $this->request->getPost('email',   'email');
		
		if ($agency->save() == false) {
			foreach ($agency->getMessages() as $message) {
				$this->flash->error((string) $message);
			}
		} else {
			$this->flash->success('机构信息修改成功');
		}
		
		return $this->forward('session/index');
	}
}
