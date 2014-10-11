<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>老师评语</title>
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
								<a href="<?php echo URL::base(NULL, TRUE)?>feedback/topics/?from=student">反馈列表</a>
								<a class="active">回复反馈</a>
							</div>
						<div class="accountSettings-box">
							<ul>
								<li>
									<span class="m-name">
										姓名：
									</span>
									<?php echo $item['student']?>
									<input type="hidden" class="data-field" id="student_id" value="<?php echo $item['student_id']?>" />
								</li>
								<li style="width: 100%;height: 100px;">
									<span class="m-name">
										内容：
									</span>
									<?php echo $item['content']?>
								</li>
							</ul>
							<?php foreach( $reply_list as $v ) : ?>
							<ul>
								<li>
									<span class="m-name">
										<?php echo $v['teacher']?>：
									</span>
									<?php echo $v['content']?>：
								</li>
							</ul>
							<?php endforeach?>
							<ul>
								<li style="width: 100%;height: 100px;">
									<span class="m-name">
										回复：
									</span>
									<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>feedback/save/">
									<input type="hidden" name="feedback_id" value="<?php echo $item['id']?>">
									<textarea name="content" id="content" style="width: 477px;resize: none;" rows="6"></textarea>
									</form>
								</li>
							</ul>
						</div>
						<div class="btn-box" style="float: left;height: 50px;"  >
							<button id="btnSubmit" style="margin-top: 10px;margin-left: 100px;">回复</button>
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
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?PHP echo URL::base()?>js/provincesdata.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
	});
});
</script>