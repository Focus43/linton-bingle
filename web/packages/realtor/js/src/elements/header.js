var Header = function () {
    var _self = this
    this.initShrink = function () {
        // shrink header on scroll (only on home page)
        if ( $('body').hasClass('pg-home') ) {
            var _header = $('header')
            var _social = $('header ul.social.free-standing')

            if ( $(window).scrollTop() > 50 ) {
                _header.addClass("shrink")
            }

            $(window).scroll( function() {
                if ( $(window).scrollTop() > 50 ) {
                    TweenLite.to(_header, 0.5, {className:"shrink"})
                    TweenLite.to(_social, 0.5, {autoAlpha:0})
                } else {
                    TweenLite.to(_header, 0.5, {className:"-=shrink"})
                    TweenLite.to(_social, 0.5, {autoAlpha:1})
                }
            })
        }
    }

    this.initMobileNav = function () {

        var slideable = $("[slideable]")
        var mobileNav = $("div#mobileNav");
        $("body").append(mobileNav);
        var trigger = $("div.trigger a")
        var triggerContainer = $("div.trigger")

        trigger.on("click", function () {
            var navList = $("div#mobileNav")
            if ( navList.hasClass("open") ) {
                TweenLite.to(navList, 0.5, {className:"-=open"})
                TweenLite.to(triggerContainer, 0.60, {width: "75px"})
                TweenLite.to(slideable, 0.5, {className:"-=open"})
                // make sure content can scroll again
//                $("#c-level-1").css('overflow-y', "inherit")
            } else {
                TweenLite.to(navList, 0.5, {className:"+=open"})
                TweenLite.to(triggerContainer, 0.45, {width: "100%"})
                TweenLite.to(slideable, 0.5, {className:"+=open"})
                // make sure only nav can move
//                $("#c-level-1").css('overflow-y', "hidden")
            }
        })

        var mainNavTriggers = $("div#mobileNav ul.sidebar li.has-subs");
        mainNavTriggers.on('click', function () {
            var _subNav = $(this).next("ul.sub")
            var _subs = _subNav.children("li")

            if ( _subNav.hasClass("open")) {
                $(this).addClass("show-plus")
                _subNav.removeClass("open")
                TweenLite.to(_subNav, 0.5, {height: 0})
            } else {
                $(this).removeClass("show-plus")
                _subNav.addClass("open")
                TweenLite.to(_subNav, 0.5, {height: _subs.length*75})
            }
        })
    }

    this.initSubnavIndicators = function () {
        var triggers = $('nav ul.majority > li.has-subs > a')
        triggers.each(function ( idx, elem ) {
            $(elem).append("<i class='icon-arrow-down'></i>")
        })
    }

    this.initSubNavAction = function () {
        // make sure width of container ul is correct (cross browser hack)
        $('nav ul.majority > li.sub').each( function ( idx, elm ) {
            if ( $(elm).attr("id") != "sub-contact" )  {
                var _kids = $(elm).children('ul').children("li");
                $(elm).children('ul').css('width', (180 * _kids.length) + 22); // 22 is padding + border
            }
        })

        // set up click/hover events
        var triggers    = $('nav ul.majority > li.has-subs')
        var subs        = $('nav ul.majority > li.sub')
        triggers.on('mouseenter tap', function ( e ) {
            e.preventDefault()
            if ( _self.navTimer ) clearTimeout(_self.navTimer)
            var t = $(this)
            var idNum = t.attr("data-sub")
            var subNav = $("ul.majority li#sub-" + idNum)
            var allOpenSubs = $("ul.majority li.sub.open")

            if ( !subNav.hasClass("open") ) {
                var ulChildren = subNav.children("ul");
                var liChildren = subNav.children("ul").children("li");
                var right = 180 * (liChildren.length/2) * -1
                ulChildren.css("right", right)
                TweenLite.to(allOpenSubs, 0.2, {autoAlpha:0, className: "-=open", onComplete: function () {
                    TweenLite.to(subNav, 0.2, {autoAlpha:1, className: "+=open"})
                }})

                // check if subnav in viewport, move if not
                var pos = ulChildren[0].getBoundingClientRect()
                if ( pos.right > window.innerWidth ) {
                    var rightDiff = Math.round(pos.right - (window.innerWidth || document.documentElement.clientWidth)) + 5
                    var timer = (e.type === "tap") ? 0 : 0.1
                    TweenLite.to(ulChildren, timer, {x: -rightDiff})
                }

                ulChildren.on('mouseleave', function () {
                    if ( _self.navTimer ) clearTimeout(_self.navTimer)
                    _self.navTimer = setTimeout(function () {TweenLite.to(subNav, 0.2, {autoAlpha:0, className: "-=open"}) }, 500)
                });
                ulChildren.on('mouseenter', function () {
                    if ( _self.navTimer ) clearTimeout(_self.navTimer)
                });
                if ( e.type === "tap" ) {
                    t.removeClass("noHover")
                }
            } else if ( e.type === "tap" && subNav.hasClass("open") ) {
                t.addClass("noHover")
                TweenLite.to(subNav, 0.2, {autoAlpha:0, className: "-=open"})
            }
        })
        triggers.on('mouseleave', function () {
            if ( _self.navTimer ) clearTimeout(_self.navTimer)
            _self.navTimer = setTimeout(function () { TweenLite.to(subs, 0.2, {autoAlpha:0, className: "-=open"}) }, 500)
        })

        triggers.on('click', function ( e ) {
            e.preventDefault()
        })
    }

    this.onloadFunc = function () {
        this.initSubNavAction();
        this.initSubnavIndicators();
        this.initMobileNav();
        this.initShrink();
    }

    var autoInit = function () {
//        if ($) initShrink();
    }();
}
