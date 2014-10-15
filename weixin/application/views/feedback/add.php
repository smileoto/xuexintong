<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>我要反馈</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>

	<body>
		<div class="mui-content" style="padding-bottom: 60px;">
			<div id="segmentedControl" class="mui-segmented-control" style="margin-top: 10px;">
				<a href="<?php echo URL::base(NULL, TRUE),'feedback/to_agency/'?>" class="mui-control-item ">
					我反馈过的信息
				</a>
				<a class="mui-control-item mui-active">
					我要反馈
				</a>
			</div>
			<div class="feed-title" style="text-align: center;margin-top: 10px;color: #8F8F94;">
				您提交信息后，我们一定会及时回复您。
			</div>
			
			<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>feedback/save/">
			<div class="mui-input-row" style="margin: 10px 5px;">
                <input type="text" class="mui-input-clear" placeholder="标题" id="title" name="title">
            </div>
            <div class="mui-input-row" style="margin: 10px 5px;">
				<textarea rows="5" placeholder="内容" id="content" name="content"></textarea>
			</div>
			</form>
			<div class="sign-box">
				<button id="btnSubmit" class="mui-btn mui-btn-success mui-btn-block">提交反馈</button>
			</div>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
	});
});
</script>
