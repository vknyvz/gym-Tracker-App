$(function() {
	$('.setCalendarView').change(function(){
		var selected = $(".setCalendarView option:selected");    
		if(selected.val()){
			$.ajax( {
				url: '/my-account/index/calendarview/1/value/' + selected.val(),
				dataType : 'json',
				success: function(data) {
				}
			});
		}
	});
	
	$('.language').bind('click', function() {
		var lang = $(this).attr('rel');
		
		$.ajax( {
			url: '/my-account/language/lang/' + lang,
			dataType : 'json',
			success: function(data) {
				if(data.success)
					window.top.location = '/';
			}
		});
		return false;
	});
});	