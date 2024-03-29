<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>学生查询</title>
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
								<a href="<?php echo URL::base(NULL, TRUE)?>student/list/">学生查询</a>
								<a class="active">申请查询</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/add/">添加学生</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/add/?adult=1">添加成人学员</a>
							</div>
							<div class="accountSettings-title">
							条件检索
						</div>
						<div class="accountSettings-box">
							<ul>
								<li>
									<span class="m-name">
										姓名：
									</span>
									<input type="text" class="data-field" id="realname" />
								</li>
								<li>
									<span class="m-name">
										性别：
									</span>
									<select class="data-field" id="sex">
										<option value=""></option>
										<option value="1">男</option>
										<option value="0">女</option>
									</select>
								</li>
								<li>
									<span class="m-name">
										所在机构：
									</span>
									<select class="data-field" id="agency">
										<option value=""></option>
										<?php foreach ( $entities as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">
										学校：
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
										年级：
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
										班别：
									</span>
									<select class="data-field" id="class">
										<option value=""></option>
										<?php foreach ( $classes as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">
										手机号码：
									</span>
									<input type="text" class="data-field" id="mobile" />
								</li>
								<li>
									<span class="m-name">
										父亲姓名：
									</span>
									<input type="text" class="data-field" id="father_name" />
								</li>
								<li>
									<span class="m-name">
										父亲手机：
									</span>
									<input type="text" class="data-field" id="father_mobile" />
								</li>
								<li>
									<span class="m-name">
										母亲姓名：
									</span>
									<input type="text" class="data-field" id="mother_name" />
								</li>
								<li>
									<span class="m-name">
										母亲手机：
									</span>
									<input type="text" class="data-field" id="mother_mobile" />
								</li>
							</ul>
						</div>
						<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
							<button id="btnSearch" style="margin-left: 0;margin-top: 10px;">搜索</button>
						</div>
						<div class="table-cell">
							<table border="1" cellspacing="0" cellpadding="0">
							  <tr><th>序号</th><th>姓名</th><th>性别</th><th>年级</th><th>所在学校</th><th>手机号码</th><th>父名</th><th>父手机</th><th>母名</th><th>母手机</th><th>班别</th><th>操作</th></tr>
								<?php foreach ( $items as $v ):?>
								<tr>
									<td><?php echo $v['id']?></td>
									<td><?php echo $v['realname']?></td>
									<td>
										<?php 
										if ( $v['sex'] == 1 ) {
											echo '男';
										} elseif ( $v['sex'] == 0 ) {
											echo '女';
										} else {
											echo '&nbsp;';
										}					
										?>
									</td>
									<td><?php echo $v['grade']?></td>
									<td><?php echo $v['school']?></td>
									<td><?php echo $v['mobile']?></td>
									<td><?php echo $v['father_name']?></td>
									<td><?php echo $v['father_mobile']?></td>
									<td><?php echo $v['mother_name']?></td>
									<td><?php echo $v['mother_mobile']?></td>
									<td><?php echo $v['class']?></td>
									<td>
										<a href="<?php echo URL::base(NULL, TRUE)?>guest/audit/?id=<?php echo $v['id']?>">审核</a>
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
		var url = '<?php echo URL::base(NULL, TRUE)?>guest/list/?z=z';
		$('.data-field').each(function(){
			var key = $(this).attr('id');
			var val  = $(this).val();
			url += '&' + key + '=' + val;
		});
		
		window.location.href = url;
	});
});
</script>