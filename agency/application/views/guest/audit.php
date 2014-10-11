<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>学生查询</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
        <link rel="stylesheet" href="<?PHP echo URL::base()?>css/jquery.windows.css" media="all">
		<!--[if gte IE 9]>
		  <style type="text/css">
		    .gradient {
		       filter: none;
		    }
		  </style>
		<![endif]-->
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
					
						<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>student/save/">
						<input type="hidden" name="id" value="<?php echo $item['id']?>">
						
						<div class="content-inner">
							<div class="navbar-top">
								<a class="active" href="add-sharing.html">审核申请</a>
							</div>
							<div class="accountSettings-box">
                        	<ul>
                            	<li>
									<span class="m-name">
										申请者微信：
									</span>
									<span class="m-content">
										<?php echo $item['wx_openid']?>
									</span>
								</li>
                                <li>
									<span class="m-name">
										微信号昵称：
									</span>
									<span class="m-content">
										<?php echo //$item['nickname']?>
									</span>
								</li>
								<li>
									<span class="m-name">
										申请者角色：
									</span>
									<span class="m-content">
										学生
									</span>
								</li>
                                <li style="width:100%">
                                <div style="height:50px; text-align:center">
                            		<span style="color:#F00; font-weight:bold">
                            			请从数据库里选择学生进行资料校对，如果资料符合，则可审核通过。
                            		</span>
									<a class="btn btn-primary btn-large theme-login" href="javascript:;" id="btnOpenSelector">选择学生</a>	
                            	</div>
                                </li>
								<li>
									<span class="m-name">
									姓名： </span>
									<input type="text" name="realname" value="<?php echo $item['realname']?>" />
								</li>
                                <li>
									<span class="m-name">
										性别：
									</span>
									<select name="sex">
										<option value="1" <?php if ($item['sex'] == 2) echo 'selected="selected"'?> >
											未知
										</option>
										<option value="1" <?php if ($item['sex'] == 1) echo 'selected="selected"'?> >
											男
										</option>
										<option value="0" <?php if ($item['sex'] == 0) echo 'selected="selected"'?> >
											女
										</option>
									</select>
								</li>
								<li>
									<span class="m-name">
										出生年月：
									</span>
									<input type="month" name="birthday" value="<?php echo $item['birthday']?>" />
								</li>
                                <li>
									<span class="caption-name">
										姓名：
									</span>
									<span class="caption-content" id="realname">
										
									</span>
								</li>
                                <li>
									<span class="caption-name">
										性别：
									</span>
									<span class="caption-content" id="sex">
										
									</span>
								</li>
								<li>
									<span class="caption-name">
										出生年月：
									</span>
									<span class="caption-content" id="birthday">
										
									</span>
								</li>
								<li>
									<span class="m-name">
										所在学校：
									</span>
									<select name="school">
										<?php foreach( $schools as $v ) : ?>
										<option value="<?php echo $v['id']?>" <?php if ($item['school_id'] == $v['id']) echo 'selected="selected"'?> > 
											<?php echo $v['name']?> 
										</option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">
										所在班级：
									</span>
									<select name="grade">
										<?php foreach( $grades as $v ) : ?>
										<option value="<?php echo $v['id']?>" <?php if ($item['grade_id'] == $v['id']) echo 'selected="selected"'?> > 
											<?php echo $v['name']?> 
										</option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">
										手机号码：
									</span>
									<input type="text" name="mobile" value="<?php echo $item['mobile']?>" />
								</li>
                                <li>
									<span class="caption-name">
										所在学校：
									</span>
									<span class="caption-content" id="school">
										
									</span>
								</li>
                                <li>
									<span class="caption-name">
										所在班级：
									</span>
									<span class="caption-content" id="grade">
										
									</span>
								</li>
								<li>
									<span class="caption-name">
										手机号码：
									</span>
									<span class="caption-content" id="mobile">
										
									</span>
								</li>
								<li>
									<span class="m-name">
										父亲姓名：
									</span>
									<input type="text" name="father_name" value="<?php echo $item['father_name']?>" />
								</li>
								<li>
									<span class="m-name">
										父亲手机：
									</span>
									<input type="text" name="father_mobile" value="<?php echo $item['father_mobile']?>" />
								</li>
								<li>
									<span class="m-name">
										母亲姓名：
									</span>
									<input type="text" name="mother_name" value="<?php echo $item['mother_name']?>" />
								</li>
                                <li>
									<span class="caption-name">
										父亲姓名：
									</span>
									<span class="caption-content" id="father_name">
										张三
									</span>
								</li>
                                <li>
									<span class="caption-name">
										父亲手机：
									</span>
									<span class="caption-content" id="father_mobile">
										
									</span>
								</li>
								<li>
									<span class="caption-name">
										母亲姓名：
									</span>
									<span class="caption-content" id="mother_name">
										
									</span>
								</li>
								<li style="width:100%">
									<span class="m-name">
										母亲手机：
									</span>
									<input type="text" name="mother_mobile" value="<?php echo $item['mother_mobile']?>" />
								</li>
                                <li style="width:100%">
									<span class="caption-name">
										母亲手机：
									</span>
									<span class="caption-content" id="mother_mobile">
										
									</span>
								</li>
								<li style="width: 100%;">
									<span class="m-name">
										所在区域：
									</span>
									<select class="select" id="s1">
										<option value="">请选择省份</option>
									</select>
									<select class="select" id="s2">
										<option value="">请选择城市</option>
									</select>
									<select class="select" id="s3">
										<option value="">请选择地区</option>
									</select>
									<input type="hidden" name="province" id="province" value="<?php echo $item["province"]?>" />
									<input type="hidden" name="city" id="city" value="<?php echo $item["city"]?>" />
									<input type="hidden" name="area" id="area" value="<?php echo $item["area"]?>" />
								</li>
                                <li style="width:100%">
									<span class="caption-name">
										所在区域：
									</span>
									<span class="caption-content" style="width:500px;">
										
									</span>
								</li>
                                <li style="width: 100%;">
									<span class="m-name">
										家庭住址：
									</span>
									<input style="width: 477px;" type="text" name="addr" value="<?php echo $item['addr']?>" />
								</li>
                                <li style="width:100%">
									<span class="caption-name">
										家庭住址：
									</span>
									<span class="caption-content" style="width:500px;" id="addr">
										
									</span>
								</li>
								<li>
									<span class="m-name">
										报名班别：
									</span>
									<?php foreach ( $courses as $v ) : ?>
									<input type="checkbox" id="course" value="<?php echo $v['id']?>"  
										<?php if ( isset($student_courses[$v['id']]) ) { echo 'checked="checked"'; } ?> />
									<?php echo $v['name']?>
									&nbsp;&nbsp;
									<?php endforeach?>
								</li>
                                <li style=" width:100%">
									<span class="caption-name">
										报名班别：
									</span>
									<span class="caption-content" id="classes">
										
									</span>
								</li>
								<li style="width: 100%;">
									<span class="m-name">
										特别说明：
									</span>
									<textarea id="" rows="9" style="width: 477px;" name="remark"><?php echo $item['remark']?></textarea>
								</li>
							</ul>
						</div>
						<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
								<input type="hidden" name="student_id" value="0" />
								<button style="margin-left: 105px;margin-top: 10px;" id="btnSubmit">审核通过并添加到数据库</button>
							</div>
						</div>
						</form>
						
					</div>
				</div>
			</div>
		</div>
		
		<div class="theme-popover" style="font-size:0.8em;" id="cntSelector"></div>
		<div class="theme-popover-mask"></div> 
		
	</body>

</html>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {
		document.getElementById("sidebar").style.minHeight = document.getElementById("main").clientHeight - document.getElementById("header").clientHeight - 3 + 'px';
	}
</script>
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	var id = '<?php echo $item["id"]?>';
	
	$('#btnSubmit').click(function(){
		// todo: check params
		
		var courses = [];
		$('input[name=course]').each(function () {
			if ( $(this).attr('checked') ) {
				courses.push($(this).val());
			}
		});
		if ( courses.length == 0 ) {
			alert('请选择班别');
			return false;
		}
		
		$('#data-form').submit();
	});
	
	
	$('#btnOpenSelector').click(function(){
		var url = '<?php echo URL::base(NULL, TRUE)?>student/list/?status=2';
		$.get(url, {}, function (html) {
			$('#cntSelector').html(html);
			$('.theme-popover-mask').fadeIn(100);
			$('.theme-popover').slideDown(200);
		});
	});
});

function select_for_audit(student_id) {
	$('#student_id').val(student_id);
	var url = '<?php echo URL::base(NULL, TRUE)?>student/search/';
	$.post(url, {student_id:student_id}, function (jsonStr) {
		var students = jQuery.parseJSON(jsonStr);
		$.each(students, function (k, v) {
			$('.caption-content').each(function () {
				var key = $(this).attr('id');
				if ( v[key] != undefined ) {
					$(this).text(v[key]);
				}
			});
		});
		$('#cntSelector').hide();
	});
}
</script>

<script>
jQuery(document).ready(function($) {
	$('.theme-login').click(function(){
		$('.theme-popover-mask').fadeIn(100);
		$('.theme-popover').slideDown(200);
	})
	$('.theme-poptit .close').click(function(){
		$('.theme-popover-mask').fadeOut(100);
		$('.theme-popover').slideUp(200);
	})

})
</script>
