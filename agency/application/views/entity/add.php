<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>课程介绍</title>
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
					
						<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>entity/save/">
						<div class="content-inner">
							<div class="navbar-top">
								<a class="active">添加分机构</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>school/list/">学校设置</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>grade/list/" >年级设置</a>
							</div>
							<ul>
								<li>
									<div class="con-name">
										机构名称：
									</div>
									<div class="con-info">
										<input type="text" name="name" id="name"/>
									</div>
								</li>
								<li>
									<div class="con-name">
										地址：
									</div>
									<div class="con-info">
										<input type="text" name="addr" id="addr"/>
									</div>
								</li>
								<li>
									<div class="con-name">
										联系人：
									</div>
									<div class="con-info">
										<input type="text" name="contact" id="contacts"/>
									</div>
								</li>
								<li>
									<div class="con-name">
										联系电话：
									</div>
									<div class="con-info">
										<input type="text" name="mobile" id="mobile"/>
									</div>
								</li>
							</ul>
							<div class="btn-box">
								<button style="margin-left: 10%;margin-top: 50px;float: left;" id="btnSubmit">确定提交</button>
							</div>
						</div>
						</form>
						
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
<script type="text/javascript" charset="utf-8">
$(function(){	
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
	});
});
</script>