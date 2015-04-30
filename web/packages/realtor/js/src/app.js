;(function (ns, undefined) {
    'use strict';

    ns.modules = [];

    var addModule = function ( moduleName ) {
        ns[moduleName] = new window[moduleName]();
        ns.modules.push(ns[moduleName]);
    }


    addModule('Header');
    addModule('Search');
    addModule('Featured');
    addModule('Property');
    addModule('Masthead');
    addModule('Landing');
    addModule('Modals');

    ns.init = function () {
        /* global FastClick */
        $(function() {
            FastClick.attach(document.body);
        });
    }

})(window.LB = window.LB || {});

LB.init();

window.addEventListener("load", function() {
    // add all module onload functions
    LB.modules.forEach( function ( mod ) {
        if ( mod.onloadFunc ) {
            mod.onloadFunc();
        }
    });
}, false);