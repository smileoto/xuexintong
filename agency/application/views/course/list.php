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
						<div class="content-inner">
							<div class="navbar-top">
								<a class="active" ><?php echo $class['name']?></a>
							</div>
							<div class="titlenav" style="margin-top: 20px;">
								班别设置：
								<a href="<?php echo URL::base(NULL, TRUE)?>course/add/?class_id=<?php echo $class['id']?>" style="float: right;">
									添加班别
								</a>
							</div>
							<div class="table-cell">
							<table border="1" cellspacing="0" cellpadding="0">
								<tr><th>班别名称</th><th>课程内容</th><th>上课时间</th><th>课时</th><th>学费</th><th>招生人数</th><th>操作</th></tr>
								<?php foreach ($items as $v) : ?>
									<tr>
										<td><?php echo $v['name']?></td>
										<td><?php echo $v['content']?></td>
										<td><?php echo $v['time']?></td>
										<td><?php echo $v['hours']?></td>
										<td><?php echo $v['tuition']?>元</td>
										<td><?php echo $v['num']?></td>
										<td>
											<a href="<?php echo URL::base(NULL, TRUE)?>course/del/?id=<?php echo $v['id']?>">停用</a>
											<a href="<?php echo URL::base(NULL, TRUE)?>course/edit/?id=<?php echo $v['id']?>">编辑</a>
										</td>
									</tr>
							  	<?php endforeach;?>
							</table>
							
							<form method="post" action="<?php echo URL::base(NULL, TRUE)?>class/save_detail/">
							<input type="hidden" name="id" value="<?php echo $class['id']?>">
							<div class="table-cell">
								<textarea name="content" class="<?php echo $xheditor_config?>" id="content"><?php echo $class['content']?></textarea>
							</div>
							<div class="btn-box">
								<button id="btnSubmit" style="margin-left: 10%;margin-top: 50px;float: left;">确定提交</button>
							</div>
							</form>
							
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
<script type="text/javascript" charset="utf-8">
$(function(){	
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
	});
});
</script>
