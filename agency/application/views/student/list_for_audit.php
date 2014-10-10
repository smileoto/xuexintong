<div class="content-inner">
	<div class="theme-poptit">
		<a href="javascript:;" title="关闭" class="close">×</a>
		<h3>条件检索</h3>
	</div>
	<div class="accountSettings-box">
		<ul>
			<li>
				<span class="m-name">
					姓名：
				</span>
				<input type="text" class="search-field" id="realname" />
			</li>
			<li>
				<span class="m-name">
					所在机构：
				</span>
				<select class="search-field" id="agency">
					<option value=""></option>
					<?php foreach ( $agencies as $v ) : ?>
					<option value="<?php echo $v['id']?>"><?php echo $v['realname']?></option>
					<?php endforeach?>
				</select>
			</li>
			<li>
				<span class="m-name">
					所在学校：
				</span>
				<select class="search-field" id="school">
					<option value=""></option>
					<?php foreach ( $schools as $v ) : ?>
					<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
					<?php endforeach?>
				</select>
			</li>
			<li>
				<span class="m-name">
					所在年级：
				</span>
				<select class="search-field" id="grade">
					<option value=""></option>
					<?php foreach ( $grades as $v ) : ?>
					<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
					<?php endforeach?>
				</select>
			</li>
			<li>
				<span class="m-name">
					机构班别：
				</span>
				<select class="search-field" id="class">
					<option value=""></option>
					<?php foreach ( $classes as $v ) : ?>
					<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
					<?php endforeach?>
				</select>
			</li>
		</ul>
	</div>
	<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
		<button style="margin-left: 0;margin-top: 10px;" id="btnSearchStudent_Pop">搜索</button>
	</div>
	<div class="table-cell">
		<table border="1" cellspacing="0" cellpadding="0">
			<tr><th>序号</th><th>姓名</th><th>性别</th><th>所在学校</th><th>所在年级</th><th>机构班别</th><th>操作</th></tr>
			<?php foreach ( $students as $student ):?>
			<tr>
				<td><?php echo $student['id']?></td>
				<td><?php echo $student['realname']?></td>
				<td><?php echo $student['sex'] ? '男' : '女';?></td>
				<td><?php echo $student['school']?></td>
				<td><?php echo $student['grade']?></td>
				<td><?php echo $student['class']?></td>
				<td>
					<a href="#" onclick="select_for_audit(<?php echo $student['id']?>)">选择</a>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
		<div class="pagenav pop_pagenav">
			<?php echo $html_pagenav_content?>
		</div>
	</div>
</div>
	
	
<script type="text/javascript" charset="utf-8">
$(function(){
	$('.theme-poptit .close').click(function(){
		$('.theme-popover-mask').fadeOut(100);
		$('.theme-popover').slideUp(200);
	});
	
	$('#btnSearchStudent_Pop').click(function(){
		// todo: check params
		var url = '<?php echo URL::base(NULL, TRUE)?>student/list/?status=2';
		$('.search-field').each(function(){
			var key = $(this).attr('id');
			var val = $(this).val();
			url += '&' + key + '=' + val;
		});
		
		$.get(url, {}, function (html) {
			$('#cntSelector').html(html);
			$('.theme-popover-mask').fadeIn(100);
			$('.theme-popover').slideDown(200);
		});
	});
	
	$('.pop_pagenav a').each(function(){
		var self = $(this);
		var href = self.attr('href');
		self.attr('href', '#');
		self.attr('link', href);
		self.click(function(){
			var url = $(this).attr('link');
			$.get(url, {}, function (html) {
				$('#cntSelector').html(html);
				$('.theme-popover-mask').fadeIn(100);
				$('.theme-popover').slideDown(200);
			});
		});
	});
});
</script>
		