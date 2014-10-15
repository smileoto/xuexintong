<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>反馈内容</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>
	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<a onclick="history.back()" style="color: #fff;" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		</header>
		<div class="mui-content">
			<div class="comments">
				<ul>
					<li>
						<div class="comm-con">
							<span><?php echo $item['realname']?></span>
							<p><?php echo $item['content']?></p>
						</div>
						<p></p>
					</li>
					<?php foreach ( $reply_list as $v ) : ?>
					<li>
						<div class="editer">
							<span><?php echo $v['teacher']?></span>
							<p><?php echo $v['created_at']?></p>
						</div>
						<div class="comm-con">
							<?php echo $v['content']?>
						</div>
					</li>
					<?php endforeach?>
				</ul>
			</div>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>


