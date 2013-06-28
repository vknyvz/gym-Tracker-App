/**
 * vkNgine.js
 *  
 */
var vkNgine = vkNgine || {};

vkNgine.layout = vkNgine.layout || {};

var layout = new vkNgine.layout.template();

layout.handleInit();
layout.handleResponsiveOnResize();
layout.handleUniform();
layout.handleScrollers();
layout.handleResponsiveOnInit();

/*
handleInit();
handleResponsiveOnResize(); // set and handle responsive    
handleUniform();        
handleScrollers(); // handles slim scrolling contents 
handleResponsiveOnInit(); // handler responsive elements on page load

//layout handlers
handleFixedSidebar(); // handles fixed sidebar menu
handleFixedSidebarHoverable(); // handles fixed sidebar on hover effect 
handleSidebarMenu(); // handles main menu
handleHorizontalMenu(); // handles horizontal menu
handleSidebarToggler(); // handles sidebar hide/show            
handleFixInputPlaceholderForIE(); // fixes/enables html5 placeholder attribute for IE9, IE8
handleGoTop(); //handles scroll to top functionality in the footer
handleTheme(); // handles style customer tool

//ui component handlers
handlePortletTools(); // handles portlet action bar functionality(refresh, configure, toggle, remove)
handleDropdowns(); // handle dropdowns
handleTabs(); // handle tabs
handleTooltips(); // handle bootstrap tooltips
handlePopovers(); // handles bootstrap popovers
handleAccordions(); //handles accordions
handleChoosenSelect(); // handles bootstrap chosen dropdowns     

App.addResponsiveHandler(handleChoosenSelect); // reinitiate chosen dropdown on ma
*/






(function () {
	"use strict";
	
	vkNgine.layout.isIE8 = false;
	vkNgine.layout.isIE9 = false;
	vkNgine.layout.isIE10 = false;
	vkNgine.layout.sidebarWidth = 225;
	vkNgine.layout.sidebarCollapsedWidth = 35;
    vkNgine.layout.responsiveHandlers = [];
    vkNgine.layout.layoutColorCodes = {
        'blue': '#4b8df8',
        'red': '#e02222',
        'green': '#35aa47',
        'purple': '#852b99',
        'grey': '#555555',
        'light-grey': '#fafafa',
        'yellow': '#ffb848'
    };
    
    vkNgine.layout.template = function() {
    };
    
    vkNgine.layout.template.method = function (name, fn) {
		if ( 'undefined' !== typeof vkNgine && 'undefined' !== typeof vkNgine.layout && 'undefined' !== typeof vkNgine.layout.template ) {
			this.prototype[ name ] = fn;
		}
	};
	
	vkNgine.layout.template.method( 'handleInit', function () {
		vkNgine.layout.isIE8 = !! navigator.userAgent.match(/MSIE 8.0/);
        vkNgine.layout.isIE9 = !! navigator.userAgent.match(/MSIE 9.0/);
        vkNgine.layout.isIE10 = !! navigator.userAgent.match(/MSIE 10/);
        
        if (vkNgine.layout.isIE10) {
            jQuery('html').addClass('ie10');
        }
	});
	
	vkNgine.layout.template.method( 'handleDesktopTabletContents', function () {
        if ($(window).width() <= 1280 || $('body').hasClass('page-boxed')) {
            $(".responsive").each(function () {
                var forTablet = $(this).attr('data-tablet');
                var forDesktop = $(this).attr('data-desktop');
                if (forTablet) {
                    $(this).removeClass(forDesktop);
                    $(this).addClass(forTablet);
                }
            });
        }

        if ($(window).width() > 1280 && $('body').hasClass('page-boxed') === false) {
            $(".responsive").each(function () {
                var forTablet = $(this).attr('data-tablet');
                var forDesktop = $(this).attr('data-desktop');
                if (forTablet) {
                    $(this).removeClass(forTablet);
                    $(this).addClass(forDesktop);
                }
            });
        }
	});
	
	vkNgine.layout.template.method( 'handleSidebarState', function () {
        if ($(window).width() < 980) {
            $('body').removeClass("page-sidebar-closed");
        }
	});
	
	vkNgine.layout.template.method( 'runResponsiveHandlers', function () {
        for (var i in responsiveHandlers) {
            var each = responsiveHandlers[i];
            each.call();
        }
	});
	
	vkNgine.layout.template.method( 'handleResponsiveOnResize', function () {
		var resize;
        if (vkNgine.layout.isIE8) {
            var currheight;
            
            $(window).resize(function() {
                if(currheight == document.documentElement.clientHeight) {
                    return; 
                }                
                if (resize) {
                    clearTimeout(resize);
                }   
                resize = setTimeout(function() {
                    handleResponsive();    
                }, 50);                 
                currheight = document.documentElement.clientHeight;
            });
        } else {
            $(window).resize(function() {
                if (resize) {
                    clearTimeout(resize);
                }   
                resize = setTimeout(function() {
                    _('window resized');
                    handleResponsive();    
                }, 50); 
            });
        }   
	});
	
	vkNgine.layout.template.method( 'handleResponsive', function () {
		handleTooltips();
        handleSidebarState();
        handleDesktopTabletContents();
        handleSidebarAndContentHeight();
        handleChoosenSelect();
        handleFixedSidebar();
        runResponsiveHandlers();		
	});
	
	vkNgine.layout.template.method( 'handleTooltips', function () {
		if (App.isTouchDevice()) {
            jQuery('.tooltips:not(.no-tooltip-on-touch-device)').tooltip();
        } else {
            jQuery('.tooltips').tooltip();
        }
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