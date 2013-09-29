var vkNgineModals = function() {
	var calendar = function(mode) {
		if(!mode) {
			$('.vkNgine-modal').on('click', function() {
				$id = $(this).data('id');
	    		$id = (($id) ? $id : 0);
	    		
	    		$target = $(this).data('target');
	    		$modal = $("#vkNgine-modal-" + $(this).data('target'));
	    		
		  		$('body').modalmanager('loading');
		  		_($target);
		  		switch($target) {
	  				case 'addexercise':
	  					$.ajax( {
	  				        url: '/calendar/add-daily/forward/' + $(this).data('action') + '/date/' + $(this).data('date'),
	  				        success: function(html) { 
	  				        	$modal.html(html);
	  			  			    $modal.modal();		           
	  				    	}
	  				    });
	  					break;
	  				case 'viewdetail':
	  					$modal.modal();
  						//lnk_viewDetail($(this).attr('rel'), 'Error Message', 'Exercise was successfully deleted');
  						return false;
	  					break;
	  				case 'viewdaydetail':
	  					//lnk_viewDayDetail('Delete', 'Close', $(this).attr('rel'), 'Day Details', 'Error Message', 'Day detail was successfully deleted');
						return false;
	  					break;
	  				case 'daydetail':
	  					day = $(this).attr('rel');
  						date = explode('-', $(this).attr('rel'));
  						dateStr = date[1] + '/' + date[2] + '/' + date[0];
  						//lnk_dayDetail('Save', 'Close', day, 'Adding Day Details:' + dateStr, 'action');
  						return false;
	  					break;
		  		}
			});
		}
		else {
			switch(mode) {
				case 'add-exercise':
					$('button.submit').bind('click', function() {
						$('#vkNgine-modal-addexercise form').submit();	   
					});
					
					var options = {  
						url: '/calendar/add-daily',
				        dataType : 'json'
				    };
				  
					$('#vkNgine-modal-addexercise form').ajaxForm(options);
		
					$('#workoutDay-label').hide();
					$('#workoutDay-element').hide();
		
					$(".setdays").change(function(){
						var selected = $(".setdays option:selected");    
						if(selected.val()){
							$('#workoutDay-element').show();			
							$.ajax({ 
								url: '/calendar/set-workout-day/id/' + selected.val(),
								success: function(returnData) {
									$('dd#workoutDay-element').html(returnData);
								}
							});
							
							$('#type').hide();
							$('#moreDetails').hide();
							$('#activity').hide();
						}
						else {
							$('#type').show();
							$('#moreDetails').show();
							$('#activity').show();
							$('#workoutDay-label').hide();
							$('#workoutDay-element').hide();
						}
					});
		
					$("#type").change(function(){
						var selected = $("#type option:selected");  
						if(selected.val()){
							$(".setdays").hide();
						}
						else {
							$(".setdays").show();
						}
					});
					break;
			}
		}
	};
	
	return {        
	    calendar: function(mode) {
	       	$.fn.modalmanager.defaults.resize = true;
			$.fn.modalmanager.defaults.spinner = '<div class="loading-spinner fade" style="width: 200px; margin-left: -100px;"><img src="/images/ajax-modal-loading.gif" align="middle">&nbsp;<span style="font-weight:300; color: #eee; font-size: 18px; font-family:Open Sans;">&nbsp;Loading...</div>';
	
			calendar(mode);
		},
	};
}();
