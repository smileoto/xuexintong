<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title><?php echo $html_title_content?></title>
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
	</head>

	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title"><?php echo $html_title_content?></h1> 
		</header>
		<div class="mui-content">
			<div class="mui-content-padded" style="margin: 10px;">
				<form class="mui-input-group">
                	<div class="mui-input-row mui-select">
						<label>您是</label>
						<select class="data-field" id="role">
						  <option selected>请选择</option>
                          <option value="0">学生</option>
                          <option value="1">父亲</option>
                          <option value="2">母亲</option>
					    </select>
					</div>
					<div class="mui-input-row">
						<label>学生姓名</label>
						<input type="text" placeholder="填写您的姓名" class="data-field" id="realname" value="<?php echo $student['realname']?>">
					</div>
					<div class="mui-input-row">
						<label>性别</label>
						<div class="sex-box" style="line-height: 40px;">
							<input type="radio" name="sex" id="" value="1" checked="" <?php if ( $student['sex'] == 1 ) echo 'checked="checked"' ?> />
							<span>男</span>
							
							<input type="radio" name="sex" id="" value="0" style="margin-left: 10px;" <?php if ( $student['sex'] == 0 ) echo 'checked="checked"' ?> />
							<span>女</span>
						</div>
					</div>
					<div class="mui-input-row">
						<label>出生日期</label>
						<input class="datepicker data-field" style="width: 45%;float: left;" type="date" name="" id="birthday" value="<?php echo $student['birthday']?>" />
					</div>
					<div class="mui-input-row">
						<label>所在学校</label>
						<select class="data-field" id="school_id">
							<option value=""></option>
							<?php foreach ( $schools as $v ):?>
							<option value="<?php echo $v['id']?>" <?php if ( $student['school_id'] == $v['id'] ) echo 'selected="selected"' ?> >
								<?php echo $v['name']?>
							</option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="mui-input-row mui-select">
						<label>所在班级</label>
						<select class="data-field" id="grade_id">
							<option value=""></option>
							<?php foreach ( $grades as $v ):?>
							<option value="<?php echo $v['id']?>" <?php if ( $student['grade_id'] == $v['id'] ) echo 'selected="selected"' ?>>
								<?php echo $v['name']?>
							</option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="mui-input-row">
						<label>手机号码</label>
						<input type="text" placeholder="填写您的手机号码" class="data-field" id="mobile" value="<?php echo $student['mobile']?>">
					</div>
					<div class="mui-input-row">
						<label>父亲姓名</label>
						<input type="text" placeholder="填写您父亲姓名" class="data-field" id="father_name" value="<?php echo $student['father_name']?>">
					</div>
					<div class="mui-input-row">
						<label>父亲号码</label>
						<input type="text" placeholder="填写您父亲号码" class="data-field" id="father_mobile" value="<?php echo $student['father_mobile']?>">
					</div>
					<div class="mui-input-row">
						<label>母亲姓名</label>
						<input type="text" placeholder="填写您母亲姓名" class="data-field" id="mother_name" value="<?php echo $student['mother_name']?>">
					</div>
					<div class="mui-input-row">
						<label>母亲号码</label>
						<input type="text" placeholder="填写您母亲号码" class="data-field" id="mother_mobile" value="<?php echo $student['mother_mobile']?>">
					</div>
					<div class="mui-input-row address-box mui-select">
						<label>所在区域</label>
						<select>
							<option>龙岗区</option>
						</select>
						<select>
							<option>深圳市</option>
						</select>
						<select>
							<option>广东省</option>
						</select>
					</div>
					<div class="mui-input-row">
						<label>家庭住址</label>
						<input type="text" placeholder="填写您的家庭地址" class="data-field" id="addr" value="<?php echo $student['addr']?>">
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
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/picker.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/picker.date.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/legacy.js"></script>
<script type="text/javascript" charset="utf-8">
//$('.datepicker').picker.get('start')

$(function () {
	var parseClick = false;
	$('#btnSubmit').click(function () {
		if ( parseClick ) {
			return;
		}
		parseClick = true;
		
		var jsonObj = {};
		jsonObj['sex'] = $('input:radio[name="sex"]:checked').val();
		$('.data-field').each(function () {
			var key = $(this).attr('id');
			var val = $(this).val();
			jsonObj[key] = val;
		});
		
		var url = '<?php echo URL::base(NULL, TRUE)?>student/save/';
		$.post(url, jsonObj, function (jsonStr) {
			parseClick = false;
			
			var resultObj = $.parseJSON(jsonStr);
			if ( resultObj.ret != 0 ) {
				alert(resultObj.msg);
				return false;
			}
			
			alert('资料保存成功');
		});
	});
});
</script>