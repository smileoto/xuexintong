<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>机构管理</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/index.css" />
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
					<h2>帐号信息</h2>
				</div>
			<div class="content-inner">
				<ul>
					<li>
						<div class="con-name">
							机构名称：
						</div>
						<div class="con-info">
							<?php echo $agency['realname']?>
						</div>
					</li>
					<li>
						<div class="con-name">
							用户名：
						</div>
						<div class="con-info">
							<?php echo $agency['username']?>
						</div>
					</li>
					<li>
						<div class="con-name">
							公众帐号名称：
						</div>
						<div class="con-info">
							<?php echo $agency['viewname']?>
						</div>
					</li>
					<li>
						<div class="con-name">
							微信号：
						</div>
						<div class="con-info">
							<?php echo $agency['weixin']?>
						</div>
					</li>
					<li>
						<div class="con-name">
							微信原始帐号：
						</div>
						<div class="con-info">
							<?php echo $agency['weixin_id']?>
						</div>
					</li>
					<li>
						<div class="con-name">
							申请邮箱：
						</div>
						<div class="con-info">
							<?php echo $agency['email']?>
						</div>
					</li>
					<li>
						<div class="con-name">
							关注人数：
						</div>
						<div class="con-info">
							<?php echo $agency['care_num']?>人
						</div>
					</li>
				</ul>
			</div>
			<div class="content-title" style="margin-top: 30px;">
					<h2>资料修改</h2>
			</div>
			
			<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>agency/save/">
			
			<div class="content-inner">
				<ul>
					<li>
						<div class="con-name">
							所在地区：
						</div>
						<div class="con-info">
							<select class="select" id="s1">
								<option value="">请选择省份</option>
							</select>
							<select class="select" id="s2">
								<option value="">请选择城市</option>
							</select>
							<select class="select" id="s3">
								<option value="">请选择地区</option>
							</select>
							<input type="hidden" name="province" id="province" value="<?php echo $agency["province"]?>" />
							<input type="hidden" name="city"     id="city"     value="<?php echo $agency["city"]?>" />
							<input type="hidden" name="area"     id="area"     value="<?php echo $agency["area"]?>" />
						</div>
					</li>
					<li>
						<div class="con-name">
							详细地址：
						</div>
						<div class="con-info">
							<input type="text" name="addr" id="addr" value="<?php echo $agency['addr']?>" />		
						</div>
					</li>
					<li>
						<div class="con-name">
							联系人：
						</div>
						<div class="con-info">
							<input type="text" name="contact" id="contact" value="<?php echo $agency['contact']?>" />
						</div>
					</li>
					<li>
						<div class="con-name">
							手机：
						</div>
						<div class="con-info">
							<input type="text" name="mobile" id="mobile" value="<?php echo $agency['mobile']?>" />
						</div>
					</li>
					<li>
						<div class="con-name">
							邮箱：
						</div>
						<div class="con-info">
							<input type="text" name="email" id="email" value="<?php echo $agency['email']?>" />
						</div>
					</li>
				</ul>
				<div class="btn-box">
					<button id="btnSubmit">确定修改</button>
				</div>
			</div>
			</div>
			
			</form>
			
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
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/geo.js"></script>
<script type="text/javascript" charset="utf-8">

$(function(){
	var s1 = '<?php echo $agency["province"]?>';
	var s2 = '<?php echo $agency["city"]?>';
	var s3 = '<?php echo $agency["area"]?>';
	setup();preselect_ex(s1,s2,s3);
	
	
	$('#btnSubmit').click(function () {
		$('#area').val($('#s3').get(0).selectedIndex);	
		$('#data-form').submit();
	});
});
</script>