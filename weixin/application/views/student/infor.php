<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>学生资料</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/default.css"/>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/default.date.css"/>
		<script src="<?PHP echo URL::base()?>js/mui.min.js"></script>
		<style type="text/css">
			.address-box label~select {
				width: 21%;
			}
			.mui-input-row label {
				width: 35%;
				height: 40px;
				padding: 0px 15px;
				line-height: 43px;
			}
		</style>
		
		<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title">完善资料</h1> 
		</header>
		<div class="mui-content">
			<div class="mui-content-padded" style="margin: 10px;">
				<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>student/save/">
                	<div class="mui-input-row mui-select">
						<label>您是</label>
						<select name="signup_by" id="signup">
						  <option selected>请选择</option>
                          <option value="0">学生</option>
                          <option value="1">父亲</option>
                          <option value="2">母亲</option>
					    </select>
					</div>
					<div class="mui-input-row">
						<label>学生姓名</label>
						<input type="text" placeholder="填写您的姓名" name="realname" id="realname" value="<?php echo $item['realname']?>">
					</div>
					<div class="mui-input-row">
						<label>性别</label>
						<div class="sex-box" style="line-height: 40px;">
							<input type="radio" name="sex" id="" value="1" checked="" <?php if ( $item['sex'] == 1 ) echo 'checked="checked"' ?> />
							<span>男</span>
							
							<input type="radio" name="sex" id="" value="0" style="margin-left: 10px;" <?php if ( $item['sex'] == 0 ) echo 'checked="checked"' ?> />
							<span>女</span>
						</div>
					</div>
					<div class="mui-input-row">
						<label>出生日期</label>
						<input class="datepicker data-field" style="width: 45%;float: left;" type="date" name="birthday" id="birthday" value="<?php echo $item['birthday']?>" />
					</div>
					<div class="mui-input-row">
						<label>所在学校</label>
						<select name="school_id" id="school_id">
							<option value=""></option>
							<?php foreach ( $schools as $v ):?>
							<option value="<?php echo $v['id']?>" <?php if ( $item['school_id'] == $v['id'] ) echo 'selected="selected"' ?> >
								<?php echo $v['name']?>
							</option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="mui-input-row mui-select">
						<label>所在班级</label>
						<select name="grade_id" id="grade_id">
							<option value=""></option>
							<?php foreach ( $grades as $v ):?>
							<option value="<?php echo $v['id']?>" <?php if ( $item['grade_id'] == $v['id'] ) echo 'selected="selected"' ?>>
								<?php echo $v['name']?>
							</option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="mui-input-row">
						<label>手机号码</label>
						<input type="text" placeholder="填写手机号码" name="mobile" id="mobile" value="<?php echo $item['mobile']?>">
					</div>
					<div class="mui-input-row">
						<label>父亲姓名</label>
						<input type="text" placeholder="填写父亲姓名" name="father_name" id="father_name" value="<?php echo $item['father_name']?>">
					</div>
					<div class="mui-input-row">
						<label>父亲号码</label>
						<input type="text" placeholder="填写父亲号码" name="father_mobile" id="father_mobile" value="<?php echo $item['father_mobile']?>">
					</div>
					<div class="mui-input-row">
						<label>母亲姓名</label>
						<input type="text" placeholder="填写母亲姓名" name="mother_name" id="mother_name" value="<?php echo $item['mother_name']?>">
					</div>
					<div class="mui-input-row">
						<label>母亲号码</label>
						<input type="text" placeholder="填写母亲号码" name="mother_mobile" id="mother_mobile" value="<?php echo $item['mother_mobile']?>">
					</div>
					<div class="mui-input-row address-box mui-select">
						<label>所在区域</label>
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
						<input type="hidden" name="city"     id="city"     value="<?php echo $item["city"]?>" />
						<input type="hidden" name="area"     id="area"     value="<?php echo $item["area"]?>" />
					</div>
					<div class="mui-input-row">
						<label>家庭住址</label>
						<input type="text" placeholder="填写您的家庭地址" name="addr" id="addr" value="<?php echo $item['addr']?>">
					</div>
				</div>
			</form>
			<div class="mui-input-row" style="margin: 10px 5px;">
				<button class="mui-btn mui-btn-block" id="btnSubmit">确认修改</button>
			</div>
		</div>
		</div>


		<style type="text/css">
			h5 {
				margin: 5px 7px;
			}
		</style>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/picker.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/picker.date.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/geo.js"></script>

<script type="text/javascript" charset="utf-8">
//$('.datepicker').picker.get('start')

$(function () {
	var s1 = '<?php echo $item["province"]?>';
	var s2 = '<?php echo $item["city"]?>';
	var s3 = '<?php echo $item["area"]?>';
	setup();preselect_ex(s1,s2,s3);
	
	var parseClick = false;
	$('#btnSubmit').click(function () {
		if ( parseClick ) {
			return;
		}
		parseClick = true;
		
		$('#data-form').submit();
	});
});
</script>