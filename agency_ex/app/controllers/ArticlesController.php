<?php

class ArticlesController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('学信通管理平台');
        parent::initialize();
    }
	
	public function indexAction()
	{
	}

	public function listAction()
	{		
		$page = 1;
		$size = 10;
		$page = $this->request->getQuery('page', 'int');
		if ($page <= 0) {
			$page = 1;
		}
		
		$title = $this->request->getQuery('title', 'striptags', '');
			
        $parameters   = array();
		$parameters[] = 'status=0';
		if ( $title ) {
			$parameters[] = "title like '%$title%'";
		}
		
		$rowcount = Articles::count($parameters);
		$list = array();
		
		if ( $rowcount ) {
			$parameters['offset'] = ($page - 1) * $size;
			$parameters['limit']  = $size;
			$list = Articles::find($parameters);
		}
		
        $this->pagenav($list, $rowcount, $page, $size);
	}
	
	public function saveAction()
	{
		$model = new Articles;
		
		$model->id      = $this->request->getPost('id', 'int');
		$model->title   = $this->request->getPost('title',  'striptags');
		$model->src     = $this->request->getPost('from',   'striptags', ' ');
		$model->remark  = $this->request->getPost('remark', 'striptags', ' ');
		$model->img     = $this->request->getPost('img',    'striptags', ' ');
		$model->content = $this->request->getPost('content', 'striptags', ' ');
		
		$model->agency_id   = $this->persistent->auth['agency_id'];
		
		if ( $model->id ) {
			$model->modified_by = $this->persistent->auth['user_id'];
		} else {
			$model->created_by  = $this->persistent->auth['user_id'];
			$model->modified_by = $this->persistent->auth['user_id'];
		}
		
		if ($model->save() == false) {
			foreach ($model->getMessages() as $message) {
				$this->flash->error((string) $message);
			}
			return $this->forward('articles/add/');
		} else {
			$this->flash->success('保存成功');
		}
				
		return $this->forward('articles/list/');
	}

    public function addAction()
    {
		$this->view->setVar('page', 1);
    }

    public function editAction($id)
    {
		$id = intval($id);
		
		$where = array(
			'agency_id='.$this->persistent->auth['agency_id'],
			'id='.$id
		);
		
        $model = Articles::findFirst($where);
		if (!$model) {
			$this->flash->error('article was not found');
			return $this->forward('articles/list/');
		}
		
		$this->view->setVar('model', $model);
    }

    public function delAction($id)
    {
		$id = intval($id);
		
		$where = array(
			'agency_id='.$this->persistent->auth['agency_id'],
			'id='.$id
		);
		
        $model = Articles::findFirst($where);
		if (!$model) {
			$this->flash->error('article was not found');
			return $this->forward('articles/list/');
		}
		
		$model->status = -1;
		return $this->forward('articles/list/');
    }
}
