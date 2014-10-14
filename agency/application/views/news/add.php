<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>添加动态</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
		<!--[if gte IE 9]>
		  <style type="text/css">
		    .gradient {
		       filter: none;
		    }
		  </style>
		<![endif]-->
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/xheditor.js"></script>
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/xheditor_lang/zh-cn.js"></script>

		<script src="<?PHP echo URL::base()?>js/jquery.uploadify.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/uploadify.css">
	</head>

	<body>
		<div class="all">
			<div class="main" id="main">
				<div class="header" id="header">
					<?php echo $html_head_content?>
				</div>
				<div class="content">
					<div class="sidebar" id="sidebar">
						<?php echo $html_left_content?>
					</div>
					<div class="content-box">
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>news/list/" >机构动态</a>
								<a class="active" href="#">添加动态</a>
							</div>
							
							<ul>
								<li>
									<div class="con-name">
										标&nbsp&nbsp题：
									</div>
									<div class="con-info">
										<input type="text" id="show_title" />
										<i>(字数必须在16个字符内)</i>
									</div>
								</li>
								<li>
									<div class="con-name">
										发布者：
									</div>
									<div class="con-info">
										<input type="text" id="show_from" />
									</div>
								</li>
								<li style="height:30xp; line-height:30px; height:30px">图片上传：</li>
								<li style="background:#dddddd; width:500px; padding:10px;border:1px dashed #a5a5a5; margin-top:-30px; margin-left:80px;">

									<form>
										<div id="queue"></div>
										<input id="file_upload" name="file_upload" type="file" multiple="true">
									</form>
									<div id="img_container" style="float:left;width:100%"></div>
								</li>
								
								<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>news/save/">
								<input type="hidden" name="img"   id="img_url" value="" />
								<input type="hidden" name="title" id="title"  value="" />
								<input type="hidden" name="from"  id="from"   value="" />
								
								<li>
									<div class="con-name">
										轮播图片：
									</div>
									<div class="con-info">
										<input name="show_type" type="checkbox" value="1" style="width:20px; height:20px; margin-top:5px; line-height: 20px; float: left; display: block;">
									</div>
								</li>
								<li>
									<div class="table-cell">
									<textarea name="content" class="<?php echo $xheditor_config?>"></textarea>
									</div>
								</li>
							
								</form>
							
								<li>
									<div class="btn-box">
										<button id="btnSubmit">确定提交</button>
									</div>
								</li>
							</ul>
							
						</div>
					</div>
				</div>
			</div>
		</div>
        <script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			var upload_dir = '<?php echo $upload_dir?>';
			
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
				},
				'swf'      : '<?PHP echo URL::base()?>swf/uploadify.swf',
				'uploader' : '<?PHP echo URL::base()?>uploadify.php?sid=<?php echo $session_id?>',
				'onUploadSuccess' : function(file, data, response) {
					var img = upload_dir + '/' + file.name;
					$('#img_container').html('<img src="' + img + '" width="150">');
					$('#img_url').val(img);
				}
			});
		
			$('#btnSubmit').click(function () {
				$('#title').val($('#show_title').val());
				$('#from').val($('#show_from').val());
				$('#data-form').submit();
			});
		});
		</script>
	</body>

</html>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {
		document.getElementById("sidebar").style.minHeight = document.getElementById("main").clientHeight - document.getElementById("header").clientHeight - 3 + 'px';
	}
</script>