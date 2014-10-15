<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>我反馈过的信息</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>

	<body>
		<div class="mui-content">
			<div id="segmentedControl" class="mui-segmented-control" style="margin-top: 10px;">
				<a class="mui-control-item mui-active">
					我反馈过的信息
				</a>
				<a href="<?php echo URL::base(NULL, TRUE),'feedback/add/'?>" class="mui-control-item">
					我要反馈
				</a>
			</div>
			<ul class="mui-table-view " style="margin-top: 10px;">
				<?php foreach ( $items as $v ) : ?>
				<li class="mui-table-view-cell">
					<a href="<?php echo URL::base(NULL, TRUE),'feedback/detail/?id=',$v['id']?>">
						<?php echo $v['title']?>
						<p><?php echo $v['created_at']?></p>
						<?php if ( $v['reply'] ) : ?>
						<span class="mui-badge mui-badge-success">已答复</span>
						<?php else : ?>
						<span class="mui-badge mui-badge-red">未答复</span>
						<?php endif ?>
					</a>
				</li>
				<?php endforeach?>
			</ul>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
