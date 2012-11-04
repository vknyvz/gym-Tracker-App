$(function() {
	$('.vkNgine-calendar-menu').bind('click', function() {
		rel = $(this).attr('rel');
		
		$('.loadmarkas').attr('date', rel);
		
		$('#vkNgine-calendar-iphone-menu-content-on a.loadmarkas').show();
		
		data = $(this).attr('data');
		if(data == 'on'){
			$('#vkNgine-calendar-iphone-menu-content-off').show();
		}
		else if(data == 'disabled'){
			$('#vkNgine-calendar-iphone-menu-content-on').show();
			$('#vkNgine-calendar-iphone-menu-content-on a.loadmarkas').hide();
		}
		else {
			$('#vkNgine-calendar-iphone-menu-content-on').show();
		}
		
		$('.loadadddaydetails').attr('date', rel);
		$('.loadviewday').attr('date', rel);
	});

	$('.close').bind('click', function() {
		$('#vkNgine-calendar-iphone-menu-content-on').hide();
		$('#vkNgine-calendar-iphone-menu-content-off').hide();
	});

	$('.loadmarkas').bind('click', function() {
		$('#content-load').show();

		rel = $(this).attr('rel');
		date = $(this).attr('date');

		$.ajax({ 
			url: rel + '' + date,
			dataType : 'json',
			success: function(data) {
				$('#content-load').hide();
				$('#vkNgine-calendar-iphone-menu-content-on').hide();
				$('#vkNgine-calendar-iphone-menu-content-off').hide();
				
				vkNgineAjaxFormSubmit(data);
			}
		})
	});
	$('.loadviewday').bind('click', function() {
		rel = $(this).attr('rel');
		date = $(this).attr('date');

		$('#content').load(rel + '' + date, null, function() {
			$('#content-load').hide();
		});
	});
	
	$('.loadadddaydetails').bind('click', function() {
		rel = $(this).attr('rel');
		date = $(this).attr('date');
		
		$('#content').load(rel + '' + date, null, function() {
			$('#content-load').hide();
		});
	});
});