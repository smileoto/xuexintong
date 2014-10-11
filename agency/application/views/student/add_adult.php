<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>学生查询</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
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
				<div class="content" style="overflow:hidden">
					<div class="sidebar" id="sidebar">
						<?php echo $html_left_content?>
					</div>
					<div class="content-box">
						
						<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>student/save/">
						<input type="hidden" name="signup_by" value="3">
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>student/list/">学生查询</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>guest/list/">申请查询</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/add/?adult=1">添加学生</a>
								<a class="active" href="#">添加成人学员</a>
							</div>
							<div class="accountSettings-box">
								<ul>
									<li>
										<span class="m-name">
											学员姓名：
										</span>
										<input type="text" name="realname" id="realname" />
									</li>
									<li>
										<span class="m-name">
											性别：
										</span>
										<select name="sex">
										  <option value="2">请选择</option>
										  <option value="1">男</option>
										  <option value="0">女</option>
										</select>
									</li>
									<li>
										<span class="m-name">
											出生年月：
										</span>
										<input type="date" name="birthday" id="birthday" />
									</li>
									<li>
										<span class="m-name">
											手机号码：
										</span>
										<input type="text" name="mobile" id="mobile" />
									</li>
									<li>
										<span class="m-name">
											QQ号码：
										</span>
										<input type="text" name="QQ" id="QQ"  />
									</li>
									<li>
										<span class="m-name">
											电子邮箱：
										</span>
										<input type="text" name="mail" id="mail"  />
									</li>
									<li>
										<span class="m-name">
											所在分机构：
										</span>
										<select name="entity_id" id="entity">
											<option value=""></option>
											<?php foreach ( $entities as $v ) : ?>
											<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
											<?php endforeach?>
										</select>
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
										<input type="hidden" name="province" id="province" value="0" />
										<input type="hidden" name="city"     id="city" value="0" />
										<input type="hidden" name="area"     id="area" value="0" />
									</li>
									<li style="width: 100%;">
										<span class="m-name">
											联系地址：
										</span>
										<input style="width: 477px;" type="text" name="addr" id="addr" />
									</li>
									<li style="width: 100%;">
										<span class="m-name">
											报名班别：
										</span>
										<div class="checkbox-box" style="width: 485px;float: left;">
										<?php foreach ( $courses as $v ) : ?>
										<input type="checkbox" class="course" style="width: 15px;margin-left: 10px;" name="course[]" value="<?php echo $v['id']?>" />
										<span style="float: left; margin-left: 5px; margin-right:15px; line-height: 30px;">
											<?php echo $v['name']?>
										</span>
										<?php endforeach?>
										</div>
									</li>
									<li style="width: 100%;">
										<span class="m-name">
											特别说明：
										</span>
										<textarea rows="9" style="width: 477px;" name="remark" id="remark"></textarea>
									</li>
								</ul>
							</div>
							<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
									<button id="btnSubmit" style="margin-left: 105px;margin-top: 10px;">确定添加</button>
								</div>
							</div>
							<div class="btn-box" style="float: left;margin-top: 30px;height: 50px;margin-left: 105px;"  >
								注：添加后不能删除，只能停用。
							</div>
						</div>
						</form>
						
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
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/geo.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	setup();preselect_ex(0,0,0);
	
	$('.course').click(function () {
		if ( $(this).attr('checked') ) {
			$(this).attr('checked', false);
		} else {
			$(this).attr('checked', true);
		}
	});
	
	$('#btnSubmit').click(function(){
		$('#area').val($('#s3').get(0).selectedIndex);
		
		var courses = [];
		$('.course').each(function () {
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
});
</script>
