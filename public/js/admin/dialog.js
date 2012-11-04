function btn_logout(yes, no, href) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		window.top.location = href;
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	$("#btn-logout-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:450,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	
	$('#btn-logout-dialog').dialog('open');
}

function btn_myaccount(yes, no, href) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$('#adminFormMyAccount').submit();
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	$("#btn-myaccount-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:450,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	$('#btn-myaccount-dialog').dialog('open');
	$.ajax({ 
		url: href,
		success: function(returnData) {
			$('#btn-myaccount-dialog').html(returnData);
		}
	})
}

function btn_edituser(yes, no, href, id, title) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$('#adminFormUsersEdit').submit();
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	if(!id) {
		id = 0;
	}
	
	$("#btn-edituser-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:865,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	$('#btn-edituser-dialog').dialog('option', 'title', title);
	$('#btn-edituser-dialog').dialog('open');
	$.ajax({ 
		url: href + '/userId/' + id,
		success: function(returnData) {
			$('#btn-edituser-dialog').html(returnData);
		}
	})
}

function btn_editexercise(yes, no, href, id, title) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$('#adminFormExercisesEdit').submit();
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	if(!id) {
		id = 0;
	}
	
	$("#btn-editexercise-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:865,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	$('#btn-editexercise-dialog').dialog('option', 'title', title);
	$('#btn-editexercise-dialog').dialog('open');
	$.ajax({ 
		url: href + '/exerciseId/' + id,
		success: function(returnData) {
			$('#btn-editexercise-dialog').html(returnData);
		}
	})
}

function btn_editworkout(yes, no, href, id, title) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$('#adminFormWorkoutsEdit').submit();
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	if(!id) {
		id = 0;
	}
	
	$("#btn-editworkout-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:450,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	$('#btn-editworkout-dialog').dialog('option', 'title', title);
	$('#btn-editworkout-dialog').dialog('open');
	$.ajax({ 
		url: href + '/workoutId/' + id,
		success: function(returnData) {
			$('#btn-editworkout-dialog').html(returnData);
		}
	})
}

function btn_addexercisetoworkout(yes, no, href, id, title) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$('#adminFormWorkoutsExercisesEdit').submit();
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	if(!id) {
		id = 0;
	}
	
	$("#btn-addexercisetoworkout-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:525,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	$('#btn-addexercisetoworkout-dialog').dialog('option', 'title', title);
	$('#btn-addexercisetoworkout-dialog').dialog('open');
	$.ajax({ 
		url: href + '/workoutId/' + id,
		success: function(returnData) {
			$('#btn-addexercisetoworkout-dialog').html(returnData);
		}
	})
}

function btn_addfoodtomeal(yes, no, href, id, title) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$('#adminFormMealsFoodsEdit').submit();
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	if(!id) {
		id = 0;
	}
	
	$("#btn-addfoodstomeals-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:525,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	$('#btn-addfoodstomeals-dialog').dialog('option', 'title', title);
	$('#btn-addfoodstomeals-dialog').dialog('open');
	$.ajax({ 
		url: href + '/mealId/' + id,
		success: function(returnData) {
			$('#btn-addfoodstomeals-dialog').html(returnData);
		}
	})
}

function btn_editmeal(yes, no, href, id, title) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$('#adminFormMealsEdit').submit();
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	if(!id) {
		id = 0;
	}
	
	$("#btn-editmeal-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:450,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	$('#btn-editmeal-dialog').dialog('option', 'title', title);
	$('#btn-editmeal-dialog').dialog('open');
	$.ajax({ 
		url: href + '/mealId/' + id,
		success: function(returnData) {
			$('#btn-editmeal-dialog').html(returnData);
		}
	})
}

function btn_editfood(yes, no, href, id, title) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$('#adminFormFoodsEdit').submit();
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	if(!id) {
		id = 0;
	}
	
	$("#btn-editfood-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:450,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	$('#btn-editfood-dialog').dialog('option', 'title', title);
	$('#btn-editfood-dialog').dialog('open');
	$.ajax({ 
		url: href + '/foodId/' + id,
		success: function(returnData) {
			$('#btn-editfood-dialog').html(returnData);
		}
	})
}

function btn_cacheclear_dialog(yes, no, href) {
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$.ajax({ 
			url: href,
			dataType : 'json',
			success: function(data) {
				if(data.success){
					vkNgineAjaxFormSubmit(data);
					$("#btn-cacheclear-dialog").dialog('close'); 
				}
			}
		})
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	$("#btn-cacheclear-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:450,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	
	$('#btn-cacheclear-dialog').dialog('open');
}

function lnk_showDetails(no, id, href, field, title) {
	var dialog_buttons = {};
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	$('#lnk-showdetails-dialog').dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width: 300,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	
	$('#lnk-showdetails-dialog').dialog('option', 'title', title);
	$('#lnk-showdetails-dialog').dialog('open');
	
	$.ajax( {
        url: href + '/id/' + id + '/field/' + field, 
        success: function(returnData) { 
	        $('#lnk-showdetails-dialog').html(returnData);		           
    	}
       }
    );
}

var id = null;
function btn_deleteuser(yes, no, userId) {	
	id = userId;
	
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$.ajax( {
				url: "/admin/users/delete/userId/" + id,
				dataType : 'json',
				success: function(returnData) {
					$('#btn-deleteuser-dialog').dialog('close');
					
					$('#' + returnData.rowId + ''+ returnData.itemId).fadeOut('slow');
					
					$.gritter.add({
						title: returnData.title,
						text: returnData.message,
						image: '/images/admin/icons/'+returnData.icon+'.png',
						sticky: false,
						time: 3000
					});
			}
		}) 
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	$("#btn-deleteuser-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:500,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	
	$('#btn-deleteuser-dialog').dialog('open');
}

function btn_deleteexercise(yes, no, exerciseId) {	
	id = exerciseId;
	
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$.ajax( {
				url: "/admin/exercises/delete/exerciseId/" + id,
				dataType : 'json',
				success: function(returnData) {
					$('#btn-deleteexercise-dialog').dialog('close');
					
					$('#' + returnData.rowId + ''+ returnData.itemId).fadeOut('slow');
					
					$.gritter.add({
						title: returnData.title,
						text: returnData.message,
						image: '/images/admin/icons/'+returnData.icon+'.png',
						sticky: false,
						time: 3000
					});
			}
		}) 
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	$("#btn-deleteexercise-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:500,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	
	$('#btn-deleteexercise-dialog').dialog('open');
}

function btn_deleteworkout(yes, no, workoutId) {	
	id = workoutId;
	
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$.ajax( {
				url: "/admin/workouts/delete/workoutId/" + id,
				dataType : 'json',
				success: function(returnData) {
					$('#btn-deleteworkout-dialog').dialog('close');
					
					$('#' + returnData.rowId + ''+ returnData.itemId).fadeOut('slow');
					
					$.gritter.add({
						title: returnData.title,
						text: returnData.message,
						image: '/images/admin/icons/'+returnData.icon+'.png',
						sticky: false,
						time: 3000
					});
			}
		}) 
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	$("#btn-deleteworkout-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:500,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	
	$('#btn-deleteworkout-dialog').dialog('open');
}

function btn_deletemeal(yes, no, mealId) {	
	id = mealId;
	
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$.ajax( {
				url: "/admin/meals/delete/mealId/" + id,
				dataType : 'json',
				success: function(returnData) {
					$('#btn-deletemeal-dialog').dialog('close');
					
					$('#' + returnData.rowId + ''+ returnData.itemId).fadeOut('slow');
					
					$.gritter.add({
						title: returnData.title,
						text: returnData.message,
						image: '/images/admin/icons/'+returnData.icon+'.png',
						sticky: false,
						time: 3000
					});
			}
		}) 
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	$("#btn-deletemeal-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:500,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	
	$('#btn-deletemeal-dialog').dialog('open');
}

function btn_deletefood(yes, no, foodId) {	
	id = foodId;
	
	var dialog_buttons = {};
	dialog_buttons[yes] = function() { 
		$.ajax( {
				url: "/admin/foods/delete/foodId/" + id,
				dataType : 'json',
				success: function(returnData) {
					$('#btn-deletefood-dialog').dialog('close');
					
					$('#' + returnData.rowId + ''+ returnData.itemId).fadeOut('slow');
					
					$.gritter.add({
						title: returnData.title,
						text: returnData.message,
						image: '/images/admin/icons/'+returnData.icon+'.png',
						sticky: false,
						time: 3000
					});
			}
		}) 
	}
	dialog_buttons[no] = function() { 
		$(this).dialog('close'); 
	}
	
	$("#btn-deletefood-dialog").dialog({
		autoOpen: false,
		bgiframe: true,
		resizable: false,
		width:500,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: dialog_buttons
	});
	
	$('#btn-deletefood-dialog').dialog('open');
}

function btn_deleteselected(yes, no, itemName, baseHref, title, text) {
	count = countCheckedCheckboxes('input');
	if(count > 0) {
		ids = $('input:checked').map(function(i,n) {
        	return $(n).val();
	    }).get();

		var dialog_buttons = {};
		dialog_buttons[yes] = function() { 
			$.ajax( {
				dataType : 'json',
		        url: baseHref + "/ids/" + ids, 
		        success: function(data) { 
		        	$("#btn-deletelist-dialog").dialog('close');
		        	
		        	var arr = new Array();
		        	arr = ids.toString().split(',');
		        	
		        	for(id in arr){
		        		arr[id] = parseInt(arr[id]);
	                	$('#' + itemName + ''+ arr[id]).fadeOut('normal', function() {	
	                		$('#' + itemName + ''+ arr[id]).remove();
	                	});		                
		        	}
		        	
		        	$.gritter.add({
						title: title,
						text: text,
						image: '/images/admin/icons/success.png',
						sticky: false,
						time: 3000
					});
		    	}
		       }
		    )    
		}
		dialog_buttons[no] = function() { 
			$(this).dialog('close'); 
		}

		$("#btn-deletelist-dialog").dialog({
			autoOpen: false,
			bgiframe: true,
			resizable: false,
			width:450,
			modal: true,
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: dialog_buttons
		});
	    
		$("#btn-deletelist-dialog").dialog('open');
	}
	return false;
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
			$('#' + data.dialog).dialog('close');
			
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