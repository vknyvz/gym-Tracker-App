$(function() {
	$('.loadexercise').bind('click', function() {
		$('#content-load').show();

		rel = $(this).attr('rel');
		
		$('#content').load(rel, null, function() {
			//$('.navigation').css('margin-left', '-10px');
			$('#content-load').hide();
		});	
	});
});