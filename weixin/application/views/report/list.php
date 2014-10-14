<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>学生成绩</title>
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
			<h1 class="mui-title"><?php echo $realname?>同学成绩如下</h1>
		</header>
		<div class="mui-content">
			<div class="comments">
				<ul>
					<?php foreach ( $items as $v ) : ?>
					<li>
						<div class="editer"><span>发布日期：<?php echo $v['modified_at']?></span></div>
						<div class="comm-con">
							<!--
							<p>语文：90分（2014-09-02测试）</p>
							<p>数学：90分（2014-09-02测试）</p>
							<p>英语：90分（2014-09-02测试）</p>
							<p>其他：90分（2014-09-02测试）</p>
							-->
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


