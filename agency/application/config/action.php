<?php
return array
(
	'session/index' => array(
		'desc'  => '登录',
		'login' => false,
		'show'  => false,
	),
	'session/start' => array(
		'desc'  => '验证',
		'login' => false,
		'show'  => false,
	),
	'session/end' => array(
		'desc'  => '退出',
		'login' => false,
		'show'  => false,
	),
	
	'agency/index' => array(
		'desc'  => '机构信息',
		'login' => false,
		'show'  => false,
	),
	'agency/save' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
	),
	
	'introduction/index' => array(
		'desc'  => '简介',
		'login' => false,
		'show'  => false,
	),
	'introduction/save' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
	),
	'show/index' => array(
		'desc'  => '展示',
		'login' => false,
		'show'  => false,
	),
	'show/save' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
	),
	'contact/index' => array(
		'desc'  => '联系',
		'login' => false,
		'show'  => false,
	),
	'contact/save' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
	),
	'teachers/index' => array(
		'desc'  => '师资力量',
		'login' => false,
		'show'  => false,
	),
	'teachers/save' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
	),
		
	'news/list' => array(
		'desc'  => '机构动态',
		'login' => false,
		'show'  => false,
	),
	'news/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('news/save'),
	),
	'news/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('news/save'),
	),
	'news/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'news/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
	'news/publish' => array(
		'desc'  => '发布',
		'login' => true,
		'show'  => true,
	),
	'news/cancel' => array(
		'desc'  => '取消发布',
		'login' => true,
		'show'  => true,
	),
		
	'dailynews/list' => array(
		'desc'  => '每日讯息',
		'login' => false,
		'show'  => false,
	),
	'dailynews/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('dailynews/save'),
	),
	'dailynews/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('dailynews/save'),
	),
	'dailynews/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'dailynews/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
	'dailynews/publish' => array(
		'desc'  => '发布',
		'login' => true,
		'show'  => true,
	),
	'dailynews/cancel' => array(
		'desc'  => '取消发布',
		'login' => true,
		'show'  => true,
	),
		
	'article/list' => array(
		'desc'  => '知识分享',
		'login' => false,
		'show'  => false,
	),
	'article/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('article/save'),
	),
	'article/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('article/save'),
	),
	'article/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'article/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
	'article/publish' => array(
		'desc'  => '发布',
		'login' => true,
		'show'  => true,
	),
	'article/cancel' => array(
		'desc'  => '取消发布',
		'login' => true,
		'show'  => true,
	),
		
	'class/list' => array(
		'desc'  => '课程类别',
		'login' => false,
		'show'  => false,
	),
	'class/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('class/save'),
	),
	'class/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('class/save'),
	),
	'class/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'class/save_detail' => array(
		'desc'  => '修改类别信息',
		'login' => true,
		'show'  => true,
	),
	'class/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
		
	'course/list' => array(
		'desc'  => '课程',
		'login' => false,
		'show'  => false,
	),
	'course/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('course/save'),
	),
	'course/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('course/save'),
	),
	'course/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'course/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
		
	'entity/list' => array(
		'desc'  => '分机构',
		'login' => false,
		'show'  => false,
	),
	'entity/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('entity/save'),
	),
	'entity/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('entity/save'),
	),
	'entity/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'entity/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
		
	'school/list' => array(
		'desc'  => '学校',
		'login' => false,
		'show'  => false,
	),
	'school/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('school/save'),
	),
	'school/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('school/save'),
	),
	'school/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'school/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
		
	'grade/list' => array(
		'desc'  => '年级',
		'login' => false,
		'show'  => false,
	),
	'grade/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('grade/save'),
	),
	'grade/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('grade/save'),
	),
	'grade/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'grade/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
		
	'student/list' => array(
		'desc'  => '学生',
		'login' => false,
		'show'  => false,
	),
	'student/select' => array(
		'desc'  => '选择学生',
		'login' => false,
		'show'  => false,
	),
	'student/search' => array(
		'desc'  => '查找学生',
		'login' => false,
		'show'  => false,
	),
	'student/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('student/save'),
	),
	'student/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('student/save'),
	),
	'student/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'student/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
	'student/notify' => array(
		'desc'  => '通知',
		'login' => true,
		'show'  => true,
	),
	'student/sms' => array(
		'desc'  => '发短信',
		'login' => true,
		'show'  => true,
	),
		
	'guest/list' => array(
		'desc'  => '申请列表',
		'login' => false,
		'show'  => false,
	),
	'guest/audit' => array(
		'desc'  => '审核',
		'login' => true,
		'show'  => true,
		'bind'  => array('guest/save'),
	),
	'guest/save' => array(
		'desc'  => '审核',
		'login' => true,
		'show'  => false,
	),
	'guest/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
		
	'task/list' => array(
		'desc'  => '作业列表',
		'login' => false,
		'show'  => false,
	),
	'task/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('task/save'),
	),
	'task/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('task/save'),
	),
	'task/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'task/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
	'task/publish' => array(
		'desc'  => '发布',
		'login' => true,
		'show'  => true,
	),
	'task/cancel' => array(
		'desc'  => '取消发布',
		'login' => true,
		'show'  => true,
	),
		
	'works/list' => array(
		'desc'  => '作品列表',
		'login' => false,
		'show'  => false,
	),
	'works/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('works/save'),
	),
	'works/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('works/save'),
	),
	'works/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'works/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
	'works/publish' => array(
		'desc'  => '发布',
		'login' => true,
		'show'  => true,
	),
	'works/cancel' => array(
		'desc'  => '取消发布',
		'login' => true,
		'show'  => true,
	),
		
	'top/list' => array(
		'desc'  => '菁英榜',
		'login' => false,
		'show'  => false,
	),
	'top/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('top/save', 'top/del_student'),
	),
	'top/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('top/save', 'top/del_student'),
	),
	'top/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'top/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
	'top/publish' => array(
		'desc'  => '发布',
		'login' => true,
		'show'  => true,
	),
	'top/cancel' => array(
		'desc'  => '取消发布',
		'login' => true,
		'show'  => true,
	),
		
	'report/list' => array(
		'desc'  => '学生成绩',
		'login' => false,
		'show'  => false,
	),
	'report/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('report/save'),
	),
	'report/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('report/save'),
	),
	'report/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'report/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
	'report/publish' => array(
		'desc'  => '发布',
		'login' => true,
		'show'  => true,
	),
	'report/cancel' => array(
		'desc'  => '取消发布',
		'login' => true,
		'show'  => true,
	),
		
	'signup/list' => array(
		'desc'  => '报名管理',
		'login' => false,
		'show'  => false,
	),
	'signup/publish' => array(
		'desc'  => '发布',
		'login' => true,
		'show'  => true,
	),
	'signup/cancel' => array(
		'desc'  => '取消',
		'login' => true,
		'show'  => true,
	),
	'signup/explain' => array(
		'desc'  => '详情',
		'login' => true,
		'show'  => true,
		'bind'  => array('report/save'),
	),
	'signup/save' => array(
		'desc'  => '详情',
		'login' => true,
		'show'  => false,
	),
		
	'user/list' => array(
		'desc'  => '用户列表',
		'login' => false,
		'show'  => false,
	),
	'user/add' => array(
		'desc'  => '添加',
		'login' => true,
		'show'  => true,
		'bind'  => array('user/save'),
	),
	'user/edit' => array(
		'desc'  => '修改',
		'login' => true,
		'show'  => true,
		'bind'  => array('user/save'),
	),
	'user/save' => array(
		'desc'  => '保存',
		'login' => true,
		'show'  => false,
	),
	'user/del' => array(
		'desc'  => '删除',
		'login' => true,
		'show'  => true,
	),
	
);
