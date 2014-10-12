<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>参数设置</title>
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
								<?php if ( isset($entity_num) and $entity_num > 0 ) : ?>
								<a href="<?php echo URL::base(NULL, TRUE)?>entity/list/" >分机构设置</a>
								<?php endif?>
								<a class="active" >学校设置</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>grade/list/" >年级设置</a>
							</div>
							<div class="titlenav" style="margin-top: 20px;">
								<a style="float: right;" href="<?php echo URL::base(NULL, TRUE)?>school/add/">添加学校</a>
							</div>
							<div class="table-cell">
							<table border="1" cellspacing="0" cellpadding="0">
								<tr><th>学校名称</th><th>地址</th><th>联系人</th><th>联系电话</th><th>操作</th></tr>
								<?php foreach ( $items as $v ) : ?>
								<tr>
									<td><?php echo $v['name'];?></td>
									<td><?php echo $v['addr']?></td>
									<td><?php echo $v['contact']?></td>
									<td><?php echo $v['mobile']?></td>
									<td>
										<a href="<?php echo URL::base(NULL, TRUE),'school/edit/?id=',$v['id']?>">编辑</a>
										<a href="<?php echo URL::base(NULL, TRUE),'school/del/?id=',$v['id']?>">停用</a>
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