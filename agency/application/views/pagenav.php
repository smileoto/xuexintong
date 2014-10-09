<?php
$back_url = '#';
$next_url = '#';
$goto_url = $base_url . '?z=z';

$pages = ( $total % $size ) ? ( intval( $total / $size ) + 1 ) : intval( $total / $size );

if ( $page > 1 ) {
	$back_url = $base_url . '?page=' . ($page - 1);
	foreach ( $_GET as $k => $v ) {
		if ( $k != 'page' and $k != 'size' ) {
			$back_url .= '&'.$k.'='.$v;
		}
	}
}
if ( $page < $pages ) {
	$next_url = $base_url . '?page=' . ($page + 1);
	foreach ( $_GET as $k => $v ) {
		if ( $k != 'page' and $k != 'size' ) {
			$next_url .= '&'.$k.'='.$v;
		}
	}
}

foreach ( $_GET as $k => $v ) {
	if ( $k != 'page' and $k != 'size' ) {
		$goto_url .= '&'.$k.'='.$v;
	}
}
?>

共<?php echo $total?>条记录，共<?php echo $pages?>页，当前为第<?php echo $page?>页。
<a href="<?php echo $back_url?>">上一页</a>
<a href="<?php echo $next_url?>">下一页</a>
<input type="text" id="pagenav_goto" /><a href="#" id="btnGotoPage">跳转</a>

<script type="text/javascript">
$(function(){
	var goto_url = '<?php echo $goto_url?>';
	$('#btnGotoPage').click(function(){
		var page = $('#pagenav_goto').val();
		page = parseInt(page);
		window.location.href = goto_url + page;
	});
});
</script>
