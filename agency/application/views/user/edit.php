<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>用户权限</title>
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
								<a class="active">人员权限</a>
							</div>
							<div class="accountSettings-box">
							
							<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>user/save/">
							<input type="hidden" name="id" value="<?php echo $item['id']?>" />
							
							<ul>
								<li style="width:100%">
									<span class="m-name">
										用户名：
									</span>
									<input type="text" style="width: 477px;" name="username" id="username" value="<?php echo $item['username']?>" />
								</li>
								<li style="width:100%">
									<span class="m-name">
										名称：
									</span>
									<input type="text" style="width: 477px;" name="realname" id="realname" value="<?php echo $item['realname']?>" />
								</li>
								<li style="width:100%">
									<span class="m-name">
										说明：
									</span>
									<input type="text" style="width: 477px;" name="remark" id="remark" value="<?php echo $item['remark']?>" />
								</li>
								<li style="width:590px;line-height: 35px;">
									<span class="m-name">
										权限：
									</span>
									
									<div style="width: 485px;float: left;background: #fff;">
									
										<?php 
										$first = true;
										foreach ($actions as $k => $v) {
											if ( is_string($v)) {
												if ( $first ) {
													$first = false;
													echo '<div class="checkbox-box" style="width: 485px;float: left;">';
												} else {
													echo '</div><div class="checkbox-box" style="width: 485px;float: left;">';
												}
												echo '<span class="m-name" style="background: none;border: 0;">';
												echo $v,'：';
												echo '</span>';
												continue;
											}
											
											if ( !$v['show'] ) {
												continue;
											}
											
											$ex = '';
											if ( isset($user_rights[$k]) and $user_rights[$k] ) {
												$ex = 'checked="checked"';
											}
											
											echo '<input type="checkbox" style="width: 15px;margin-left: 10px;" name="user_rights[]" value="',$k,'" ',$ex,' />';
											echo '<span style="float: left;margin-left: 5px;">',$v['desc'],'</span>';
											
										}
										echo '</div>';
										?>
									
									</div>
								</li>
								<li style="width:100%">
									<span class="m-name">
										密码：
									</span>
									<input type="password" style="width: 477px;" name="password" id="password" />
								</li>
								<li style="width:100%">
									<span class="m-name">
										密码确认：
									</span>
									<input type="password" style="width: 477px;" id="confirm" />
								</li>
							</ul>
							
							</form>
							
						</div>
						<div class="btn-box" style="float: left;height: 50px;"  >
								<button id="btnSubmit" style="margin-top: 10px;margin-left: 100px;">修改</button>
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
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	/*
	$('input[type=checkbox]').each(function(){
		$(this).attr('checked', true);
	});
	*/
	$('input[type=checkbox]').click(function () {
		if ( $(this).attr('checked') ) {
			$(this).attr('checked', false);
		} else {
			$(this).attr('checked', true);
		}
	});
	
	$('#btnSubmit').click(function(){
		var username = $.trim($('#username').val());
		if ( username == '' ) {
			alert('用户名不能为空');
			return;
		}
	
		var p1 = $('#password').val();
		var p2 = $('#confirm').val();
		if ( p1 != p2 ) {
			alert('两次密码输入不符合');
			return false;
		}
		
		$('#data-form').submit();
	});
});
</script>
