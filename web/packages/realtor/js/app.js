var Header = function () {
    this.initShrink = function () {
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
}

var Search = function () {

    var self = this,
        $document = $(document),
        $sortBy = $('.sortBy'),
        $formFilters = $('form#propertySearch input, form#propertySearch select'),
        $priceMin = $('#priceMin'),
        $priceMax = $('#priceMax'),
        $priceMinDisplay = $('#priceMinDisplay'),
        $priceMaxDisplay = $('#priceMaxDisplay'),
        $scrollable = $('.scrollable'),
        $priceSlider = $('#price-slider');


    this.clearFields = function( _this ) {
        var $within  = $( $(_this).attr('data-within') ),
            $targets = $('input, select', $within).not('.unclearable');

        $targets.each( function( idx, el ) {
            var element = $(el);
            if('radio' == element.attr('type') || 'checkbox' == element.attr('type')) {
                element[0].checked = false;
            } else {
                element.val('')
            }
        });
    }

    this.toggleLocationFilter = function ( e ) {
        e.preventDefault();
        var filters = $("#locationFilters")

        if ( filters.hasClass('hidden') ) {
            TweenLite.to(filters, 0.25, {className:"-=hidden"})
        } else {
            TweenLite.to(filters, 0.25, {className:"hidden"})
        }
     }

    var autoInit = function () {
        searchOnChange();
    }

    var searchOnChange = function () {
        // when a filter gets modified, do ajax search
        $formFilters.on('change', 'input, select', function () {
            var _data = $formFilters.serializeArray(); console.log(_data);
            $.post( '/propertysearchcount', _data, function(resp){
                if( resp.code == 1 ){
                    $('span.target-result-count').text(resp.resultCount)
                }
            },'json');
        });
    }

    autoInit();
}

;(function (ns, undefined) {
    'use strict';

    ns.Header = new Header();
    ns.Search = new Search();

    ns.init = function () {
        /* global FastClick */
        $(function() {
            FastClick.attach(document.body);
        });

        ns.Header.initShrink();
    }

})(window.LB = window.LB || {});

LB.init();

//window.addEventListener("load", function() {
//
//}, false);