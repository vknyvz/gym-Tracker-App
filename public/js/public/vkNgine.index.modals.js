var vkNgineModals = function() {
	var index = function(mode) {
		if(!mode) {
			$('.vkNgine-modal').on('click', function() {
				$id = $(this).data('id');
	    		$id = (($id) ? $id : 0);
	    		
	    		$target = $(this).data('target');
	    		$modal = $("#vkNgine-modal-" + $(this).data('target'));
	    		
		  		$('body').modalmanager('loading');
		  		
		  		switch($target) {
	  				case 'addselectedworkouts':
	  					exerciseIdsString = $('input[name="exercises[]"]').filter(':checked').map(function(i,n) {
	  				         return $(n).val();
	  					}).get();
	  					
	  					if(exerciseIdsString.length != 0) {
	  						$.ajax( {
	  					        url: '/index/add-selected-exercises/exerciseIds/' + exerciseIdsString,
	  					        success: function(html) { 
	  					        	$modal.html(html);
		  			  			    $modal.modal();
	  					    }});
	  					}
	  					else{
	  						$modal.html("<div class='modal-header'> \
		  								<button type='button' class='close' data-dismiss='modal' aria-hidden='true'></button>\
		  								<h3>Notice</h3> \
		  								</div> \
		  								<div class='modal-body'><div class='alert alert-info'>You must select at least one exercise!</div></div> \
		  								<div class='modal-footer'> \
		  								<button class='btn' data-dismiss='modal' type='button'>Close</button> \
		  								</div>");
	  						$modal.modal();
	  					}
	  					
	  					return;
	  					break;
		  		}
			});
		}
		else {
			switch(mode) {
				case 'add-selected-workouts':	
					$('button.submit').bind('click', function() {
						$('#vkNgine-modal-addselectedworkouts form').submit();
					});
					
					var options = {  
						url: '/index/add-selected-exercises',
						dataType : 'json'
				    };
				    
					$('#vkNgine-modal-addselectedworkouts form').ajaxForm(options);
					
					$('label[for="day"]').hide();
					$('#day').hide();
					$('#day').next().hide();

					$(".setdays").change(function(){
						var selected = $(".setdays option:selected");    

						if(selected.val()){
							$('label[for="day"]').show();
							$('#day').show();
							$('#day').next().show();
							
							$.ajax({ 
								url: '/index/set-day/id/' + selected.val(),
								success: function(returnData) {
									$('#day').html(returnData);
								}
							})
						}
						else {
							$('label[for="day"]').hide();
							$('#day').hide();
							$('#day').next().hide();
						}
					});
					break;
			}
		}
	};
	
	return {        
	    index: function(mode) {
	       	$.fn.modalmanager.defaults.resize = true;
			$.fn.modalmanager.defaults.spinner = '<div class="loading-spinner fade" style="width: 200px; margin-left: -100px;"><img src="/images/ajax-modal-loading.gif" align="middle">&nbsp;<span style="font-weight:300; color: #eee; font-size: 18px; font-family:Open Sans;">&nbsp;Loading...</div>';
	
			index(mode);
		},
	};
}();
