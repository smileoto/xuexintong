<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>老师评语</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
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
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>comment/list/">老师评语</a>
								<a class="active">发布评语</a>
							</div>
							
							<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>comment/save/">
							
							<div class="accountSettings-box">
								<ul>
									<li>
										<span class="m-name">
											姓名：
										</span>
										<input type="text" readonly="readonly"  id="student">
										<input type="hidden" name="student_id" id="student_id">
									</li>
									<li>
										<a class="btn btn-primary btn-large theme-login" href="javascript:;" id="btnOpenSelector">选择学生</a>
									</li>
									<!--
									<li style="width:100%">
										<span class="m-name">
											时间：
										</span>
										<input  type="date" /><span class="m-name" style="width: 15px;background: none;margin-right: 10px;border: 0;">
											至
										</span><input  type="date" />
									</li>
									-->
									<li style="width: 100%;height: 100px;">
										<span class="m-name">
											评语：
										</span>
										<textarea name="content" id="content" style="width: 477px;resize: none;" rows="6"></textarea>
									</li>
								</ul>
							</div>
							
							</form>
							
							<div class="btn-box" style="float: left;height: 50px;"  >
								<button id="btnSubmit" style="margin-top: 10px;margin-left: 100px;">发布</button>
							</div>
						</div>
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
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?PHP echo URL::base()?>js/provincesdata.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	var search_url = '<?php echo URL::base(NULL, TRUE)?>student/search/';
	var add_url    = window.location.href;
	
	$('.search-field').change(function () {
		var jsonObj = {};
		$('.search-field').each(function(){
			var key = $(this).attr('id');
			var val  = $(this).val();
			jsonObj[key] = val;
		});
		
		$.post(search_url, jsonObj, function (jsonStr) {
			var students = jQuery.parseJSON(jsonStr);
			
			var studentSelector = $('#student');
			studentSelector.empty();
			$.each(students, function (k, v) {
				studentSelector.append('<option value="' + v.id + '">' + v.realname + ' (' + v.birthday + ')' + '</option>');
			});
		});
	});
	
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
	});
	
	$('#btnOpenSelector').click(function(){
		var url = '<?php echo URL::base(NULL, TRUE)?>student/list/?pop=1&size=4';
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