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
		
		<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
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
								<a href="<?php echo URL::base(NULL, TRUE)?>student/list/">学生查询</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>guest/list/">申请查询</a>
								<a class="active" href="#">编辑学生</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/add/?adult=1">添加成人学员</a>
							</div>
							<div class="accountSettings-box">
								<ul>
									<li>
										<span class="m-name">
											姓名：
										</span>
										<input type="text" name="realname" id="realname" value="<?php echo $item['realname']?>" />
									</li><li>
										<span class="m-name">
											性别：
										</span>
										<select name="sex" id="sex">
											<option value="2">请选择</option>
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
										<input type="month" name="birthday" id="birthday" value="<?php echo $item['birthday']?>" />
									</li>
									<li>
										<span class="m-name">
											所在机构：
										</span>
										<select name="entity_id" id="entity">
											<option value=""></option>
											<?php foreach ( $entities as $v ) : ?>
											<option value="<?php echo $v['id']?>" 
												<?php
												if ( $item['entity_id'] == $v['id'] ) {
													echo 'selected="selected"';
												}
												?> >
												<?php echo $v['name']?>
											</option>
											<?php endforeach?>
										</select>
									</li>
									<li>
										<span class="m-name">
											所在学校：
										</span>
										<select name="school_id" id="school">
											<option value=""></option>
											<?php foreach ( $schools as $v ) : ?>
											<option value="<?php echo $v['id']?>" 
												<?php
												if ( $item['school_id'] == $v['id'] )
													echo 'selected="selected"';
												?> >
												<?php echo $v['name']?>
											</option>
											<?php endforeach?>
										</select>
									</li>
									<li>
										<span class="m-name">
											所在班级：
										</span>
										<select name="grade_id" id="grade">
											<option value=""></option>
											<?php foreach ( $grades as $v ) : ?>
												<option value="<?php echo $v['id']?>"  
												<?php
												if ( $item['grade_id'] == $v['id'] )
													echo 'selected="selected"';
												?> >
												<?php echo $v['name']?>
											</option>
											<?php endforeach?>
										</select>
									</li>
									<li>
										<span class="m-name">
											手机号码：
										</span>
										<input type="text" name="mobile" id="mobile" value="<?php echo $item['mobile']?>" />
									</li>
									<li>
										<span class="m-name">
											父亲姓名：
										</span>
										<input type="text" name="father_name" id="father_name" value="<?php echo $item['father_name']?>" />
									</li>
									<li>
										<span class="m-name">
											父亲手机：
										</span>
										<input type="text" name="father_mobile" id="father_mobile" value="<?php echo $item['father_mobile']?>" />
									</li>
									<li>
										<span class="m-name">
											母亲姓名：
										</span>
										<input type="text" name="mother_name" id="mother_name" value="<?php echo $item['mother_name']?>" />
									</li>
									<li style="width:100%">
										<span class="m-name">
											母亲手机：
										</span>
										<input type="text" name="mother_mobile" id="mother_mobile" value="<?php echo $item['mother_mobile']?>" />
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
									<li style="width: 100%;">
										<span class="m-name">
											家庭住址：
										</span>
										<input style="width: 477px;" type="text" name="addr" id="addr" value="<?php echo $item['addr']?>" />
									</li>
									<li style="width: 100%;">
										<span class="m-name">
											报名班别：
										</span>
										<div class="checkbox-box" style="width: 485px;float: left;">
										<?php foreach ( $courses as $v ) : ?>
										<input type="checkbox" class="course" style="width: 15px;margin-left: 10px;" name="course[]" value="<?php echo $v['id']?>"  
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
										<textarea rows="9" style="width: 477px;" name="remark" id="remark"><?php echo $item['remark']?></textarea>
									</li>
								</ul>
							</div>
							<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
								<button id="btnSubmit" style="margin-left: 105px;margin-top: 10px;">确定修改</button>
							</div>
						</div>
						</form>
						
						<div class="btn-box" style="float: left;margin-top: 30px;height: 50px;margin-left: 105px;"  >
								注：添加后不能删除，只能停用。
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

<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/geo.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	var s1 = '<?php echo $item["province"]?>';
	var s2 = '<?php echo $item["city"]?>';
	var s3 = '<?php echo $item["area"]?>';
	setup();preselect_ex(s1,s2,s3);
	
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
