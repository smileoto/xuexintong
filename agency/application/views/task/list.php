<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>作业任务</title>
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
								<a class="active">作业任务</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>task/add/">发布作业</a>
							</div>
							<div class="accountSettings-title">
							条件检索
						</div>
						<div class="accountSettings-box">
							<ul>
								<li>
									<span class="m-name">
										所在分机构：
									</span>
									<select class="data-field" id="entity">
										<option value=""></option>
										<?php foreach ( $entities as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">
										所在学校：
									</span>
									<select class="data-field" id="school">
										<option value=""></option>
										<?php foreach ( $schools as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">
										所在年级：
									</span>
									<select class="data-field" id="grade">
										<option value=""></option>
										<?php foreach ( $grades as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">
										日期：
									</span>
									<input type="date" class="data-field" id="date" />
								</li>
							</ul>
						</div>
						<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
								<button style="margin-left: 0;margin-top: 10px;" id="btnSearch">搜索</button>
							</div>
							<div class="table-cell">
							<table border="1" cellspacing="0" cellpadding="0">
								<tr><th>序号</th><th>作业日期</th><th>所在学校</th><th>所在年级</th><th>机构班别</th><th>操作</th></tr>
								<?php foreach($items as $v) : ?>
								<tr>
									<td><?php echo $v['id']?></td>
									<td><?php echo $v['date_str']?></td>
									<td><?php echo $v['school']?></td>
									<td><?php echo $v['grade']?></td>
									<td><?php echo $v['class'],'-',$v['course']?></td>
									<td>
										<a href="<?php echo URL::base(NULL, TRUE)?>task/edit/?id=<?php echo $v['id']?>">编辑</a>
										<?php if ($v['status'] == STATUS_NORMAL) : ?>
										<a href="<?php echo URL::base(NULL, TRUE)?>task/publish/?id=<?php echo $v['id']?>">发布</a>
										<?php elseif ($v['status'] == STATUS_ENABLED) : ?>
										<a href="<?php echo URL::base(NULL, TRUE)?>task/cancel/?id=<?php echo $v['id']?>">取消</a>
										<?php endif?>
										<a href="<?php echo URL::base(NULL, TRUE)?>task/del/?id=<?php echo $v['id']?>">删除</a>
									</td>
								</tr>
								<?php endforeach?>
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
		var url = '<?php echo URL::base(NULL, TRUE)?>task/list/';
		$('.data-field').each(function(){
			var key = $(this).attr('id');
			var val  = $(this).val();
			url += '&' + key + '=' + val;
		});
		
		window.location.href = url;
	});
});
</script>