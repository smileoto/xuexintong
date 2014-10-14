<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>发布作业</title>
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
					
						<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>task/save/">
						<input type="hidden" name="id" value="<?php echo $item['id']?>">
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>task/list/" >作业任务</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>task/add/">发布作业</a>
								<a href="#" class="active">编辑作业</a>
							</div>
							<div style="margin-top: 20px;">
								<span>日期：</span><input type="date" name="date_str" id="date" value="<?php echo $item['date_str']?>" />
																
								<span>分机构：</span>
								<select name="entity_id" id="entity">
									<option value=""></option>
									<?php foreach ( $entities as $v ) : ?>
										<option value="<?php echo $v['id']?>" 
											<?php if($v['id'] == $item['entity_id']) echo 'selected="selected"'?> >
											<?php echo $v['name']?>
										</option>
									<?php endforeach?>
								</select>
								
								<span>机构班别：</span>
								<select name="course_id" id="course">
									<option value=""></option>
									<?php foreach ( $courses as $v ) : ?>
										<option value="<?php echo $v['id']?>" 
											<?php if($v['id'] == $item['course_id']) echo 'selected="selected"' ?> >
											<?php echo $v['name']?>
										</option>
									<?php endforeach?>
								</select>
								
								<span>所在学校：</span>
								<select name="school_id" id="school">
									<option value=""></option>
									<?php foreach ( $schools as $v ) : ?>
									<option value="<?php echo $v['id']?>" 
										<?php if($v['id'] == $item['school_id']) echo 'selected="selected"' ?> >
										<?php echo $v['name']?>
									</option>
									<?php endforeach?>
								</select>
								
								<span>所在班级：</span>
								<select name="grade_id" id="grade">
									<option value=""></option>
									<?php foreach ( $grades as $v ) : ?>
									<option value="<?php echo $v['id']?>" 
										<?php if($v['id'] == $item['grade_id']) echo 'selected="selected"'?> >
										<?php echo $v['name']?>
									</option>
									<?php endforeach?>
								</select>
							</div>
							<br />
							<span>标题：</span><input type="text" name="title" id="title" value="<?php echo $item['title']?>" />
							<div class="table-cell">
								<textarea class="<?php echo $xheditor_config?>" name="content" id="content"><?php echo $item['content']?></textarea>
							</div>
							<div class="btn-box">
								<button id="btnSubmit">确定发布</button>
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