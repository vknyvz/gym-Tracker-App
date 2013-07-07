/**
 * vkNgine.js
 *  
 */
var vkNgine = vkNgine || {};

vkNgine.core = vkNgine.core || {};

(function () {
	"use strict";
	
	vkNgine.core.engine = function() {
    };
     
    vkNgine.core.engine.method = function (name, fn) {
 		if ( 'undefined' !== typeof vkNgine && 'undefined' !== typeof vkNgine.core && 'undefined' !== typeof vkNgine.core.engine ) {
 			this.prototype[ name ] = fn;
 		}
 	};
 	
 	vkNgine.core.engine.method( 'initLayout', function () {
 		var layout = new vkNgine.layout.template();

 		layout.handleInit();
 		layout.handleResponsiveOnResize();
 		layout.handleUniform();
 		layout.handleScrollers();
 		layout.handleResponsiveOnInit();

 		layout.handleFixedSidebar();
 		layout.handleFixedSidebarHoverable(); 
 		layout.handleSidebarMenu();
 		layout.handleHorizontalMenu();
 		layout.handleSidebarToggler(); 
 		layout.handleFixInputPlaceholderForIE();
 		layout.handleGoTop(); 
 		layout.handleTheme(); 

 		layout.handlePortletTools();
 		layout.handleDropdowns(); 
 		layout.handleTabs(); 
 		layout.handleTooltips(); 
 		layout.handlePopovers(); 
 		layout.handleAccordions(); 
 		layout.handleChoosenSelect();
 	});
 	
 	vkNgine.core.engine.method ( 'initDashboard', function () {
 		var dashboard = new vkNgine.page.dashboard();
 		
 		dashboard.dateRanger();
 	});
 	
 	vkNgine.core.engine.method ( 'initMyAccount', function (page) {
 		var data = new vkNgine.page.myaccount();
 		
 		switch( page ) {
	 		case 'my-plate':
	 			data.myplate();	
	 			break;
	 		case 'my-workouts':
	 			data.myworkouts();
	 			break;
	 		case 'my-measurements':
	 			data.mymeasurements();
	 		case '':
	 		default:
	 			data.myaccount();
	 			break;
 		}		
 	});
 	
 	vkNgine.core.engine.method( 'isTouchDevice', function () {
 		try {
            document.createEvent("TouchEvent");
            return true;
        } catch (e) {
            return false;
        }
 	});	
 	
 	vkNgine.core.engine.method( 'blockUI', function (el, centerY) {
 	    var el = jQuery(el); 
        el.block({
            message: '<img src="/images/ajax-loading.gif" align="">',
            centerY: centerY != undefined ? centerY : true,
            css: {
                top: '10%',
                border: 'none',
                padding: '2px',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: '#000',
                opacity: 0.05,
                cursor: 'wait'
            }
        });
 	});	
 	
 	vkNgine.core.engine.method( 'unblockUI', function (el) {
	 	jQuery(el).unblock({
	        onUnblock: function () {
	            jQuery(el).removeAttr("style");
	        }
	    });
	});	
})();

/**
 * debugging function, writes output to browser console
 * 
 * @namespace none
 * @method _
 * @param {string} data
 * @return {string}
 */
function _(data) {
	if ( window.console && window.console.log) {
		window.console.log( 'vkNgine message: ' + data );
	}
};