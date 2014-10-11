<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>菁英榜</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/ago.css" />
        <link rel="stylesheet" href="<?PHP echo URL::base()?>css/jquery.windows.css" media="all">
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
												
						<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>top/save/">
						<input type="hidden" name="id" value="<?php echo $item['id']?>">
						
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE),'top/list/'?>">菁英榜</a>
								<a class="active" >编辑榜单</a>
							</div>
							<div class="elite-left">
								<div class="input-box input-box-title">
									<span>榜单标题：</span>
									<input type="text" id="title" value="<?php echo $item['title']?>" />
								</div>
								<?php $cnt = 1;?>
								<?php foreach ( $ranking_students as $v ) : ?>
								<div class="input-box">
									<span>学生姓名：</span>
									<input type="text" readonly="readonly"  id="realname-<?php echo $cnt?>"   value="<?php echo $v['realname']?>" />
									<input type="hidden" class="data-field" id="student_id-<?php echo $cnt?>" value="<?php echo $v['id']?>" />
									<a class="btn btn-primary btn-large theme-login" href="javascript:;" onclick="select_student(<?php echo $cnt?>)">选择学生<a>
								</div>
								<div class="scan-box">
									<span>学生头像：</span>
									<input type="text" readonly="readonly" name="avator[]" id="avatar-<?php echo $cnt?>" value="<?php $v['avatar']?>" />
								</div>
								<div class="input-box input-box-title">
									<span>上榜理由：</span>
									<input type="text" class="title-elite data-field" name="reason[]" id="reason-<?php echo $cnt?>" value="<?php echo $v['reason']?>" />
								</div>
								<?php $cnt++;?>
								<?php endforeach;?>
								<div class="btn-box" id="posStudents">
									<button style="margin-left: 70px;margin-top: 10px;" id="btnAddStudent">增加学生</button>
									<button style="margin-left: 70px;margin-top: 10px;" id="btnSubmit">确认提交</button>
								</div>
							</div>						
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
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8">
var g_current_group = 1;
function select_student(group) {
	g_current_group = group;
	
	var url = '<?php echo URL::base(NULL, TRUE)?>student/list/?pop=1&size=4';
	$.get(url, {}, function (html) {
		$('#cntSelector').html(html);
		$('.theme-popover-mask').fadeIn(100);
		$('.theme-popover').slideDown(200);
	});
}

function select_for_audit(student_id) {
	var url = '<?php echo URL::base(NULL, TRUE)?>student/search/';
	$.post(url, {student_id:student_id}, function (jsonStr) {
		var students = jQuery.parseJSON(jsonStr);
		$.each(students, function (k, v) {	
			$('#student_id-' + g_current_group).val(v.id);
			$('#realname-'   + g_current_group).val(v.realname + ' (' + v.birthday + ')');
		});
		$('#cntSelector').hide();
	});
}

$(function(){
	var cnt = '<?php echo $cnt?>';
	$('#btnAddStudent').click(function () {
		cnt++;
		var html = '';
		html += '<div class="input-box">';
		html += '	<span>学生姓名：</span>';
		html += '	<input type="text" readonly="readonly" id="realname-' + cnt + '" />';
		html += '	<input type="hidden" class="data-field" id="student_id-' + cnt + '" value="" />';
		html += '	<a class="btn btn-primary btn-large theme-login" href="javascript:;" onclick="select_student(' + cnt + ')">选择学生<a>';
		html += '</div>';
		html += '<div class="input-box input-box-title">';
		html += '	<span>上榜理由：</span>';
		html += '	<input class="title-elite data-field" type="text" id="reason-' + cnt + '" />';
		html += '</div>';
		$(html).insertBefore('#posStudents');
	});
	
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
	});
});
</script>