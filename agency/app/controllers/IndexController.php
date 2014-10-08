<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('学信通管理平台');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            $this->flash->notice('This is a sample application of the Phalcon Framework.
                Please don\'t provide us any personal information. Thanks');
        }
    }
}
