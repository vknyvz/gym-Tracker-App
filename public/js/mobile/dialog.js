function loginHandler(data){
	if(!data.success){
		$('#error').show();
		$('.text-input').css('border-color', 'red');
	}
	else {
		$('#error').hide();
		window.top.location = data.href;
	}
}