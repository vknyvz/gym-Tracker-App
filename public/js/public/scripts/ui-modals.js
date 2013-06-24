var UIModals = function() {
    
    var initModals = function() {
       
       	$.fn.modalmanager.defaults.resize = true;
		$.fn.modalmanager.defaults.spinner = '<div class="loading-spinner fade" style="width: 200px; margin-left: -100px;"><img src="/images/ajax-modal-loading.gif" align="middle">&nbsp;<span style="font-weight:300; color: #eee; font-size: 18px; font-family:Open Sans;">&nbsp;Loading...</div>';
    }
    
    var myAccount = function() {
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
    }
   
    return {        
        init: function () {
            initModals(); 
        },
    
        myAccount: function() {
    		myAccount();
    	}
    };
}();