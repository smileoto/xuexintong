<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>学生验证</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<script src="<?PHP echo URL::base()?>js/mui.min.js"></script>
		<style type="text/css">
			.address-box label~select {
				width: 21%;
			}
			.mui-input-row label {
				width: 35%;
				height: 40px;
				padding: 0px 15px;
				line-height: 43px;
			}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title">验证</h1> 
		</header>
		<div class="mui-content">
			<div class="mui-content-padded" style="margin: 10px;">
				<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>student/auth/">
					<div class="mui-input-row">
						<label>验证码</label>
						<input type="text" placeholder="请输入验证码" name="code" id="code" value="">
					</div>
				</form>
				<div class="mui-input-row" style="margin: 10px 5px;">
					<button class="mui-btn mui-btn-block" id="btnSubmit">提交</button>
				</div>
			</div>
		</div>


		<style type="text/css">
			h5 {
				margin: 5px 7px;
			}
		</style>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
//$('.datepicker').picker.get('start')

$(function () {
	var parseClick = false;
	$('#btnSubmit').click(function () {
		if ( parseClick ) {
			return;
		}
		parseClick = true;
		
		var url = '<?php echo URL::base(NULL, TRUE)?>student/auth/';
		$.post(url, {code:$('#code').val()}, function (jsonStr) {
			parseClick = false;
			
			var resultObj = $.parseJSON(jsonStr);
			if ( resultObj.ret != 0 ) {
				alert(resultObj.msg);
				return false;
			}
			
			alert('验证成功');
		});
	});
});
</script>