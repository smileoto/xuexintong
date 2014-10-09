<?php echo $this->getContent(); ?>

<div class="navbar-top">
	<a href="#" class="active">知识分享</a>
	<a href="/articles/add">添加分享</a>
</div>
<div class="input-box">
	<span>标题：</span>
	<input type="text" id="title" class="data-field" />
	<button id="btnSearch">搜索</button>
</div>
<div class="table-cell">

	<table border="1" cellspacing="0" cellpadding="0">
		<tr><th>序号</th><th>标题</th><th>添加时间</th><th>修改时间</th><th>编辑者</th><th>操作</th></tr>
		
		<?php foreach ($items as $v) { ?>
		<tr>
			<td><?php echo $v->id; ?></td>
			<td><?php echo $v->title; ?></td>
			<td><?php echo $v->created_at; ?></td>
			<td><?php echo $v->modified_at; ?></td>
			<td><?php echo $v->modified_by; ?></td>
			<td width="12%">
				<?php echo $this->tag->linkTo(array('articles/edit/' . $v->id, '<i class="icon-pencil"></i> 编辑', 'class' => 'btn')); ?>
				&nbsp;
				<?php echo $this->tag->linkTo(array('articles/del/' . $v->id, '<i class="icon-remove"></i> 删除', 'class' => 'btn')); ?>
			</td>
		</tr>
		<?php } ?>
		
	</table>
	
	<div class="pagenav">
		共 <?php echo $total_items; ?> 条记录，共 <?php echo $total_pages; ?> 页，当前为第 <?php echo $page; ?> 页。
	</div>
</div>
		
