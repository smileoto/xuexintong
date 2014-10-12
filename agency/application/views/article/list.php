<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>知识分享</title>
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
								<a href="#" class="active">知识分享</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>article/add/">添加分享</a>
							</div>
							<div class="input-box">
								<span>标题：</span>
								<input type="text" id="title" class="data-field" />
								<button id="btnSearch">搜索</button>
							</div>
							<div class="table-cell">
							<table border="1" cellspacing="0" cellpadding="0">
							  	<tr><th>序号</th><th>标题</th><th>添加时间</th><th>修改时间</th><th>编辑者</th><th>操作</th></tr>
							  	<?php foreach($items as $v):?>
								<tr>
									<td><?php echo $v['id']?></td>
									<td>
										<?php
										if ( strlen($v['title']) > 20 ) { 
											echo substr($v['title'], 0, 20);
										} else {
											echo $v['title'];
										}
										?>
									</td>
									<td><?php echo $v['created_at']?></td>
									<td><?php echo $v['modified_at']?></td>
									<td><?php echo $v['username']?></td>
									<td>
										<a href="<?php echo URL::base(NULL, TRUE)?>article/del/?id=<?php echo $v['id']?>">停用</a>
										<a href="<?php echo URL::base(NULL, TRUE)?>article/edit/?id=<?php echo $v['id']?>">编辑</a>
									</td>
								</tr>
								<?php endforeach;?>
							</table>
							<div class="pagenav">
								<?php echo $html_pagenav_content?>
							</div>
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
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#btnSearch').click(function(){
		// todo: check params
		var url = '<?php echo URL::base(NULL, TRUE)?>article/list/';
		$('.data-field').each(function(){
			var key = $(this).attr('id');
			var val  = $(this).val();
			url += '&' + key + '=' + val;
		});
		
		window.location.href = url;
	});
});
</script>