<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>学生作品</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
	</head>
	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title">学生作品</h1>
		</header>
		<div class="mui-content">
			<div class="mui-slider">
		        <div class="mui-slider-group mui-slider-loop">
		            <div class="mui-slider-item" style="display: none;">
		            </div>
		            <div class="mui-slider-item">
		                <a href="#">
		                    <img src="images/shuijiao.jpg">
		                    <p class="mui-slider-title">想要一间这样的木屋，静静的喝咖啡</p>
		                </a>
		            </div>
		        </div>
    		</div>
			<?php if ( count($items) > 0 ) : ?>
			<div class="mui-card">
				<ul id="list-box" class="mui-table-view">
					<li class="mui-table-view-cell mui-hidden">cared
						<div id="M_Toggle" class="mui-switch mui-active">
							<div class="mui-switch-handle"></div>
						</div>
					</li>
					<?php foreach ( $items as $v ) : ?>
					<li class="mui-table-view-cell mui-media">
						<a href="<?php echo URL::base(NULL, TRUE),'works/detail/?id=',$v['id']?>">
							<div class="mui-media-body mui-ellipsis">
								【<?php echo $v['class']?>】
								<?php echo $v['student']?>同学的作品
								《<?php echo $v['title']?>》
								<p class='mui-ellipsis'><?php echo $v['remark']?></p>
							</div>
						</a>
					</li>
					<?php endforeach?>
				</ul>
			</div>
			<?php endif?>
		</div>
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
