var vkNgineModals = function() {
	var calendar = function(mode) {
		if(!mode) {
			$('.vkNgine-modal').on('click', function() {
				$id = $(this).data('id');
	    		$id = (($id) ? $id : 0);
	    		
	    		$target = $(this).data('target');
	    		$modal = $("#vkNgine-modal-" + $(this).data('target'));
	    		
		  		$('body').modalmanager('loading');
		  		
		  		switch($target) {
	  				case 'addexercise':
	  					$.ajax( {
	  				        url: '/calendar/add-daily/forward/' + $(this).data('action') + '/date/' + $(this).data('date'),
	  				        success: function(html) { 
	  				        	$modal.html(html);
	  			  			    $modal.modal();		           
	  				    	}
	  				    });
	  					
	  					return;
	  					break;
	  				case 'viewdetail':
	  					$.ajax( {
	  				        url: '/calendar/view-detail/id/' + $id,
	  				        success: function(html) { 
	  				        	$modal.html(html);
	  				        	$modal.modal();
	  				    	}
	  				    });
	  					
	  					return false;
	  					break;
	  				case 'viewdaydetail':
	  					$.ajax( {
	  				        url: '/calendar/view-day-detail/id/' + $id,
	  				        success: function(html) { 
	  				        	$modal.html(html);
	  				        	$modal.modal();	           
	  				    	}
	  				    });
	  					
						return false;
	  					break;
	  				case 'daydetail':
	  					$.ajax( {
	  				        url: '/calendar/daily-detail/forward/' + $(this).data('action') + '/date/' + $(this).data('date'),
	  				        success: function(html) { 
	  					        $modal.html(html)
	  					        $modal.modal();
	  				    	}
	  				    });

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
						
						$('#vkNgine-modal-addexercise').modal('hide');	
						
						$(window).attr("location","/calendar");
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
				case 'add-daily-detail':
					$('button.submit').bind('click', function() {
						$('#vkNgine-modal-daydetail form').submit();
						$('#vkNgine-modal-daydetail').modal('hide');	
						
						$(window).attr("location","/calendar");
					});
					
					var options = {  
						url: '/calendar/daily-detail',
						dataType : 'json'
				    };
				    
					$('#vkNgine-modal-daydetail form').ajaxForm(options);

					$('#value').hide();
					$('#color').hide();
					$('.help-inline-type').show();
					$('.help-inline-color').hide();

					$("#type").change(function(){
						var selected = $("#type option:selected");    
						
						if(selected.val() == 'COLOR'){
							$('#value').hide();
							$('#color').show();
							$('.help-inline-type').hide();
							$('.help-inline-color').show();
						}
						else if(selected.val() == 'SUPPLEMENT'){
							$('#value').show();
							$('#color').hide();
							$('.help-inline-type').hide();
							$('.help-inline-color').hide();
						}
						else {
							$('#value').hide();
							$('#color').hide();
							$('.help-inline-type').show();
							$('.help-inline-color').hide();
						}
					});
					
					break;
				case 'view-day-detail':
					$('button.submit').bind('click', function() {
						$.ajax( {
					        url: '/calendar/delete-day-detail/id/' + $id,
					        success: function(data) { 
					    	}
					    });
					});
					
					break;
				case 'delete-daily-exercise':
					$('button.submit').bind('click', function() {
						$.ajax( {
					        url: '/calendar/delete-daily-log/id/' + $id,
					        success: function(data) { 
					    	}
					    });
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
