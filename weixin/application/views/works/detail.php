<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>作品详情</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>
	<body class="bg-white">
		<header class="mui-bar mui-bar-nav bg-color">
			<a onclick="history.back()" style="color: #fff;" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<a class="mui-pull-right" style="color: #fff;margin-top: 10px;">
				<span class="mui-badge mui-badge-red">阅读数 <?php echo $item['read_count']?></span>
			</a>
		</header>
		<div class="mui-content">
			<div class="content-title" >
				<h4 style="text-align: center;"><?php echo $item['title']?></h4>
				<p> 
					<span class="addtime">时间：<?php echo $item['modified_at']?></span>
					<span class="addtime">作者：<?php echo $item['student']?></span>
					<span class="addtime"><?php echo $item['school']?></span>
					<span class="addtime"><?php echo $item['grade']?></span>
				</p>
			</div>
			<div class="content-box">
				<?php echo $item['content']?>
			</div>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
