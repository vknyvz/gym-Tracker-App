

function btn_exerciseDetail(id)
{
	var dialog_buttons = {};
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	vkNgineDialogHandler('btn_exerciseDetail_dialog', 700, dialog_buttons);
	
	$.ajax({ 
		url: '/index/view/id/' + id + '/ajax/1',
		success: function(returnData) {
			$('.btn_exerciseDetail_dialog').html(returnData);
		}
	})
	
}

function btn_add_selected_workouts(){					
	exerciseIdsString = $('input[name="exercises[]"]').filter(':checked').map(function(i,n) {
         return $(n).val();
	}).get();
	
	if(exerciseIdsString.length != 0) {
		$.ajax( {
	        url: '/index/add-selected-exercises/exerciseIds/' + exerciseIdsString,
	        success: function(returnData) { 
		        $('.add_selected_workouts_dialog').html(returnData);		           
	    }});
	}
	else{
		alert('Select at least one exercise');
		return;
	}
}
