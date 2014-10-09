<?php

class DailyNewsController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('学信通管理平台');
        parent::initialize();
    }

	public function listAction()
	{
		$numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Products', $_POST);
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery('page', 'int');
            if ($numberPage <= 0) {
                $numberPage = 1;
            }
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }
		
		$parameters[] = 'status=0';

        $list = DailyNews::find($parameters);
        if (count($list) == 0) {
            $this->flash->notice('empty');
            //return $this->forward('products/index');
        }

        $paginator = new Phalcon\Paginator\Adapter\Model(array(
            'data' => $list,
            'limit' => 10,
            'page' => $numberPage
        ));
        $page = $paginator->getPaginate();

        $this->view->setVar('page', $page);
	}
	
	public function saveAction()
	{
		$model = new DailyNews;
		
		$model->id     = $this->request->getPost('id', 'int');
		$model->title  = $this->request->getPost('title',  'striptags');
		$model->src    = $this->request->getPost('from',   'striptags', ' ');
		$model->remark = $this->request->getPost('remark', 'striptags', ' ');
		$model->img    = $this->request->getPost('img',    'striptags', ' ');
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
			return $this->forward('DailyNews/add/');
		} else {
			$this->flash->success('保存成功');
		}
				
		return $this->forward('DailyNews/list/');
	}

    public function addAction()
    {
    }

    public function editAction($id)
    {
		$id = intval($id);
		
		$where = array(
			'agency_id='.$this->persistent->auth['agency_id'],
			'id='.$id
		);
		
        $model = DailyNews::findFirst($where);
		if (!$model) {
			$this->flash->error('article was not found');
			return $this->forward('DailyNews/list/');
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
		
        $model = DailyNews::findFirst($where);
		if (!$model) {
			$this->flash->error('article was not found');
			return $this->forward('DailyNews/list/');
		}
		
		$model->status = -1;
		return $this->forward('DailyNews/list/');
    }
}
