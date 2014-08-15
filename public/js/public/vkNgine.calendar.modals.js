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
					function hideActivity() {
						$('#workoutDay-label').hide();
						$('#workoutDay-element').hide();
						$('#moreDetails').hide();
						$('#timeSpentHour').hide();
						$('#timeSpentHour-label').hide();
						$('#timeSpentMin').hide();
						$('#timeSpentMin-label').hide();
						$('#miles').hide();
						$('#miles-label').hide();
						$('#type-element').hide();
						$('#workoutId').hide();
					}
					
					function hideExercise() {
						$('#workoutId').hide();
						$('#workoutDay-label').hide();
						$('#workoutDay-element').hide();
					}
					
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
					
					$("#activityorexercise span").bind('click', function() {
						var type = $(this).data('type');
						if( 'activity' == type) {
							$(this).attr('style', 'font-weight:bold;');
							
							$('#type-element').show();
							$('#type').show();
							
							hideExercise();
							
							$('#activityorexercise').find('.exercise').attr('style', '');
						}
						else if( 'exercise' == type) {
							$(this).attr('style', 'font-weight:bold;');

							$('#type-element').hide();
							
							hideActivity();
							
							$('#workoutId').show();
														
							$('#activityorexercise').find('.activity').attr('style', '');
						}
					});
		
					hideActivity();
					
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
						}
						else {
							$('#type').show();
							$('#workoutDay-label').hide();
							$('#workoutDay-element').hide();
						}
					});
		
					$("#type").change(function(){
						var selected = $("#type option:selected");
						if(selected.val()) {
							$('#moreDetails').show();
							$('#timeSpentHour').show();
							$('#timeSpentHour-label').show();
							$('#timeSpentMin').show();
							$('#timeSpentMin-label').show();
							
							if('Running' == selected.val()) {
								$('#miles').show();
								$('#miles-label').show();
							}
							else {
								$('#miles').hide();
								$('#miles-label').hide();
							}
						}
						else {
							$('#moreDetails').hide();
							$('#timeSpentHour').hide();
							$('#timeSpentHour-label').hide();
							$('#timeSpentMin').hide();
							$('#timeSpentMin-label').hide();
							$('#miles').hide();
							$('#miles-label').hide();
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
					        	$(window).attr("location","/calendar");
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
