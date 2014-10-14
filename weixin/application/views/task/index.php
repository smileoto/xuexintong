<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>作业任务</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>
	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title">作业任务</h1>
		</header>
		<div class="mui-content">
			<div class="elite-inner">
				<div class="elite-title">
					<div class="works-title-info">
						学校：<span><?php echo $item['school']?></span>
						年级：<span><?php echo $item['grade']?></span>
					</div>
				<?php $weekarray = array("日","一","二","三","四","五","六"); ?>
				<p>今天是：<?php echo date('Y年m月d日'),' ','星期'.$weekarray[date('w')]; ?></p>
			</div>
			<div class="mui-content-padded">
				<ul class="mui-pager">
					<li class="mui-previous">
						<a href="<?php echo URL::base(NULL, TRUE),'homework/index/?cur=',$cur - 1?>">
							<span class="mui-icon mui-icon-left-nav"></span>前一天作业
						</a>
					</li>
					<li class="mui-next">
						<a href="<?php echo URL::base(NULL, TRUE),'homework/index/?cur=',$cur + 1?>">
							下一天作业 <span class="mui-icon mui-icon-right-nav"></span>
						</a>
					</li>
				</ul>
			</div>
			<?php $today = date('Ymd') ?>
			<?php foreach ( $list as $item ) :?>
			<div class="today-work">
				<div class="work-title">
					<?php 
					if ( empty($item) ) {
						echo $item['class'],' ',$date_s,' 无作业';
					} else if ( $item['date_t'] == $today ) {
						echo $item['class'],' 今日作业';
					} else {
						echo $item['class'],' ',$date_s, '作业';
					}
					?>
				</div>
				<div class="content-works">
					<?php echo $item['content']; ?>
				</div>
			</div>
			<?php endforeach;?>
			</div>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>

