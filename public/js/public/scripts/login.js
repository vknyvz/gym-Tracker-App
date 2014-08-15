var Login = function () {
	
	console.log('Login page initialized! - v1.5.616');
	
    var loginHandler = function(data) {
    	if(!data.success){
			$('#username').closest('.control-group').addClass('error');
			$('#password').closest('.control-group').addClass('error');
			
			$('.alert-error').removeClass('hide');
			$('.alert-error span').text(data.message);
		}
		else {
			$('#username').closest('.control-group').addClass('success');
			$('#password').closest('.control-group').addClass('success');

			window.top.location = data.href;
		}    		
	}
    
    return {
        init: function () {
        	
        	$("#username").focus();
        	
	        $('#forget-password').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.forget-form').show();
	        });

	        $('#back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.forget-form').hide();
	        });	        	        
 	
			var options = {  
				url: '/auth/login/',
		        success: loginHandler,
				dataType : 'json'
		    };
		    
			$('#publicFormLogin').ajaxForm(options);
        }
    };

}();