<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>用户权限</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
		<!--[if gte IE 9]>
		  <style type="text/css">
		    .gradient {
		       filter: none;
		    }
		  </style>
		<![endif]-->
	</head>

	<body>
		<div class="all">
			<div class="main" id="main">
				<div class="header" id="header">
					<?php echo $html_head_content?>
				</div>
				<div class="content">
					<div class="sidebar" id="sidebar">
						<?php echo $html_left_content?>
					</div>
					<div class="content-box">
						<div class="content-inner">
							<div class="navbar-top">
								<a class="active">人员权限</a>
							</div>
						<div class="accountSettings-box">
							<ul>
								<li style="width:100%">
									<span class="m-name">
										用户名：
									</span>
									<input type="text" style="width: 477px;" class="data-field" id="username" />
								</li>
								<li style="width:100%">
									<span class="m-name">
										名称：
									</span>
									<input type="text" style="width: 477px;" class="data-field" id="realname" />
								</li>
								<li style="width:100%">
									<span class="m-name">
										说明：
									</span>
									<input type="text" style="width: 477px;" class="data-field" id="remark" />
								</li>
								<li style="width:590px;line-height: 35px;">
									<span class="m-name">
										权限：
									</span>
									
									<div style="width: 485px;float: left;background: #fff;">
										
									<div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">
										机构介绍：
									</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="edit-agency" />
									<span style="float: left;margin-left: 5px;">简介</span>
									
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="edit-show" />
									<span style="float: left;margin-left: 5px;">展示</span>
									
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="edit-contacts" />
									<span style="float: left;margin-left: 5px;">联系</span>
									</div>
									
									<div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">师资力量：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="edit-teacher" />
									<span style="float: left;margin-left: 5px;">编辑</span>
									</div>
									
									<div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">机构动态：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-news" />
									<span style="float: left;margin-left: 5px;">发布</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">知识分享：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-knowledge" />
									<span style="float: left;margin-left: 5px;">发布</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">课程介绍：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-classes" />
									<span style="float: left;margin-left: 5px;">添加类别</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-course" />
									<span style="float: left;margin-left: 5px;">添加班别</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">学生查询：
									</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="query-student" />
									<span style="float: left;margin-left: 5px;">查询</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-student" />
									<span style="float: left;margin-left: 5px;">审核</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">学生作品：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-works" />
									<span style="float: left;margin-left: 5px;">发布</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">菁英榜：
									</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-ranking" />
									<span style="float: left;margin-left: 5px;">发布</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">报名管理：
									</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-signup" />
									<span style="float: left;margin-left: 5px;">发布</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">作业任务：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-homework" />
									<span style="float: left;margin-left: 5px;">发布</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">每日讯息：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-daily_news" />
									<span style="float: left;margin-left: 5px;">发布</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">学生成绩：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-score" />
									<span style="float: left;margin-left: 5px;">发布</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">老师评语：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="comment-feedback" />
									<span style="float: left;margin-left: 5px;">评论</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">反馈管理：
									</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="reply-feedback" />
									<span style="float: left;margin-left: 5px;">回复</span>
									</div>
									
                                    <div class="checkbox-box" style="width: 485px;float: left;">
									<span class="m-name" style="background: none;border: 0;">参数设置：</span>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="manage-setting" />
									<span style="float: left;margin-left: 5px;">设置</span>
									</div>
									
									</div>
								</li>
								<li style="width:100%">
									<span class="m-name">
										密码：
									</span>
									<input type="password" style="width: 477px;" class="data-field" id="password" />
								</li>
								<li style="width:100%">
									<span class="m-name">
										密码确认：
									</span>
									<input type="password" style="width: 477px;" id="confirm" />
								</li>
							</ul>
						</div>
						<div class="btn-box" style="float: left;height: 50px;"  >
								<button id="btnSubmit" style="margin-top: 10px;margin-left: 100px;">添加</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {
		document.getElementById("sidebar").style.minHeight = document.getElementById("main").clientHeight - document.getElementById("header").clientHeight - 3 + 'px';
	}
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('input[type=checkbox]').each(function(){
		$(this).attr('checked', true);
	});
	$('input[type=checkbox]').click(function () {
		if ( $(this).attr('checked') ) {
			$(this).attr('checked', false);
		} else {
			$(this).attr('checked', true);
		}
	});
	
	$('#btnSubmit').click(function(){
		var p1 = $('#password').val();
		var p2 = $('#confirm').val();
		if ( p1 != p2 ) {
			alert('两次密码输入不符合');
			return false;
		}
		
		var self = $(this);
		self.hide();
		
		var jsonObj  = {};
		var groupArr = [];
		$('input[type=checkbox]').each(function(){
			var key = $(this).attr('name');
			var val = key;
			if ( $(this).attr('checked') ) {
				val += '=1';
			} else {
				val += '=0';
			}
			groupArr.push(val);
		});
		
		jsonObj['permission'] = groupArr.join('&');
		$('.data-field').each(function(){
			var key = $(this).attr('id');
			var val = $(this).val();
			jsonObj[key] = val;
		});
		
		$.post(window.location.href, jsonObj, function(jsonStr){
			var resultObj = jQuery.parseJSON(jsonStr);
			if (resultObj.ret != 0) {
				alert(resultObj.msg);
				self.show();
				return false;
			}
			
			window.location.href = '<?php echo URL::base(NULL, TRUE)?>permission/users';
		});
	});
});
</script>
