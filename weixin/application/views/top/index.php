<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>菁英榜</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>
	<body class="bg-white">
		<div class="mui-content">
			<div class="elite-inner">
				<div class="elite-title">
				<div class="title-img">
					<img src="<?PHP echo URL::base()?>images/jingying.jpg" alt="" />
				</div>
				<p><?php echo $item['begin_t'],' 到 ',$item['end_t']?></p>
			</div>
			<div class="mui-content-padded">
				<ul class="mui-pager">
					<li class="mui-previous">
						<a href="<?php echo URL::base(NULL, TRUE),'top?cur=',$page + 1?>">
							<span class="mui-icon mui-icon-left-nav"></span>
							上一周榜单
						</a>
					</li>
					<li class="mui-next">
						<a href="<?php echo URL::base(NULL, TRUE),'top?cur=',$page - 1?>">
							下一周榜单 <span class="mui-icon mui-icon-right-nav"></span>
						</a>
					</li>
				</ul>
			</div>
			<div class="elite-list">
				<?php foreach ( $students as $v ) : ?>
				<div class="student-box">
					<div class="stimg-box">
						<img src="<?php echo $v['avatar']?>"/>
						<p class="star"></p>
					</div>
					<div class="stcon-box">
						<ul>
							<li>
								<span class="st-title">姓名：</span><?php echo $v['realname']?>
							</li>
							<li>
								<span class="st-title">性别：</span><?php echo $v['sex'] ? '男' : '女'?>
							</li>
							<li>
								<span class="st-title">所在学校：</span><?php echo $v['school']?>
							</li>
							<li>
								<span class="st-title">所在年级：</span><?php echo $v['grade']?>
							</li>
							<li>
								<span class="st-title">机构班别：</span><?php //echo $v['class']?>
							</li>
							<li>
								<span class="st-title">上榜理由：</span>
							</li>
							<li>
								<?php echo $v['reason']?>
							</li>
						</ul>
					</div>
				</div>
				<?php endforeach?>
			</div>
			</div>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>