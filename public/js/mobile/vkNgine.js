$(document).ready(function () {
	setTimeout(function() {
		if(window.pageYOffset !== 0) return;
		window.scrollTo(0, window.pageYOffset + 1);

	}, 1000);
	
	$(".notification").click(function(){
		  $('.notification-wrapper').fadeOut("slow");
		  return false;
	});
	
	$('.load').bind('click', function() {
		$('#content-load').show();
		
		rel = $(this).attr('rel');
		if(rel == '/my-account'){
			$('.my-account').addClass('selected');
			$('.exercises').removeClass('selected');
			$('.calendar').removeClass('selected');
			$('.home').removeClass('selected');
			
			$('body').attr('id', null);
			$('.navigation').css('margin-left', '-10px');
		}
		else if(rel == '/index/exercises'){
			$('.exercises').addClass('selected');
			$('.my-account').removeClass('selected');
			$('.calendar').removeClass('selected');
			$('.home').removeClass('selected');
		}
		else if(rel == '/calendar'){
			$('.calendar').addClass('selected');
			$('.my-account').removeClass('selected');
			$('.exercises').removeClass('selected');
			$('.home').removeClass('selected');
			
			$('body').attr('id', null);
			$('.navigation').css('margin-left', '-10px');
		}
		else if(rel == '/auth/login/logout'){
			window.top.location = "/auth/login/logout";
		}
		$('#content').load(rel, null, function() {
			$('#content-load').hide();
		});	
	});	
});

function vkNgineAjaxFormSubmit(data) {
	if (!data.success)  {
		vkNgineAjaxFormSubmitError(data);
	} 
	else {
		$('#content-load').show();
		
		$.gritter.add({
			title: data.title,
			text: data.message,
			image: '/images/mobile/icon/'+data.icon+'.png',
			class_name: 'gritter-mobile-wrapper',
			after_open: function(e){
				$('#' + data.loadOn).load(data.loadThis, null, function() {
					$('#content-load').hide();
				});
			},
			sticky: false,
			time: 3000
		});
	}		
}

function vkNgineAjaxFormSubmitError(data) {
	$.gritter.add({
		title: '' + data.title +'',
		text: '' + data.message +'',
		class_name: 'gritter-mobile-wrapper',
		image: '/images/mobile/icon/' + data.icon + '.png'
	});
}