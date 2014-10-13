<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>递交资料成功</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/default.css"/>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/default.date.css"/>
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
			<h1 class="mui-title">温馨提示</h1> 
		</header>
		<div class="mui-content">
			<div style="text-align:center">
					<img style="width:85%" src="<?PHP echo URL::base()?>images/regsuccess.jpg" alt="" />
			</div>
			<div class="mui-input-row" style="margin: 30px 5px; text-align:center; color:#F00">
            恭喜你！资料已经递交给本机构，本机构将尽快审核，并将审核结果第一时间通知您！
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
