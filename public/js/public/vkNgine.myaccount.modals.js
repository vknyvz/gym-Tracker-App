var vkNgineModals = function() {
    var myAccount = function(mode, setsaved, repsaved, ordersaved) {
    	$('.date-picker').datepicker({
    		format: 'yyyy-mm-dd'
    	});
    	
    	$('.vkNgine-modal').on('click', function() {
    		$id = $(this).data('id');
    		$target = $(this).data('target');
    		$modal = $("#vkNgine-modal-" + $(this).data('target'));
    		
	  		$('body').modalmanager('loading');
	  		
	  		switch($target) {
	  			case 'editworkout':
			  		$.ajax({ 
			  		   url: '/my-account/edit-workout/workoutId/' + (($id) ? $id : 0),
			  		   success: function(html) {  						
			  			  $modal.html(html);
			  			  $modal.modal();
			  			}
			  		});	  
			  		break;
		  		case 'manageworkout':
		  			$.ajax({ 
		  				url: '/my-account/manage-workout/id/' + $id,
		  				success: function(html) {
		  					$modal.html(html);
				  			$modal.modal();
		  				}
		  			})	
		  			break;
		  		case 'exercisedetail':
		  			$.ajax({ 
		  				url: '/index/view/id/' + $id + '/ajax/1',
		  				success: function(html) {
		  					$modal.html(html);
				  			$modal.modal();
		  				}
		  			})
		  		case 'deleteworkout':
		  			$modal.modal();
		  			$('#vkNgine-modal-' + $(this).data('target') + ' .submit').bind('click', function() {
		  				$.ajax( {
		  					url: "/my-account/delete-workout/id/" + $id,
		  					dataType : 'json',
		  					success: function(data) {
		  						window.top.location = '/my-account/my-workouts';
		  					}
		  				});	
		  			});
		  			break;
	  		}
  		});
    	
    	switch(mode){
	    	case 'manage-workout':
	    		$('.setField').bind('mouseleave', function() {
	    			var id = $(this).data('id') 
	    			var val = $(this).val();
	    			var field = $(this).data('field');
	    			
	    			if(val){
	    				$.ajax({
	    			        url: '/my-account/edit-setfield/field/' + field + '/id/' + id + '/value/' + val,
	    			        dataType : 'json',
	    			        success: function(data) {
	    				        if(data.success) 	
	    					        if(field == 'sets') {
	    					        	$('#set-saved-' + id).show();
	    				        		$('#set-saved-' + id).html(setsaved).fadeOut(3000);
	    					        }
	    					        else if(field == 'reps') {
	    					        	$('#rep-saved-' + id).show();
	    			        			$('#rep-saved-' + id).html(repsaved).fadeOut(3000);
	    					        }
	    					        else if(field == 'order') {
	    					        	$('#order-saved-' + id).show();
	    			        			$('#order-saved-' + id).html(ordersaved).fadeOut(3000);
	    					        }
	    			    	}
	    			       }
	    			    );
	    			}
	    		});	
	    		break;
	    	case 'edit-workout':
	    		$('button.submit').bind('click', function(data) {
	    			$('#vkNgine-modal-editworkout form').submit();	    			
	    			
	    			location.reload(true);
	        	});
	        	
	        	var options = {  
	        		url: '/my-account/edit-workout',
	                dataType : 'json'
	            };
	        	   
	        	$('#vkNgine-modal-editworkout form').ajaxForm(options);
		        break;
    	}
    }
    
    return {        
        myAccount: function(mode, setsaved, repsaved, ordersaved) {
           	$.fn.modalmanager.defaults.resize = true;
    		$.fn.modalmanager.defaults.spinner = '<div class="loading-spinner fade" style="width: 200px; margin-left: -100px;"><img src="/images/ajax-modal-loading.gif" align="middle">&nbsp;<span style="font-weight:300; color: #eee; font-size: 18px; font-family:Open Sans;">&nbsp;Loading...</div>';

    		myAccount(mode, setsaved, repsaved, ordersaved);
    	},
    };
}();