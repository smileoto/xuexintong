<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>简介</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>
	<body class="bg-white">
		<div class="mui-content" id="mui-content">
			<div id="segmentedControl" class="mui-segmented-control" style="margin: 0 auto;width: 96%;margin-top: 10px;">
				<a class="mui-control-item mui-active">
					简介
				</a>
				<a href="<?PHP echo URL::base(NULL, TRUE)?>agency/show/" class="mui-control-item">
					展示
				</a>
				<a href="<?PHP echo URL::base(NULL, TRUE)?>agency/contact/" class="mui-control-item">
					联系
				</a>
				</div>
			<div class="content-box" style="margin-top: 10px;">
				<?php echo $content?>
			</div>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/setheight.js" type="text/javascript" charset="utf-8"></script>