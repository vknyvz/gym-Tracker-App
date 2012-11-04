$(function() {
	$('body').attr('id', 'normal');
	$('.navigation').css('margin-left', '0px');
	$("#exercises").accordion({collapsible: true, active: false, autoHeight:false});

	$('.loadexercises').bind('click', function() {
		$('#content-load').show();

		rel = $(this).attr('rel');
		
		$('#content').load(rel, null, function() {
			$('.navigation').css('margin-left', '-10px');
			$('#content-load').hide();
		});	
	});
});