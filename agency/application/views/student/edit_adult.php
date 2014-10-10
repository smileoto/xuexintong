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
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>student/list/?status=1">学生查询</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/list/">申请查询</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/add/">添加学生</a>
								<a class="active" href="#">添加成人学员</a>
							</div>
						<div class="accountSettings-box">
							<ul>
								<li>
									<span class="m-name">
										学员姓名：
									</span>
									<input type="text" class="data-field" id="realname" />
								</li><li>
									<span class="m-name">
										性别：
									</span>
									<select>
									  <option value="">请选择</option>
									  <option>男</option>
									  <option>女</option>
									</select>
								</li>
								<li>
									<span class="m-name">
										出生年月：
									</span>
									<input type="date" class="data-field" id="birthday" />
								</li>
								<li>
									<span class="m-name">
										手机号码：
									</span>
									<input type="text" class="data-field" id="mobile" />
								</li>
                                <li>
									<span class="m-name">
										QQ号码：
									</span>
									<input type="text" class="data-field" id="QQ"  />
								</li>
                                <li>
									<span class="m-name">
										电子邮箱：
									</span>
									<input type="text" class="data-field" id="mail"  />
								</li>
								<li>
									<span class="m-name">
										所在机构：
									</span>
									<select class="data-field" id="school">
										<option value=""></option>
										<?php foreach ( $agencies as $v ) : ?>
										<option value="<?php echo $v['id']?>" 
											<?php
											if ( $student['agency_id'] == $v['id'] ) {
												echo 'selected="selected"';
											}
											?> >
											<?php echo $v['realname']?>
										</option>
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
									<input type="hidden" class="data-field" id="province" value="0" />
									<input type="hidden" class="data-field" id="city" value="0" />
									<input type="hidden" class="data-field" id="area" value="0" />
								</li>
                                <li style="width: 100%;">
									<span class="m-name">
										联系地址：
									</span>
									<input style="width: 477px;" type="text" class="data-field" id="addr" />
								</li>
								<li style="width: 100%;">
									<span class="m-name">
										报名班别：
									</span>
									<div class="checkbox-box" style="width: 485px;float: left;">
									<?php foreach ( $courses as $v ) : ?>
									<input type="checkbox" style="width: 15px;margin-left: 10px;" name="course" value="<?php echo $v['id']?>"  
										<?php if ( isset($student_courses[$v['id']]) ) { echo 'checked="checked"'; } ?> />
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
									<textarea name="" rows="9" style="width: 477px;" class="data-field" id="remark"></textarea>
								</li>
							</ul>
						</div>
						<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
								<button id="btnAddStudent" style="margin-left: 105px;margin-top: 10px;">确定添加</button>
							</div>
						</div>
						<div class="btn-box" style="float: left;margin-top: 30px;height: 50px;margin-left: 105px;"  >
							注：添加后不能删除，只能停用。
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
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/geo.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	setup();preselect_ex(0,0,0);
	
	$('#btnAddStudent').click(function(){
		$('#area').val($('#s3').get(0).selectedIndex);
		
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
		
		// todo: check params
		var url = window.location.href;
		var jsonObj = {};
		jsonObj['class'] = courses.join(',');
		$('.data-field').each(function(){
			var key = $(this).attr('id');
			var val  = $(this).val();
			jsonObj[key] = val;
		});
		
		$.post(url, jsonObj, function(jsonStr){
			var obj = jQuery.parseJSON(jsonStr);
			if ( obj.ret != 0 ) {
				alert(obj.msg);
				return false;
			}
			
			window.location.href = '<?php echo URL::base(NULL, TRUE)?>student/list/?status=1';
		});
		
	});
});
</script>
