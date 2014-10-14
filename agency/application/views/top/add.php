<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>菁英榜</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/ago.css" />
        <link rel="stylesheet" href="<?PHP echo URL::base()?>css/jquery.windows.css" media="all">
		<!--[if gte IE 9]>
		  <style type="text/css">
		    .gradient {
		       filter: none;
		    }
		  </style>
		<![endif]-->
        <script type="text/javascript" src="<?php echo URL::base()?>js/jquery-1.4.4.min.js"></script>
        <script src="<?php echo URL::base()?>js/jquery.uploadify.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/uploadify.css">
	</head>

	<body>
		<div class="all">
			<div class="main" id="main" style="float:left">
				<div class="header" id="header">
					<?php echo $html_head_content?>
				</div>
				<div class="content">
					<div class="sidebar" id="sidebar">
						<?php echo $html_left_content?>
					</div>
					<div class="content-box">
						<div class="content-inner" style="float:left">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>top/list/">菁英榜</a>
								<a class="active" >添加榜单</a>
							</div>
							
							<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>top/save/">
								<input type="hidden" id="img_url"    name="avatar"     value="">
								<input type="hidden" id="student_id" name="student_id" value="">
								<ul>
                            		<li>
                                    	<div class="con-name">
										评榜时间：
										</div>
										<input type="date" name="begin" /> 
										&nbsp;&nbsp;至&nbsp;&nbsp;
										<input type="date" name="end" />
                                    </li>
                            		<li>
                                    	<div class="con-name">
											学生姓名：
										</div>
										<div class="con-info">
											<input type="text" size="10" maxlength="10" name="realname" id="realname" /> 
											<a href="#" onclick="select_student()">选择学生</a>
										</div>
                                    </li>
                                    <li style="height:30xp; line-height:30px; height:30px">学生头像：</li>
                                    <li style="background:#dddddd; width:500px; padding:10px;border:1px dashed #a5a5a5; margin-top:-30px; margin-left:80px;">
										<form id="form_file_upload">
											<div id="queue"></div>
											<input id="file_upload" name="file_upload" type="file" multiple="true">
										</form>
										<div id="img_container" style="float:left;width:100%"></div>
                                    </li>
                                    <li>
                                    	<div class="con-name">
											上榜理由：
										</div>
										<div class="con-info">
											<textarea rows="9" style="width: 500px;" name="reason"></textarea>
                                        </div>
                                    </li>
								</ul>
							
							</form>
                            
							<div class="btn-box" style="float:left">
								<button style="margin-left: 70px;margin-top: 10px;" id="btnSubmit">确认提交</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="theme-popover" style="font-size:0.8em;" id="cntSelector"></div>
		<div class="theme-popover-mask"></div> 
        
		<script type="text/javascript" charset="utf-8">
		<?php $timestamp = time();?>
		$(function() {
			var upload_dir = '<?php echo $upload_dir?>';
			
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
				},
				'swf'      : '<?PHP echo URL::base()?>swf/uploadify.swf',
				'uploader' : '<?PHP echo URL::base("http",false)?>uploadify.php;jsessionid=<?php echo $session_id?>',
				'onUploadSuccess' : function(file, data, response) {
					var img = upload_dir + '/' + file.name;
					$('#img_container').html('<img src="' + img + '" width="150">');
					$('#img_url').val(img);
				}
			});
		
			$('#btnSubmit').click(function () {
				$('#form_file_upload').remove();
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
<script type="text/javascript" charset="utf-8">
function select_student() {	
	var url = '<?php echo URL::base(NULL, TRUE)?>student/select/?size=4';
	$.get(url, {}, function (html) {
		$('#cntSelector').html(html);
		$('.theme-popover-mask').fadeIn(100);
		$('.theme-popover').slideDown(200);
	});
}

function select_for_audit(student_id) {
	var url = '<?php echo URL::base(NULL, TRUE)?>student/search/';
	$.post(url, {student_id:student_id}, function (jsonStr) {
		var students = jQuery.parseJSON(jsonStr);
		$.each(students, function (k, v) {	
			$('#student_id').val(v.id);
			$('#realname').val(v.realname);
		});
		$('#cntSelector').hide();
	});
}
</script>