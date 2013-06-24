/**
 * vkNgine.js
 *  
 */
var vkNgine = vkNgine || {};

vkNgine.layout = vkNgine.layout || {};

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
    
    vkNgine.layout.editor = function() {
    	
    };
    
    vkNgine.layout.editor.method = function( name, fn ) {
		if ( 'undefined' !== typeof vkNgine && 'undefined' !== typeof vkNgine.layout && 'undefined' !== typeof vkNgine.layout.editor ) {
			this.prototype[ name ] = fn;
		}
	};
	
	vkNgine.layout.editor.method( 'handleInit', function( rtag, rtype ) {
		vkNgine.layout.isIE8 = !! navigator.userAgent.match(/MSIE 8.0/);
        vkNgine.layout.isIE9 = !! navigator.userAgent.match(/MSIE 9.0/);
        vkNgine.layout.isIE10 = !! navigator.userAgent.match(/MSIE 10/);
        
        if (vkNgine.layout.isIE10) {
            jQuery('html').addClass('ie10');
        }
	});
    _(vkNgine.layout.editor);
	
	
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
		window.console.log( data );
	}
};