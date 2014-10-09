{{ content() }}

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
		
		{% for v in items %}
		<tr>
			<td>{{ v.id }}</td>
			<td>{{ v.title }}</td>
			<td>{{ v.created_at }}</td>
			<td>{{ v.modified_at }}</td>
			<td>{{ v.modified_by }}</td>
			<td width="12%">
				{{ link_to("articles/edit/" ~ v.id, '<i class="icon-pencil"></i> 编辑', "class": "btn") }}
				&nbsp;
				{{ link_to("articles/del/" ~ v.id, '<i class="icon-remove"></i> 删除', "class": "btn") }}
			</td>
		</tr>
		{% endfor %}
		
	</table>
	
	<div class="pagenav">
		共 {{ total_items }} 条记录，共 {{ total_pages }} 页，当前为第 {{ page }} 页。
	</div>
</div>
		
