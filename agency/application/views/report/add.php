<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>学生成绩</title>
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
		<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
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
					
						<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>report/save/">
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE),'report/list/'?>">学生成绩</a>
								<a class="active">发布成绩</a>
							</div>
							<div class="accountSettings-box">
							<ul>
                            	<li style="width:100%">
									<span class="m-name">
										起止时间：
									</span>
									<input type="date" name="begin_str" id="begin_t" /> 
									至 
									<input type="date" name="end_str" id="end_t" />
								</li>
								<li style="width:100%">
									<span class="m-name">
										姓名：
									</span>
									<input type="text"   id="student" readonly="readonly">
									<input type="hidden" id="student_id" name="student_id">
									<a class="btn btn-primary btn-large theme-login" href="javascript:;" id="btnOpenSelector">选择学生</a>
                                </li>
								<li style="width: 100%;height: 100px;">
									<span class="m-name">
										成绩：
									</span>
									<textarea style="width: 477px;resize: none;" rows="6" name="content" id="content"></textarea>
								</li>
							</ul>
							</div>
							<div class="btn-box" style="float: left;height: 50px;"  >
								<button style="margin-top: 10px;margin-left: 100px;" id="btnSubmit">发布</button>
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
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#btnOpenSearchCnt').click(function () {
		$('#cntSearch').css('position', 'absolute').css('top', '100px').css('left', '300px').show();
	});
	
	$('#btnCancel').click(function () {
		$('#cntSearch').hide();
	});
	
	$('#btnSelect').click(function () {
		$('#student_id').val($('#result').val());
		$('#realname').val($('#result').find("option:selected").text());
		$('#cntSearch').hide();
	});
	
	$('#btnSearchStudent').click(function () {
		var jsonObj = {};
		$('.search-field').each(function () {
			var key = $(this).attr('id');
			var val = $(this).val();
			jsonObj[key] = val;
		});
		
		var url = '<?php echo URL::base(NULL, TRUE)?>student/search';
		$.post(url, jsonObj, function (jsonStr) {
			var students = $.parseJSON(jsonStr);
			
			var cnt = $('#result');
			cnt.empty();
			$.each(students, function (k, v) {
				var option = '<option value="' + v.id + '">' + v.realname + '(' + v.birthday + ')' + '</option>';
				cnt.append(option);
			});
		});
	});
	
	$('#btnSubmit').click(function () {
		var  student_id = $.trim($('#student_id').val());
		if ( student_id == "" ) {
			alert('请选择一位学生');
			return false;
		}
		
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