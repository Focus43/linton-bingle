var headerComponents = function (window) {
    // shrink header on scroll (only on home page)
    if ( $('body').hasClass('pg-home') ) {
        $(window).scroll( function() {
            var _header = $('header')
            if ( $(window).scrollTop() > 50 ) {
                TweenLite.to(_header, 0.5, {className:"shrink"})
            } else {
                TweenLite.to(_header, 0.5, {className:"-=shrink"})
            }
        })
    }
}

/* global FastClick */
;(function( window ){ 'use strict';

    FastClick.attach(document.body);

    // theme components
    headerComponents(window);

    // register knockout components here
    // http://knockoutjs.com/documentation/component-registration.html

})(window);