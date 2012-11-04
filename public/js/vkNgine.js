$(document).ready(function(){
	
	// iPad settings
	var isiPad = navigator.userAgent.match(/iPad/i) != null;
	  
	if(isiPad) {
	    $('body').prepend('<div id="rotatedevice"><h1>Please rotate your device 90 degrees.</div>');
	}
	
	// datatable settings
	$('.datatable').dataTable({
	      "sPaginationType": "full_numbers",
	      "bStateSave": true
    });
  
    $('.dataTables_wrapper').each(function() {
      var table = $(this);
      var info = table.find('.dataTables_info');
      var paginate = table.find('.dataTables_paginate');
    
      table.find('.datatable').after('<div class="action_bar nomargin"></div>');
      table.find('.action_bar').prepend(info).append(paginate);
    });
	
	// select skin
	$('select').select_skin();
	
	// tooltips
	$('.tooltip').tipsy();
	
	// checkboxes and radio buttons
	$('input[type=checkbox], input[type=radio]').prettyCheckboxes();
  
	// vkNgine footer logo
	$(".footer").hide().fadeIn(1e3);
});

function explode (delimiter, string, limit) {
    var emptyArray = {
        0: ''
    };

    // third argument is not required
    if (arguments.length < 2 || typeof arguments[0] == 'undefined' || typeof arguments[1] == 'undefined') {
        return null;
    }

    if (delimiter === '' || delimiter === false || delimiter === null) {
        return false;
    }

    if (typeof delimiter == 'function' || typeof delimiter == 'object' || typeof string == 'function' || typeof string == 'object') {
        return emptyArray;
    }

    if (delimiter === true) {
        delimiter = '1';
    }

    if (!limit) {
        return string.toString().split(delimiter.toString());
    }
    // support for limit argument
    var splitted = string.toString().split(delimiter.toString());
    var partA = splitted.splice(0, limit - 1);
    var partB = splitted.join(delimiter.toString());
    partA.push(partB);
    return partA;
}
