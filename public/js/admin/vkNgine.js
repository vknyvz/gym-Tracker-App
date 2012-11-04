$(document).ready(function() {
	
	$.extend($.gritter.options, {
	    position: 'top-right', // bottom-left, bottom-right, top-left, top-right
		fade_in_speed: 100, 
		fade_out_speed: 100, 
		sticky: false,
		time: 3000
	});
	
	$('.goto').bind('click', function() {
		$('#page-content-wrapper').css('opacity', '0.2');
		$('#page-content').append('<div class="ui-widget ui-widget-content ui-corner-all" style="position: absolute; width: 80px; height: 30px;left: 352px; top: 30px; padding: 10px;border-radius:20px"><div style="background: white; border: 0;" class="ui-dialog-content ui-widget-content"><p align="center">' + $(this).attr('lang') + '</p></div></div>');
		
		if($(this).attr('title')) {
			var title = $(this).attr('title');
		}
		else {
			var title = null;
		}

		$('#vkNgine-loaded-content').load($(this).attr('rel'), null, function() {
			if(title) {
				$('html').find('title').text(title);
			}
		});	
	});
	
	// Navigation menu
	$('ul#navigation').superfish({ 
		delay:       100,
		animation:   {opacity:'show',height:'show'},
		speed:       'fast',
		autoArrows:  true,
		dropShadows: false
	});

	$('ul#navigation li').hover(function(){
		$(this).addClass('sfHover2');
	},
	function(){
		$(this).removeClass('sfHover2');
	});
	
	$('#search-bar input[name="q"]').liveSearch({url: '/admin/index/search/q/'});
	
	//Hover states on the static widgets

	$('.ui-state-default').hover(
		function() { $(this).addClass('ui-state-hover'); }, 
		function() { $(this).removeClass('ui-state-hover'); }
	);
	
	$(function() {
		$('.tooltip').tooltip({
				track: true,
				delay: 0,
				showURL: false,
				showBody: " - ",
				fade: 250
			});
		});
	
	// Simple drop down menu

	var myIndex, myMenu, position, space=20;
	
	$("div.sub").each(function(){
		$(this).css('left', $(this).parent().offset().left);
		$(this).slideUp('fast');
	});
	
	$(".drop-down li").hover(function(){
		$("ul",this).slideDown('fast');
		
		//get the index, set the selector, add class
		myIndex = $(".main1").index(this);
		myMenu = $(".drop-down a.btn:eq("+myIndex+")");
	}, function(){
		$("ul",this).slideUp('fast');
	});
});

