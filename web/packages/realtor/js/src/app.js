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