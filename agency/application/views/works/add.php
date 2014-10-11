<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>添加作品</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
		<!--[if gte IE 9]>
		  <style type="text/css">
		    .gradient {
		       filter: none;
		    }
		  </style>
		<![endif]-->
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/xheditor.js"></script>
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/xheditor_lang/zh-cn.js"></script>
        <link rel="stylesheet" href="<?PHP echo URL::base()?>css/jquery.windows.css" media="all">
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
					
						<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>works/save/">
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>works/list/">学生作品</a>
								<a class="active">添加作品</a>
							</div>
							<ul>
                            	<li>
                                	<div class="con-name">
									学生姓名：
									</div>
									<div class="con-info">
										<input type="text"   id="student" readonly="readonly" size="10" maxlength="10">
										<input type="hidden" id="student_id" name="student_id">
										<a class="btn btn-primary btn-large theme-login" href="javascript:;" id="btnOpenSelector">选择学生</a>
									</div>
                                </li>
                                <li>
                                	<div class="con-name">
									标题：
									</div>
									<div class="con-info"><i>(字数必须在16个字符内)</i>
									<input type="text" name="title" id="title" />
									</div>
                                </li>
                                <li>
                                	<div class="con-name">
									老师点评：
									</div>
									<div class="con-info">
									<textarea cols="50" rows="5" name="comment" id="comment"></textarea>
									</div>
                                </li>
                                <li>
                                	<div class="table-cell">
									<textarea name="content" class="data-field <?php echo $xheditor_config?>" id="content"></textarea>
									</div>
                                </li>
                                <li>
                                	<div class="btn-box">
										<button id="btnSubmit">确定提交</button><br/>
									</div>
                                </li>
                            </ul>
						</div>
						</form>
						
					</div>
				</div>
			</div>
		</div>
		
		<div class="theme-popover" style="font-size:0.8em;" id="cntSelector"></div>
		<div class="theme-popover-mask"></div> 
		
	</body>
</html>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {
		document.getElementById("sidebar").style.minHeight = document.getElementById("main").clientHeight - document.getElementById("header").clientHeight - 3 + 'px';
	}
</script>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
	});
	
	$('#btnOpenSelector').click(function(){
		var url = '<?php echo URL::base(NULL, TRUE)?>student/select/?size=4';
		$.get(url, {}, function (html) {
			$('#cntSelector').html(html);
			$('.theme-popover-mask').fadeIn(100);
			$('.theme-popover').slideDown(200);
		});
	});
});

function select_for_audit(student_id) {
	$('#student_id').val(student_id);
	var url = '<?php echo URL::base(NULL, TRUE)?>student/search/';
	$.post(url, {student_id:student_id}, function (jsonStr) {
		var students = jQuery.parseJSON(jsonStr);
		$.each(students, function (k, v) {
			$('#student').val(v.realname + ' (' + v.birthday + ')');
			$('#student_id').val(v.id);
		});
		$('#cntSelector').hide();
	});
}
</script>
