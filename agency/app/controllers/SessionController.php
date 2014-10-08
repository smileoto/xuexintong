<?php

class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('管理员登录');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            $this->tag->setDefault('username', 'admin');
            $this->tag->setDefault('password', '');
        }
    }

    /**
     * Register authenticated user into session data
     *
     * @param Users $user
     */
    private function _registerSession($user)
    {
        $this->session->set('auth', array(
            'user_id'   => $user->id,
            'agency_id' => $user->agency_id,
            'username'  => $user->username,
            'realname'  => $user->realname
        ));
    }

    /**
     * This actions receive the input from the login form
     *
     */
    public function startAction()
    {
        if ($this->request->isPost()) {
			$aid    = $this->request->getPost('agency');
			$agency = Agencies::findFirst("username='$aid' AND status=0");
			if ( !$agency ) {
				$this->flash->error('机构不存在或已停用');
				return $this->forward('session/index');
			}
		
            $username = $this->request->getPost('username');

            $password = $this->request->getPost('password');
            $password = sha1($password);

            $user = Users::findFirst("username='$username' AND password='$password' AND status=0");
            if ($user != false) {
                $this->_registerSession($user);
                $this->flash->success('Welcome ' . $user->username);
                return $this->forward('agency/index');
            }

            $this->flash->error('帐号或密码错误');
        }

        return $this->forward('session/index');
    }

    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction()
    {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        return $this->forward('index/index');
    }
}
