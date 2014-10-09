<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="学信通">
        <meta name="author" content="zhangys">
		
        <?php echo $this->tag->getTitle(); ?>
        <?php echo $this->tag->stylesheetLink('css/base.css'); ?>
        <?php echo $this->tag->stylesheetLink('css/ago.css'); ?>
		
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
					<div class="pagetitle">
						<a href="/agency/index"><h1>学信通</h1></a>
						<p>
							欢迎您，<a href="#"> <?php echo $login_name; ?> </a>  <a href="#">退出</a>
						</p>
					</div>
					<strong> <?php echo $agency_name; ?> </strong>
				</div>
				
				<div class="content">
					<div class="sidebar" id="sidebar">
						<?php echo $this->elements->getMenu(); ?>
					</div>
					
					<div class="content-box">
						<div class="content-inner">
							<?php echo $this->getContent(); ?>
						</div>
					</div>
				</div>
				
			</div>
		</div>
        
    </body>
</html>

<?php echo $this->tag->javascriptInclude('js/jquery-1.4.4.min.js'); ?>
<?php echo $this->tag->javascriptInclude('js/geo.js'); ?>
<?php echo $this->tag->javascriptInclude('js/xheditor.js'); ?>
<?php echo $this->tag->javascriptInclude('js/xheditor_lang/zh-cn.js'); ?>

<script type="text/javascript" charset="utf-8">
window.onload=function(){
	document.getElementById("sidebar").style.minHeight=document.getElementById("main").clientHeight-document.getElementById("header").clientHeight-3+'px';
}
</script>
