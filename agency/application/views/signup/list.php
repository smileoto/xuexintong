<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>报名管理</title>
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
						<div class="content-inner">
							<div class="navbar-top">
								<a class="active" >
									报名管理
								</a>
								<a href="<?php URL::base(NULL, TRUE)?>signup/explain" >
									报名说明
								</a>
							</div>
							
							<div class="titlenav" style="margin-top: 20px;">
								类别选择：
								<select name="class_id" id="class_selector">
									<option value="0"></option>
									<?php foreach ( $classes as $v ) : ?>
									<option value="<?php echo $v['id']?>" 
									<?php
									if ( $class_id == $v['id'] ) {
										echo 'selected="selected"';
									}
									?> >
									<?php echo $v['name']?>
									</option>
									<?php endforeach?>
								</select>
							</div>
							
							<div class="table-cell">
							<table border="1" cellspacing="0" cellpadding="0">
								<tr><th>班别名称</th><th>课程内容</th><th>上课时间</th><th>课时</th><th>学费</th><th>招生人数</th><th>操作</th></tr>
								<?php foreach ( $items as $v ) : ?>
								<tr>
									<td><?php echo $v['class'],'-',$v['name']?></td>
									<td><?php echo $v['content']?></td>
									<td><?php echo $v['time']?></td>
									<td><?php echo $v['hours']?></td>
									<td><?php echo $v['tuition']?>元</td>
									<td><?php echo $v['num']?></td>
									<td>
										<?php if ( $v['signup'] == 0 ) : ?>
										<a href="<?php echo URL::base(NULL, TRUE)?>signup/publish/?id=<?php echo $v['id']?>">
											发布报名
											</a>
										<?php else:?>
										<a href="<?php echo URL::base(NULL, TRUE)?>signup/cancel/?id=<?php echo $v['id']?>">
											取消报名
										</a>
										<?php endif?>
									</td>
								</tr>
								<?php endforeach?>
							</table>
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

<script type="text/javascript">
$(function () {
	var url = '<?php echo URL::base(NULL, TRUE)?>signup/list/?class_id=';
	$('#class_selector').change(function () {
		window.location.href = url + $(this).val();
	});
});
</script>
