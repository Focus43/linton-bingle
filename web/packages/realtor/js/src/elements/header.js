var Header = function () {
    var initShrink = function () {
        // shrink header on scroll (only on home page)
        if ( $('body').hasClass('pg-home') ) {
            var _header = $('header')
            if ( $(window).scrollTop() > 50 ) {
                _header.addClass("shrink")
            }

            $(window).scroll( function() {
                if ( $(window).scrollTop() > 50 ) {
                    TweenLite.to(_header, 0.5, {className:"shrink"})
                } else {
                    TweenLite.to(_header, 0.5, {className:"-=shrink"})
                }
            })
        }
    }

    var initMobileNav = function () {

        var slideable = $("[slideable]")
        var mobileNav = $("div#mobileNav");
        mobileNav.height(slideable.height());
        $("body").append(mobileNav);
        var trigger = $("div.trigger a")
        var triggerContainer = $("div.trigger")

        trigger.on("click", function () {
            var navList = $("div#mobileNav")
            if ( navList.hasClass("open") ) {
                TweenLite.to(navList, 0.5, {className:"-=open"})
                TweenLite.to(triggerContainer, 0.60, {width: "75px"})
                TweenLite.to(slideable, 0.5, {className:"-=open"})
            } else {
                TweenLite.to(navList, 0.5, {className:"+=open"})
                TweenLite.to(triggerContainer, 0.45, {width: "100%"})
                TweenLite.to(slideable, 0.5, {className:"+=open"})
            }
        })
    }

    var initSubNavAction = function () {
        var triggers = $('nav ul.majority > li.has-subs')
        triggers.on('click', function ( e ) {
            e.preventDefault()
            var t = $(this)
            var idNum = t.attr("data-sub")
            var subNav = $("li#sub-" + idNum)
            var allOpenSubs = $("ul.majority li.sub.open")
            if ( subNav.hasClass("open") ) {
                TweenLite.to(subNav, 0.5, {className:"-=open"})
            } else {
                TweenLite.to(allOpenSubs, 0.5, {className:"-=open"})
                TweenLite.to(subNav, 0.5, {className:"+=open"})
            }
        })
    }

    this.onloadFunc = function () {
        initSubNavAction();
        initMobileNav();
        initShrink();
    }

    var autoInit = function () {
//        if ($) initShrink();
    }();
}
