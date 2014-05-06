/**
 * vkNgine.dashboard.js
 *  
 */
vkNgine.page = vkNgine.page || {};

(function () {
	"use strict";
	
	vkNgine.page.dashboard = function() {	
    };
    
    vkNgine.page.dashboard.method = function (name, fn) {
    	if('undefined' !== typeof vkNgine && 'undefined' !== typeof vkNgine.page && 'undefined' !== typeof vkNgine.page.dashboard) {
			this.prototype[name] = fn;
		}
    };
    
    vkNgine.page.dashboard.method( 'counters', function (end_number, _class, fraction) {
    	$("." + _class + " span").flipCounter(
    		"startAnimation", 
    		{
    			number: 0,
    			end_number: end_number,
    			imagePath:"images/flipCounter-medium.png",
    			numFractionalDigits: fraction,
    			duration:3000,
    		}
        );
    });
    
    vkNgine.page.dashboard.method( 'dateRanger', function () {
    	var core = new vkNgine.core.engine();
    	
    	$('#dashboard-report-range').daterangepicker({
            ranges: {
                'Today': ['today', 'today'],
                'Yesterday': ['yesterday', 'yesterday'],
                'Last 7 Days': [Date.today().add({
                        days: -6
                    }), 'today'],
                'Last 30 Days': [Date.today().add({
                        days: -29
                    }), 'today'],
                'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                'Last Month': [Date.today().moveToFirstDayOfMonth().add({
                        months: -1
                    }), Date.today().moveToFirstDayOfMonth().add({
                        days: -1
                    })]
            },
            opens: 'left',
            format: 'MM/dd/yyyy',
            separator: ' to ',
            startDate: Date.today().add({
                days: -0
            }),
            endDate: Date.today(),
            minDate: '01/01/2012',
            maxDate: '12/31/2015',
            locale: {
                applyLabel: 'Submit',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            showWeekNumbers: true,
            buttonClasses: ['btn-danger']
        },

        function (start, end) {
        	core.blockUI(jQuery("#dashboard"));
        	
        	var _start = start.toString('yyyy-MM-dd');
        	var _end = end.toString('yyyy-MM-dd');
        	
        	var _today = Date.today().toString('yyyy-MM-dd');
        	
        	var yesterday = new Date();
        		yesterday.setDate(yesterday.getDate() - 1);
        	
        	var _yesterday = yesterday.toString('yyyy-MM-dd');
        	
        	var last7days = new Date();
        		last7days.setDate(last7days.getDate() - 6);
        	var last30days = new Date();
        		last30days.setDate(last30days.getDate() - 29);        		
        	
        	var _last7days = last7days.toString('yyyy-MM-dd');
        	var _last30days = last30days.toString('yyyy-MM-dd');
        		
        	var date = new Date();
        	var firstDayThisMonth = new Date(date.getFullYear(), date.getMonth(), 1);
        	var lastDayThisMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        	var _firstDayThisMonth = firstDayThisMonth.toString('yyyy-MM-dd'); 
        	var _lastDayThisMonth = lastDayThisMonth.toString('yyyy-MM-dd');
        	
        	var firstDayLastMonth = new Date(date.getFullYear(), date.getMonth() -1, 1);
        	var lastDayLastMonth = new Date(date.getFullYear(), date.getMonth(), 0);
        	var _firstDayLastMonth = firstDayLastMonth.toString('yyyy-MM-dd'); 
        	var _lastDayLastMonth = lastDayLastMonth.toString('yyyy-MM-dd');
        	
        	var get;
        	if(_start == _today && _end == _today) {
        		get = 'mode/today';
        	}
        	else if(_start == _yesterday && _end == _yesterday) {
        		get = 'mode/yesterday';
        	}   
        	else if(_start == _last7days && _end == _today) {
        		get = 'mode/last7days';
        	}
        	else if(_start == _last30days && _end == _today) {
        		get = 'mode/last30days';
        	}
        	else if(_start == _firstDayThisMonth && _end == _lastDayThisMonth) {
        		get = 'mode/thismonth';
        	}
        	else if(_start == _firstDayLastMonth && _end == _lastDayLastMonth) {
        		get = 'mode/lastmonth';
    		}
        	else {
        		get = 'date1/' + start.toString('yyyy-MM-dd') + '/date2/' + end.toString('yyyy-MM-dd');
        	}
        	
        	$.get("/index/refresh-dashboard/" + get, function( html ) {
        		core.unblockUI(jQuery("#dashboard"));
        		
	        	$.gritter.add({
	        		title: 'Dashboard',
	                text: 'Dashboard date range updated.'
	            });
	        	
	        	$('#counters').replaceWith(html);
        	});
        	
        	$('#dashboard-report-range span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
            $('.caption').text('Statistics -- ' + start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));            
        });

        $('#dashboard-report-range').show();

        $('#dashboard-report-range span').html(Date.today().add({
            days: -0
        }).toString('MMMM d, yyyy') + ' - ' + Date.today().toString('MMMM d, yyyy'));
    });        
})();