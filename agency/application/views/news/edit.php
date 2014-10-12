<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>编辑动态</title>
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
								<a href="<?php echo URL::base(NULL, TRUE)?>news/list/" >机构动态</a>
								<a class="active" href="#">编辑动态</a>
							</div>
							
							<div class="input-box">
								<form>
								<div id="queue"></div>
								<input id="file_upload" name="file_upload" type="file" multiple="true">
								</form>
							</div>
							
							<div class="input-box" id="img_container">
							<?php 
							if ( $item['img'] ) {
								echo '<img src="',$item['img'],'" width="150">';
							}
							?>
							</div>
							
							<div class="input-box">
								<br/><br/><br/><br/>
							</div>
							
							<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>news/save/">
							<input type="hidden" name="id" value="<?php echo $item['id']?>" >
							<input type="hidden" name="img"  id="img_url" value="<?php echo $item['img']?>" />
							<div class="input-box">
								<span>标题：</span>
								<input type="text" name="title" id="title" value="<?php echo $item['title']?>" />
								<i>(字数必须在16个字符内)</i>
							</div>
							<div class="input-box">
								<span>来源：</span>
								<input type="text" name="from"  id="from"  value="<?php echo $item['src']?>" />
							</div>
							<div class="table-cell">
								<textarea name="content" class="<?php echo $xheditor_config?>" name="content" id="content"><?php echo $item['content']?></textarea>
							</div>
							<div class="btn-box">
								<button id="btnSubmit">确定提交</button>
							</div>
							</form>
							
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
            $('#img_container').html('<img src="' + img + '" width="150">');
            $('#img_url').val(img);
        }
	});
});
</script>