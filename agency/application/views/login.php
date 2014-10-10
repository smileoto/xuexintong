<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>管理员登录</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css"/>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/admin_login.css"/>
	</head>
	<body>
		<div class="header">
			<div class="headCon">
				<strong>学信通</strong>
			</div>
		</div>
		<div class="content" id="content">
			<div class="login">
				<div class="title">系统登录</div>
				<div class="logininner">
					<ul>
						<li>
							<span class="name">企业帐号</span><input type="text" id="agency_sid" />
						</li>
						<li>
							<span class="name">用户名</span><input type="text" id="username" />
						</li>
						<li>
							<span class="name">密&nbsp;&nbsp;&nbsp;&nbsp;码</span><input type="password" id="password" />
						</li>
					</ul>
					<a href="#"><span style="line-height: 50px; float: right;">忘记密码了吗？</span></a>
				</div>
				<div class="lbutton">
					<a href="#" id="btnLogin">登录</a>
				</div>
			</div>
			<div class="footer" align="center">Copyright&copy;2006-2014 学信通</div>
		</div>
	</body>
</html>
<script type="text/javascript" charset="utf-8">
  window.onload=function(){
  	document.getElementById("content").style.height=document.body.clientHeight+'px';
  }
</script>
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery.md5.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	document.getElementById("content").style.height=document.body.clientHeight+'px';
	
	$('#btnLogin').click(function(){
		var agency_sid = $('#agency_sid').val();
		var username   = $('#username').val();
		var password   = $('#password').val();
		
		password = $.md5(password);
		var url = '<?php echo URL::base(NULL, TRUE)?>session/start/';
		$.post(url, {agency_sid:agency_sid,username:username, password:password}, function(data){
			var json = eval( '(' + data + ')' );
			if ( json.ret != 0 ) {
				alert(json.msg);
			} else {
				window.location.href = json.url;
			}
		});
	});
});
</script>
