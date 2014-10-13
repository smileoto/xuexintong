<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>机构动态</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<script src="<?PHP echo URL::base()?>js/mui.min.js"></script>
		<script>
			mui.init();
		</script>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title">机构动态</h1>
		</header>
		<div class="mui-content">
			<div id="slider" class="mui-slider">
				<div class="mui-slider-group mui-slider-loop">
					<?php foreach ( $images as $v ) : ?>
					<div class="mui-slider-item">
						<a href="<?php echo URL::base(NULL, TRUE),'news/detail/?id=',$v['id']?>">
							<img src="<?php echo $v['img']?>">
							<p class="mui-slider-title"><?php echo $v['title']?></p>
						</a>
					</div>
					<?php endforeach?>
				</div>
				<div class="mui-slider-indicator mui-text-right">
					<?php 
					$cnt = count($images);
					if ( $cnt ) {
						echo '<div class="mui-indicator mui-active"></div>';
						for ( $i = 1; $i < $cnt; $i++ ) {
							echo '<div class="mui-indicator"></div>';
						}
					}
					?>
				</div>
			</div>
			<div class="mui-card">
				<ul class="mui-table-view">
					<li class="mui-table-view-cell mui-hidden">cared
						<div id="M_Toggle" class="mui-switch mui-active">
							<div class="mui-switch-handle"></div>
						</div>
					</li>
					<?php foreach ( $items as $v ) : ?>
					<li class="mui-table-view-cell mui-media">
						<a href="<?php echo URL::base(NULL, TRUE),'news/detail/?id=',$v['id']?>">
							<?php if ( $v['img'] ) : ?>
							<img class="mui-media-object mui-pull-left" src="<?php echo $v['img']?>">
							<?php endif?>
							<div class="mui-media-body mui-ellipsis">
								<?php echo $v['title']?>
								<p class='mui-ellipsis'><?php echo $v['remark']?></p>
								<div class="list-info">
									<div class="list-left"><span class=" mui-icon mui-icon-edit"></span><?php echo $v['read_count']?></div>
									<div class="list-right"><span class=" mui-icon mui-icon-chat"></span> 1小时前</div>
								</div>
							</div>
						</a>
					</li>
					<?php endforeach?>
				</ul>
			</div>
		</div>
		<script>
			var slider = mui("#slider");
		</script>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	var scrollEnd=true;
	$(window).scroll(function(){
	　　var scrollTop = $(this).scrollTop();
	　　var scrollHeight = $(document).height();
	　　var windowHeight = $(this).height();
	　　if(scrollTop + windowHeight == scrollHeight){
		//页面滑动到底部时加载更多
		if(scrollEnd){
			$('#list-box').append('<li class="loading" style="text-align: center;color: #999;">数据正在加载中...</li>');
			scrollEnd=false;
			setTimeout(function(){
				$('.loading').hide();
				var s='<li class="mui-table-view-cell mui-media">我是新加载的文章</li>';
			$('#list-box').append(s);
			scrollEnd=true;
			},1000)
		}
	　　}
	});
});
</script>
