function lnk_addExercise(date, title, action) {
	$.ajax( {
        url: '/calendar/add-daily/forward/' + action + '/date/' + date,
        success: function(returnData) { 
	        $('.addexercise_dialog').html(returnData);		           
    	}
       }
    );
}

function btn_editworkout(id) {
	$.ajax({ 
		url: '/my-account/edit-workout/workoutId/' + ((id) ? id : 0),
		success: function(returnData) {
			$('.editworkout_dialog').html(returnData);
		}
	})
}

function btn_editmeasurements(id) {
	if(!id) {
		id = 0;
	}

	$.ajax({ 
		url: '/my-account/edit-measurement/id/' + id,
		success: function(returnData) {
			$('.editmeasurements_dialog').html(returnData);
		}
	})
}

function btn_manageworkout(id) {
	$.ajax({ 
		url: '/my-account/manage-workout/id/' + id,
		success: function(returnData) {
			$('.manageworkout_dialog').html(returnData);
		}
	})
}

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

function btn_deleteworkout(id) {
	$('#deleteworkout_dialog').attr('rel', id);
	$('#deleteworkout_dialog .btn-primary').bind('click', function() {
		$.ajax( {
			url: "/my-account/delete-workout/id/" + id,
			dataType : 'json',
			success: function(returnData) {
				$('.btn-deleteworkout-dialog').dialog('close');				
				window.top.location = '/my-account/my-workouts';
			}
		});	
	});
}

function btn_deletemeasurement(yes, no, id) {
	var dialog_buttons = {};
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	dialog_buttons[yes] = function() { 
		$.ajax( {
			url: "/my-account/delete-measurement/id/" + id,
			dataType : 'json',
			success: function(returnData) {
				$('.btn_deletemeasurement').dialog('close');
				
				window.top.location = '/my-account';
			}
		}) 
	}
	
	vkNgineDialogHandler('btn_deletemeasurement-dialog', 400, dialog_buttons);
}

function lnk_viewDetail(id, successTitle, successMessage){
	
	
	if(false) {
		$.ajax({
	        url: '/calendar/delete-daily-log/id/' + id,
	        success: function(returnData) { 
		       $.gritter.add({
					title: successTitle,
					text: successMessage,
					image: '/images/admin/icons/success.png',
					sticky: false,
					time: 3000
				});
		       window.top.location = '/calendar';
	    	}
		});
	}

	$.ajax( {
        url: '/calendar/view-detail/id/' + id,
        success: function(returnData) { 
        	
	        $('.viewDetails-dialog').html(returnData);	       
    	}
    });		
}

function lnk_viewDayDetail(yes, no, id, title, successTitle, successMessage){
	var dialog_buttons = {};
	
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	dialog_buttons[yes] = function() { 
		$.ajax( {
	        url: '/calendar/delete-day-detail/id/' + id,
	        success: function(returnData) { 
		       $('#lnk-viewDayDetails-dialog').dialog('close');	
		       $.gritter.add({
					title: successTitle,
					text: successMessage,
					image: '/images/admin/icons/success.png',
					sticky: false,
					time: 3000
				});
		       window.top.location = '/calendar';
	    	}
	       }
	    );
	}
	
	$('.lnk-viewDayDetails-dialog').dialog({
		title: title,
	});
	
	vkNgineDialogHandler('lnk-viewDayDetails-dialog', 450, dialog_buttons);
	
	$.ajax( {
        url: '/calendar/view-day-detail/id/' + id,
        success: function(returnData) { 
	        $('.lnk-viewDayDetails-dialog').html(returnData);		           
    	}
       }
    );
}

function lnk_dayDetail(yes, no, date, title, action){
	var dialog_buttons = {};
	
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	dialog_buttons[yes] = function() { 
		$('#publicFormDailyDetails').submit();
	}
	
	$('.lnk-dailyDetails-dialog').dialog({
		title: title,
	});
	
	vkNgineDialogHandler('lnk-dailyDetails-dialog', 450, dialog_buttons);
	
	$.ajax( {
        url: '/calendar/daily-detail/forward/' + action + '/date/' + date,
        success: function(returnData) { 
	        $('.lnk-dailyDetails-dialog').html(returnData);		           
    	}
       }
    );
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

function loginHandler(data) {
	if(!data.success){
		$('#username').closest('.control-group').addClass('error');
		$('#password').closest('.control-group').addClass('error');
	}
	else {
		$('#username').closest('.control-group').addClass('success');
		$('#password').closest('.control-group').addClass('success');		
		window.top.location = data.href;
	}
}

function vkNgineDialogHandler(_class, width, buttons){
	$("#" + _class + "").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width: width,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: buttons
	});
	
    $("#" + _class + "").dialog('option', 'position', 'center');
	$("#" + _class + "").dialog('open');
}

function vkNgineAjaxFormSubmit(data) {
	if (!data.success)  {
		vkNgineAjaxFormSubmitError(data);
	} 
	else {
		if(data.href) {
			window.top.location = data.href;
		}
		else if(data.stayPut) {
			$.gritter.add({
				title: data.title,
				text: data.message,
				image: '/images/admin/icons/'+data.icon+'.png',
				sticky: false,
				time: 3000
			});
		}
		else {
			//$('#' + data.dialog).dialog('close');
			
			if(data.row) {
				if(data.newRow.mode == 'add'){
					$('#' + data.newRow.templateName).tmpl(data.newRow).appendTo($('#sort-table tbody')).hide().fadeIn('slow');
				}
				else {
					$('#' + data.newRow.rowId + ''+ data.newRow.itemId).after($('#' + data.newRow.templateName).tmpl(data.newRow));
					$('#' + data.newRow.rowId + ''+ data.newRow.itemId).remove();
				}
			}
			
			$.gritter.add({
				title: data.title,
				text: data.message,
				image: '/images/admin/icons/'+data.icon+'.png',
				sticky: false,
				time: 3000
			});
		}
	}		
}

function vkNgineAjaxFormSubmitError(data) {
	$.gritter.add({
		title: '' + data.title +'',
		text: '' + data.message +'',
		image: '/images/admin/icons/' + data.icon + '.png'
	});
}