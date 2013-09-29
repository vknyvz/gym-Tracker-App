/**
 * vkNgine.calendar.js
 *  
 */
vkNgine.page = vkNgine.page || {};

(function () {
	"use strict";
	
	vkNgine.page.calendar = function() {	
    };
    
    vkNgine.page.calendar.method = function (name, fn) {
    	if ( 'undefined' !== typeof vkNgine && 'undefined' !== typeof vkNgine.page && 'undefined' !== typeof vkNgine.page.calendar ) {
			this.prototype[ name ] = fn;
		}
    };
    
    vkNgine.page.calendar.method( 'calendar', function (today, prev, next, notCurrentMonth) {
    	$('.fc-button-prev').bind('click', function() {
    		window.top.location = prev; 
		});
    	
		$('.fc-button-next').bind('click', function() {
			window.top.location = next;
		});
		
		$('.fc-button-today').bind('click', function() {
			window.top.location = today;
		});
		
		$('.fc-button-today').addClass(notCurrentMonth);
		
		$('.fc-button-month').bind('click', function() {
			window.top.location = '/calendar/monthly';
		});
		
		$('.fc-button-agendaWeek').bind('click', function() {
			window.top.location = '/calendar/weekly';
		});

		$("table.fc-border-separate tbody tr:first").addClass('fc-first');	
		$("table.fc-border-separate tbody tr:last").addClass('fc-last');		
    });
})();
