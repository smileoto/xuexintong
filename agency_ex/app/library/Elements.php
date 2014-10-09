<?php

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Phalcon\Mvc\User\Component
{

    private $_leftMenu = array(
        '自媒体' => array(
            'agency' => array(
                'caption' => '机构介绍',
                'action' => 'Introduction'
            ),
            'agency' => array(
                'caption' => '师资力量',
                'action' => 'teachers'
            ),
            'news' => array(
                'caption' => '机构动态',
                'action' => 'list'
            ),
            'articles' => array(
                'caption' => '知识分享',
                'action' => 'list'
            ),
            'classes' => array(
                'caption' => '课程介绍',
                'action' => 'list'
            ),
        ),
        '学员管理' => array(
            'students' => array(
                'caption' => '学生查询',
                'action' => 'list'
            ),
            'works' => array(
                'caption' => '学生作品',
                'action' => 'list'
            ),
            'tops' => array(
                'caption' => '菁英榜',
                'action' => 'list'
            ),
            'signup' => array(
                'caption' => '报名管理',
                'action' => 'list'
            ),
        ),
        '信息发布' => array(
            'tasks' => array(
                'caption' => '作业任务',
                'action' => 'list'
            ),
            'dailyNews' => array(
                'caption' => '每日讯息',
                'action' => 'list'
            ),
            'items' => array(
                'caption' => '学生成绩',
                'action' => 'list'
            ),
            'comments' => array(
                'caption' => '老师评语',
                'action' => 'list'
            ),
            'feedbacks' => array(
                'caption' => '反馈管理',
                'action' => 'list'
            ),
        ),
        '设置' => array(
            'entities' => array(
                'caption' => '参数设置',
                'action' => 'list'
            ),
            'users' => array(
                'caption' => '用户权限',
                'action' => 'list'
            ),
            'agency' => array(
                'caption' => '密码修改',
                'action' => 'password'
            ),
        ),
    );

    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function getMenu()
    {

        $auth = $this->session->get('auth');
		
		echo '<ul>';
		foreach ( $this->_leftMenu as $menu => $items ) {
			echo '<li class="submenu"><a href="#"> <span>',$menu,'</span></a><ul>';
			foreach ( $items as $c => $v ) {
				echo '<li><a href="/',$c,'/',$v['action'],'">-',$v['caption'],'</a></li>';
			}
			echo '</ul></li>';
		}
		echo '</ul>';
    }
	
	public function getHead()
	{
	}
	
	public function getXheditorClass()
	{
		$upload_url = '/upload.php';
		$xheditor = "xheditor {tools:'full',width:'600',height:'400',cleanPaste:3,upBtnText:'上传',upImgUrl:'$upload_url'}";
		echo $xheditor;
	}
	
}
