/**
 * vkNgine.myaccount.js
 *  
 */
vkNgine.page = vkNgine.page || {};

(function () {
	"use strict";
	
	vkNgine.page.myaccount = function() {	
    };
    
    vkNgine.page.myaccount.method = function (name, fn) {
    	if ( 'undefined' !== typeof vkNgine && 'undefined' !== typeof vkNgine.page && 'undefined' !== typeof vkNgine.page.myaccount ) {
			this.prototype[ name ] = fn;
		}
    };
    
    vkNgine.page.myaccount.method( 'myaccount', function () { 
    	$('.description').addClass('warning');

    	$('.setCalendarView').change(function(){
    		var selected = $(".setCalendarView option:selected");    
    		if(selected.val()){
    			$.ajax( {
    				url: '/my-account/index/method/1/calendarview/1/value/' + selected.val(),
    				dataType : 'json',
    				
    				success: function(data) {
    					$.gritter.add({
    						title: data.title,
    						text: data.message,
    						image: '/images/admin/icons/success.png',
    						sticky: false,
    						time: 3000
    					});
    				}
    			});
    		}
    	});

    	$(".input-password").change(function(){
    		$.ajax( {
    			url: '/my-account/index/method/1/password/1/',
    			dataType : 'json',
    			type: 'POST',
    			data: { password: $(this).val() },
    			success: function(data) {
    				var icon = data.icon ? data.icon : 'success';
    				$.gritter.add({
    					title: data.title,
    					text: data.message,
    					image: '/images/admin/icons/' + icon + '.png',
    					sticky: false,
    					time: 3000
    				});
    			}
    		});
    	});

    	$("input[name='notifications']").change(function(){
    		$.ajax( {
    				url: '/my-account/index/method/get/notifications/1/value/' + $(this).val(),
    				dataType : 'json',
    				success: function(data) {
    					$.gritter.add({
    						title: data.title,
    						text: data.message,
    						image: '/images/admin/icons/success.png',
    						sticky: false,
    						time: 3000
    					});
    				}
    			});
    	});

    	$('.language').bind('click', function() {
    		var lang = $(this).data('lang');
    		
    		$.ajax( {
    			url: '/my-account/language/lang/' + lang,
    			dataType : 'json',
    			success: function(data) {
    				if(data.success)
    					window.top.location = '/my-account';
    			}
    		});
    		return false;
    	}); 
    });
    
    vkNgine.page.myaccount.method( 'myplate', function () {
    	var total = function() {
    		var macros = new Array("calories","fat","cholesterol","sodium","carbs","fiber","protein","sugar");

    		for(var i=0; i<macros.length; i++) {
    			var macroValue = 0;

    			$('.sum').each(function() {
    				macroValue += parseFloat($(this).find('td').eq(i+2).data(macros[i]));				
    		    });
    		    
    		    $('.total-' + macros[i] + '').text(macroValue);
    		}	
    	};
    	total();	
      
     	var options = {
    		script:"/my-account/my-plate?food=1&",
    		varname:"foodsearch",
    		json:true,
    		shownoresults:true,
    		maxresults:100,
    		maxentries:100,
    		delay:1,
    		callback: function (obj) { 
    			$('#foodId').val(obj.id);  
    			$('#servingSizeValue').html(obj.servingSize);		
    			$("#servingSizes option[value=" + obj.servingSizeType + "]").attr('selected', 'selected');			
    		}
    	};
    	//var as_json = new bsn.AutoSuggest('foodSearch', options);
    	
     	var d = new Date();
    	var date = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
    	
    	$('.addmeal').bind('click', function(e) {
    		e.preventDefault();
    		var mealId = $('#meals').val();
    		
    		$.ajax( {
    	        url: '/my-account/my-plate/mealId/' + mealId + '/date/' + date,
    	        dataType : 'json',
    	        success: function(data) { 
    		        if(data.success) {
    		        	window.top.location = '/my-account/my-plate';
    		        }		        
    			}
    	   });
    	});

    	$('.addfood').bind('click', function(e) {
    		e.preventDefault();
    		var foodId = $('#foodId').val();
    		var servingSize = $('#servingSize').val();
    		var servingSizes = $('#servingSizes').val();
    		
    		if(!foodId || !servingSize || !servingSizes) {
    			alert('Please enter a food, how much of it consumed, and consumed serving size.');
    			return false;
    		}

    		$.ajax( {
    	        url: '/my-account/my-plate/foodIds/' + foodId + '/servingSize/' + servingSize + '/servingSizes/' + servingSizes + '/date/' + date,
    	        dataType : 'json',
    	        success: function(data) { 
    		        if(data.success){
    		        	window.top.location = '/my-account/my-plate';
    		        }
    			}
    	    });
    	});
    });
})();