<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>课程类别</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
		<style type="text/css">
		  .selectjigou{
		  	width: 100%;
		  	margin-top: 20px;
		  	float: left;
		  	padding: 0 8%;
		  }
		  .selectjigou .left{
		  	width: 52%;
		  	height: 40px;
		  	line-height: 40px;
		  	float: left;
		  	font-size: 0.8em;
		  	background-color: #007AFF;
		  	border-radius: 5px;
		  	text-align: center;
		  	overflow: hidden;
		  	color: #fff;
		  	border: 1px solid #007AFF !important;
		  	margin-top: 1px;
		  }
		  .selectjigou select{
		  	width: 50%;
		  	height: 40px;
		  	margin-left: -2%;
		  	float: left;
		  	border: 1px solid #007AFF !important;
		  }
		  .course .course-box:first-child{
		  	margin-top: 20px;
		  }
		  .course .course-box:nth-child(2){
		  	margin-top: 20px;
		  }
		</style>
	</head>
	<body class="bg-white">
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title">班级分类</h1>
		</header>
		<div class="mui-content">
			<div class="selectjigou">
				<div class="left">请选择所属分机构：</div>
				<select name="entity" id="entity">
					<option value=""></option>
					<?php foreach ( $entities as $v ) : ?>
					<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
					<?php endforeach?>
				</select>
			</div>
			<div class="course">
				<?php foreach ( $items as $v ) : ?>
				<div class="course-box">
					<a href="<?php echo URL::base(NULL, TRUE),'course/list/?class_id=',$v['id']?>">
						<?php echo $v['name']?>
					</a>
				</div>
				<?php endforeach?>
			</div>
			<div class="course-con">
				<?php echo isset($notify) ? $notify : '' ?>
			</div>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(function () {
	$('#entity').change(function () {
		var id = $(this).val();
		window.location.href = window.location.href + '?entity_id=' + id;
	});
});
</script>
