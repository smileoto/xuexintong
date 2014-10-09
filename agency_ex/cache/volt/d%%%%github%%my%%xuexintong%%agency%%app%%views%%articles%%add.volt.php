<?php echo $this->tag->form(array('articles/save', 'autocomplete' => 'off')); ?>

<?php echo $this->getContent(); ?>

<div class="navbar-top">
	<a href="/articles/list" >知识分享</a>
	<a class="active" href="#">添加分享</a>
</div>

<ul>
	<li>
		<div class="con-name">
		标&nbsp&nbsp题：
		</div>
		<div class="con-info" style="text-align:center">
			<?php echo $this->tag->textField(array('title', 'size' => 24, 'maxlength' => 70)); ?>
			<i>(字数必须在16个字符内)</i>
		</div>
	</li>
	<li>
		<div class="con-name">
		图片：
		</div>
		<div class="con-info">
			<input type="text" readonly="readonly" />
			<div class="scan-box">
				<button >上传</button>
				<input type="file" name="scan" id="scan" value="上传" />
			</div>
		</div>
	</li>
	<li>
		<div class="con-name">
		轮播图片：
		</div>
		<div class="con-info">
			<input type="checkbox" name="show_type" value="1">
		</div>
	</li>
	<li>
		<div class="table-cell">
			<textarea name="content"  class="<?php echo $this->elements->getXheditorClass(); ?>" id="content"></textarea>
		</div>
	</li>
	<li>
		<div class="btn-box">
			<input type="submit" name="" value="确定提交" />
		</div>
	</li>
</ul>


</form>
