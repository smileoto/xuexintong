<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>密码修改</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/index.css" />
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
				<div class="content-title">
					<h2>密码修改</h2>
				</div>
			<div class="content-inner" style="padding: 5% 3%;">
				<ul>
					<li>
						<div class="con-name">
							新密码：
						</div>
						<div class="con-info">
							<input type="password" name="passwd"   class="data-field" id="pswd1" value="" />
						</div>
					</li>
					<li>
						<div class="con-name">
							密码确认：
						</div>
						<div class="con-info">
							<input type="password" name="repasswd" class="data-field" id="pswd2" value="" />
						</div>
					</li>
				</ul>
				<div class="btn-box">
					<button id="btnChPswd">确定修改</button>
				</div>
			</div>
			</div>
		</div>
		</div>
		</div>
	</body>
</html>
<script type="text/javascript" charset="utf-8">
  window.onload=function(){
  	document.getElementById("sidebar").style.minHeight=document.getElementById("main").clientHeight-document.getElementById("header").clientHeight-3+'px';
  }
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery.md5.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#btnChPswd').click(function () {
		var pswd1 = $('#pswd1').val();
		var pswd2 = $('#pswd2').val();
		if ( pswd1 != pswd2 ) {
			alert('两次输入不一致，请重新输入！');
			return false;
		}
		
		var url = '<?php echo URL::base(NULL, TRUE)?>login/pswd/';
		$.post(url, {pswd1:$.md5(pswd1), pswd2:$.md5(pswd2)}, function (jsonStr) {
			var resultObj = jQuery.parseJSON(jsonStr);
			if ( resultObj.ret != 0 ) {
				alert(resultObj.msg);
				return false;
			}
			
			$('#pswd1').val('');
			$('#pswd2').val('');
			alert('密码修改成功');
		});
	});
});
</script>