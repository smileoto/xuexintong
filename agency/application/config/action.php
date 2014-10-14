<?php
return array
(
	'session/index' => array(
		'desc'  => '登录',
		'login' => false,
	),
	'session/start' => array(
		'desc'  => '验证',
		'login' => false,
	),
	'session/end' => array(
		'desc'  => '退出',
		'login' => false,
	),
	
	'agency/index' => array(
		'desc'  => '简介',
		'login' => false,
	),
	'agency/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	
	'introduction/index' => array(
		'desc'  => '简介',
		'login' => false,
	),
	'introduction/save' => array(
		'desc'  => '修改',
		'login' => true,
	),
	'show/index' => array(
		'desc'  => '展示',
		'login' => false,
	),
	'show/save' => array(
		'desc'  => '修改',
		'login' => true,
	),
	'contact/index' => array(
		'desc'  => '联系',
		'login' => false,
	),
	'contact/save' => array(
		'desc'  => '修改',
		'login' => true,
	),
	'teachers/index' => array(
		'desc'  => '师资力量',
		'login' => false,
	),
	'teachers/save' => array(
		'desc'  => '修改',
		'login' => true,
	),
		
	'news/list' => array(
		'desc'  => '机构动态',
		'login' => false,
	),
	'news/add' => array(
		'desc'  => '新增',
		'login' => true,
		'bind'  => array('news/save'),
	),
	'news/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('news/save'),
	),
	'news/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'news/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'dailynews/list' => array(
		'desc'  => '每日讯息',
		'login' => false,
	),
	'dailynews/add' => array(
		'desc'  => '新增',
		'login' => true,
		'bind'  => array('dailynews/save'),
	),
	'dailynews/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('dailynews/save'),
	),
	'dailynews/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'dailynews/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'article/list' => array(
		'desc'  => '知识分享',
		'login' => false,
	),
	'article/add' => array(
		'desc'  => '新增',
		'login' => true,
		'bind'  => array('article/save'),
	),
	'article/edit' => array(
		'desc'  => '修改',
		'bind'  => array('article/save'),
		'login' => true,
	),
	'article/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'article/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'class/list' => array(
		'desc'  => '课程类别',
		'login' => false,
	),
	'class/add' => array(
		'desc'  => '新增',
		'login' => true,
		'bind'  => array('class/save'),
	),
	'class/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('class/save'),
	),
	'class/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'class/save_detail' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'class/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'course/list' => array(
		'desc'  => '课程',
		'login' => false,
	),
	'course/add' => array(
		'desc'  => '新增',
		'login' => true,
		'bind'  => array('course/save'),
	),
	'course/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('course/save'),
	),
	'course/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'course/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'entity/list' => array(
		'desc'  => '分机构',
		'login' => false,
	),
	'entity/add' => array(
		'desc'  => '新增',
		'login' => true,
		'bind'  => array('entity/save'),
	),
	'entity/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('entity/save'),
	),
	'entity/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'entity/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'school/list' => array(
		'desc'  => '学校',
		'login' => false,
	),
	'school/add' => array(
		'desc'  => '新增',
		'login' => true,
		'bind'  => array('school/save'),
	),
	'school/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('school/save'),
	),
	'school/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'school/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'grade/list' => array(
		'desc'  => '年级',
		'login' => false,
	),
	'grade/add' => array(
		'desc'  => '新增',
		'login' => true,
		'bind'  => array('grade/save'),
	),
	'grade/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('grade/save'),
	),
	'grade/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'grade/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'student/list' => array(
		'desc'  => '学生',
		'login' => false,
	),
	'student/select' => array(
		'desc'  => '选择学生',
		'login' => false,
	),
	'student/search' => array(
		'desc'  => '查找学生',
		'login' => false,
	),
	'student/add' => array(
		'desc'  => '新增',
		'login' => true,
		'bind'  => array('student/save'),
	),
	'student/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('student/save'),
	),
	'student/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'student/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
	'student/notify' => array(
		'desc'  => '通知',
		'login' => true,
	),
	'student/sms' => array(
		'desc'  => '发短信',
		'login' => true,
	),
		
	'guest/list' => array(
		'desc'  => '申请',
		'login' => false,
	),
	'guest/audit' => array(
		'desc'  => '审核',
		'login' => true,
		'bind'  => array('guest/save'),
	),
	'guest/save' => array(
		'desc'  => '审核',
		'login' => true,
	),
	'guest/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'task/list' => array(
		'desc'  => '作业',
		'login' => false,
	),
	'task/add' => array(
		'desc'  => '发布',
		'login' => true,
		'bind'  => array('task/save'),
	),
	'task/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('task/save'),
	),
	'task/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'task/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'works/list' => array(
		'desc'  => '作品',
		'login' => false,
	),
	'works/add' => array(
		'desc'  => '发布',
		'login' => true,
		'bind'  => array('works/save'),
	),
	'works/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('works/save'),
	),
	'works/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'works/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'top/list' => array(
		'desc'  => '菁英榜',
		'login' => false,
	),
	'top/add' => array(
		'desc'  => '发布',
		'login' => true,
		'bind'  => array('top/save', 'top/del_student'),
	),
	'top/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('top/save', 'top/del_student'),
	),
	'top/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'top/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'report/list' => array(
		'desc'  => '学生成绩',
		'login' => false,
	),
	'report/add' => array(
		'desc'  => '发布',
		'login' => true,
		'bind'  => array('report/save'),
	),
	'report/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('report/save'),
	),
	'report/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'report/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
		
	'signup/list' => array(
		'desc'  => '报名管理',
		'login' => false,
	),
	'signup/publish' => array(
		'desc'  => '发布',
		'login' => true,
	),
	'signup/cancel' => array(
		'desc'  => '取消',
		'login' => true,
	),
	'signup/explain' => array(
		'desc'  => '详情',
		'login' => true,
		'bind'  => array('report/save'),
	),
	'signup/save' => array(
		'desc'  => '详情',
		'login' => true,
	),
		
	'user/list' => array(
		'desc'  => '机构用户',
		'login' => false,
	),
	'user/add' => array(
		'desc'  => '添加',
		'login' => true,
		'bind'  => array('user/save'),
	),
	'user/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'bind'  => array('user/save'),
	),
	'user/save' => array(
		'desc'  => '保存',
		'login' => true,
	),
	'user/del' => array(
		'desc'  => '删除',
		'login' => true,
	),
	
);
