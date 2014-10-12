<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>发送验证码</title>
		<style type="text/css" media="screen" >@import url('<?PHP echo URL::base()?>css/base.css');</style>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
		<!--[if gte IE 9]>
		  <style type="text/css">
		    .gradient {
		       filter: none;
		    }
		  </style>
		<![endif]-->
		
		<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
	</head>

	<body>
		<div class="all">
			<div class="main" id="main">
				<div class="header" id="header">
					<?php echo $html_head_content?>
				</div>
				<div class="content" style="overflow:hidden">
					<div class="sidebar" id="sidebar">
						<?php echo $html_left_content?>
					</div>
					<div class="content-box">
						<div class="content-inner">
							<div class="navbar-top">
								<span style="font-size:14pt; font-weight:bold; color:#F00; line-height:35px;">
									添加学生资料成功，马上发短信通知
								</span>
							</div>
							
							<input type="hidden" id="student_id" value="<?php echo $student_id?>">
							
							<div style="color:#666; width:100%;">
								<ul>
	                                <li style="font-weight:bold;">
										<span style="float:left; line-height:35px; height:35px;font-size:30px; text-align:right; width:200px;">
											验证码：
										</span>
										<input type="text"  style=" font-size:30px; line-height:30px; width:150px; font-weight:bold; color:#666"      readonly="readonly" value="<?php echo $code?>" />
							  		</li>
									<li style="font-weight:bold;">
										<span style="float:left; line-height:35px; height:35px;font-size:30px; text-align:right; width:200px;">
											短信内容：
										</span>
										<textarea rows="5" readonly="readonly" style="width: 350px; font-size:14pt; color:#666">欢迎您使用<?php echo $agency?>机构的学信通，验证码为：<?php echo $code?>；在您用微信访问本机构的公众号时，输入验证码，系统自动为您授权。</textarea>
									</li>
	                                <li>
										<span style="float:left; line-height:35px; height:35px;font-size:12pt; text-align:right; width:200px;">
											手机号码：
										</span>
										<input type="checkbox" value="<?php echo $item['mobile']?>" style="width: 15px;margin-left: 10px;margin-top:10px; float:left; line-height: 30px;" />
										<span style="float: left; margin-left: 5px; margin-right:15px; line-height: 30px;float:left">
											学生手机（<?php echo $item['mobile']?>）
										</span>
										<input type="checkbox" value="<?php echo $item['father_mobile']?>" style="width: 15px;margin-left: 10px;margin-top:10px; float:left; line-height: 30px;" />
										<span style="float: left; margin-left: 5px; margin-right:15px; line-height: 30px;float:left">
											父亲手机（<?php echo $item['father_mobile']?>）
										</span>
	                                    <input type="checkbox" value="<?php echo $item['mother_mobile']?>" style="width: 15px;margin-left: 10px;margin-top:10px; float:left; line-height: 30px;" />
	                                    <span style="float: left; margin-left: 5px; margin-right:15px; line-height: 30px;float:left">
	                                    	母亲手机（<?php echo $item['mother_mobile']?>）
	                                    </span>
							  		</li>
								</ul>
							</div>
							
							<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
								<button id="btnSubmit" style="margin-left: 105px;margin-top: 10px;">确定发送</button>
							</div>
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

	$('input[type=checkbox]').click(function () {
		if ( $(this).attr('checked') ) {
			$(this).attr('checked', false);
		} else {
			$(this).attr('checked', true);
		}
	});

	$('#btnSubmit').click(function(){
		
		var phones = [];
		$('input[type=checkbox]').each(function () {
			if ( $(this).attr('checked') ) {
				phones.push($(this).val());
			}
		});
		if ( phones.length == 0 ) {
			alert('请选择手机号码发送短信');
			return false;
		}
	
		var url = '<?php echo URL::base(NULL, TRUE)?>student/sms/';
		$.post(url, {id:$('#student_id').val(), phones:phones.join(',')}, function (jsonStr) {
			var jsonObj = $.parseJSON(jsonStr);
			if ( jsonObj.ret != 0 ) {
				alert(jsonObj.msg);
				return false;
			}
			alert('发送成功');
			window.location.href = '<?php echo URL::base(NULL, TRUE)?>student/list/';
		});
	});
});
</script>
