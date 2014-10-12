<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>课程介绍</title>
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
		
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/jquery.uploadify.min.js"></script>
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
								<a class="active">添加图片</a>
							</div>
							
							<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>show/save/">
							<input type="hidden" name="url" value="" id="img_url" />
							<ul>
								<li>
									<div class="con-name">
										标题：
									</div>
									<div class="con-info">
										<input type="text" name="title" id="title"/>
									</div>
								</li>
							</ul>
							</form>
							
							<div class="input-box">
								<form>
								<div id="queue"></div>
								<input id="file_upload" name="file_upload" type="file" multiple="true">
								</form>
							</div>
							
							<div class="input-box" id="img_container">
							</div>
							
							<div class="btn-box">
								<button style="margin-left: 10%;margin-top: 50px;float: left;" id="btnSubmit">确定提交</button>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</body>

</html>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {
		document.getElementById("sidebar").style.minHeight = document.getElementById("main").clientHeight - document.getElementById("header").clientHeight - 3 + 'px';
	}
</script>
<script type="text/javascript" charset="utf-8">
$(function(){	
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
	});
	
	<?php $timestamp = time();?>
	var upload_url = '<?php echo URL::base("http", false),$upload_dir?>';
	$('#file_upload').uploadify({
		'formData'     : {
			'timestamp' : '<?php echo $timestamp;?>',
			'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
		},
		'swf'      : '<?PHP echo URL::base()?>swf/uploadify.swf',
		'uploader' : '/uploadify.php;jsessionid=<?php echo $session_id?>',
		'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
            alert(errorCode);
            alert(errorMsg);
        },
        'onUploadSuccess' : function(file, data, response) {
            var img = upload_url + '/' + file.name;
            $('#img_container').html('<a href="' + img + '"><img src="' + img + '" width="150"></a>');
            $('#img_url').val(img);
        }
	});
});
</script>