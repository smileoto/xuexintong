		
		<footer class="foot">
			<?php echo $agency->get('realname')?> 
			微信公众号：<?php echo $agency->get('weixin')?> 
			名称：<?php echo $agency->get('viewname')?>
			<div>
				联系电话：<a href="tel:<?php echo $agency->get('mobile')?>">:<?php echo $agency->get('mobile')?></a>
				联系人：<?php echo $agency->get('contacts')?>
			</div>
		</footer>
		