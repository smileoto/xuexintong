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
					
						<?php foreach ($groups_classes as $entity_id => $items) : ?>
						<div class="content-inner">
							<div class="navbar-top">
								<a class="active">课程类别</a>
								<?php if ( $entity_id ) : ?>
								<span style="width:200px; height:40px; line-height:40px; margin-left:5px; margin-top:5px; font-weight:bold;">
								（<?php echo $entities[$entity_id]['name']?>）
								</span>
								<?php endif?>
							</div>
							<div class="class-box">
								<?php foreach($items as $v):?>
								<div class="classinner">
									<a href="<?php echo URL::base(NULL, TRUE)?>course/list/?class_id=<?php echo $v['id']?>" onmouseover="document.getElementById('abc_' + <?php echo $v['id']?>).style.display = 'block';" onmouseout="document.getElementById('abc_' + <?php echo $v['id']?>).style.display = 'none';">
									<?php 
									if ( strlen($v['name']) > 20 ) { 
										echo substr($v['name'], 0, 20);
									} else {
										echo $v['name'];
									}
									?>
								</a>
								<div style="width: 100%; height: 30px; line-height: 30px; position: absolute; left: 0px; bottom: 0px; background-color: #a7cfe5; display:none" id="abc_<?php echo $v['id']?>" onmouseover="this.style.display = 'block';" onmouseout="this.style.display = 'none';">
										<span style="float: left;padding-left: 5px;color: #fff; cursor:pointer" onclick="location.href='<?php echo URL::base(NULL, TRUE)?>class/edit/?id=<?php echo $v['id']?>'">编辑</span>
										<span style="float: right; padding-right: 5px;color: #fff;cursor:pointer" onclick="location.href='<?php echo URL::base(NULL, TRUE)?>class/del/?id=<?php echo $v['id']?>'">删除</span>
									</div>
								</div>
								<?php endforeach;?>
								<div class="classinner">
								<a href="<?php echo URL::base(NULL, TRUE)?>class/add/?aid=<?php echo $v['entity_id']?>" style="line-height: 90px;">+添加</a>
								</div>
							</div>
						</div>
						<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
						<?php endforeach;?>
						
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