$(function(){
	var navbarh=$('#segmentedControl').height()!=null?$('#segmentedControl').height():0;
	var headerh=$('.mui-bar').height()!=null?$('.mui-bar').height():0;
	$(".mui-content").css('minHeight',$(window).height()-$(".foot").height()-navbarh-headerh-20);
	delete navbarh,headerh;
});
