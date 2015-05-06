var Featured = function () {

    var self = this;

    self.photoNodesLft = {}
    self.photoNodesRt = {}
    self.photoLftActive = {}
    self.photoRtActive = {}
    self.internalRotTimeouts = {}

    this.populateFeaturedProperties = function () {

        var firstTemplate = $('#featuredInitial').html();
        Mustache.parse(firstTemplate);
        var secondTemplate = $('#featuredList').html();
        Mustache.parse(secondTemplate);

        $.post( '/search/featured', function(resp) {
            if( resp.code == 1 ) {
                if ( resp.properties.length > 0 ) {
                    if ( resp.properties.length > 1 ) {
                        // change to random
                        var firstProp = resp.properties.splice(2, 1)[0];
                        var rendered1 = Mustache.render(firstTemplate, firstProp);
                        $('#featuredCarousel').html(rendered1);
                        $('div.featured-round').css('visibility', 'visible');

                        self.initArrows();

                        setTimeout(function () {
                            var rendered2 = Mustache.render(secondTemplate, resp);
                            $('#completeList').html(rendered2);
                            self.adjustPropertyWidth();
                            self.rearrangePropertyElements();

                            startInternalPhotoCarousel(0);
                            self.startCarousel();
                        }, 2000);
                    }

                } else {
                    $('#featuredCarousel').html("")
                }
            }
        },'json');
    }

    this.initResizeEvent = function () {
        (function() {
            var throttle = function(type, name, obj) {
                var obj = obj || window;
                var running = false;
                var func = function() {
                    if (running) { return; }
                    running = true;
                    requestAnimationFrame(function() {
                        obj.dispatchEvent(new CustomEvent(name));
                        running = false;
                    });
                };
                obj.addEventListener(type, func);
            };

            throttle("resize", "optimizedResize");
        })();

        // handle event
        window.addEventListener("optimizedResize", function() {
            self.adjustPropertyWidth();
        });
    }

    this.initArrows = function () {
        $("div.bottom .indicators div").on("click", function () {
            if ( $(this).hasClass("go-back") ) {
                previous()
            } else {
                next()
            }
        })
    }

    this.adjustPropertyWidth = function () {
        var baseWidth = $('body').width() + 'px';
        $('div.property:not(.first)').width(baseWidth);
        $('div.property:not(.first)').css("top", "0");
    }

    this.rearrangePropertyElements = function () {
        $properties = $('div#completeList div.property');
        $('#featuredCarousel').append($properties);
        $("div#completeList").remove()
    }

    this.startCarousel = function () {
        self.nodes = $("#featuredCarousel .property");
        self.indexActive = 0;

        var loopTiming = 12000;

        (function loop( delay ){
            setTimeout(function(){
                next();
                loop(delay);
            }, (loopTiming));
        })( 3000 );
    }

    var startInternalPhotoCarousel = function ( parentIdx ) {
        self.photoNodesLft[parentIdx] = $($("#featuredCarousel .property")[parentIdx]).find("#carouselRight .left .sub-image");
        self.photoNodesRt[parentIdx] = $($("#featuredCarousel .property")[parentIdx]).find("#carouselRight .right .sub-image");
        self.photoLftActive[parentIdx] = 0;
        self.photoRtActive[parentIdx] = 0;

        var innerloopTiming = 4000;

        (function innerloop( ){
            self.internalRotTimeouts[parentIdx] = setTimeout(function(){
                nextInternalPhoto(parentIdx);
                innerloop();
            }, (innerloopTiming));
        })( );
    }

    var pauseInternalPhotoCarousel = function ( parentIdx ) {
        clearTimeout(self.internalRotTimeouts[parentIdx])
    }

    var showNode = function ( index ) {

        var indexNext       = index,
            currentNode     = self.nodes[self.indexActive],
//            currentNodeKids = $(".top", currentNode).children(),
            nextNode        = self.nodes[indexNext],
//            nextNodeKids    = $(".top", nextNode).children()
            transitionSpeed  = 2;

        // Current
        TweenLite.to(currentNode, transitionSpeed, {autoAlpha:0});
        // Next
        TweenLite.to(nextNode, transitionSpeed, {autoAlpha:1});

        self.indexActive = indexNext;
//        $markers.removeClass('active').eq(indexActive).addClass('active');

        startInternalPhotoCarousel(indexNext);
    }

    var nextInternalPhoto = function ( parentIdx ) {
        self.currentNodeLft = self.photoNodesLft[parentIdx][self.photoLftActive[parentIdx]];
        self.currentNodeRt = self.photoNodesRt[parentIdx][self.photoRtActive[parentIdx]];
        self.nextNodeLft = self.photoNodesLft[parentIdx][(self.photoLftActive[parentIdx] === self.photoNodesLft[parentIdx].length-1) ? 0 : self.photoLftActive[parentIdx]+1];
        self.nextNodeRt = self.photoNodesRt[parentIdx][(self.photoRtActive[parentIdx] === self.photoNodesRt[parentIdx].length-1) ? 0 : self.photoRtActive[parentIdx]+1]

        var transitionSpeed  = 1;
        var xTransform = $(self.currentNodeLft).width()
        // Current
        TweenLite.to(self.currentNodeLft, transitionSpeed, {x:xTransform});
        TweenLite.to(self.currentNodeRt, transitionSpeed, {x:xTransform, delay: 1});
        // Next
        TweenLite.fromTo( self.nextNodeLft, transitionSpeed, {x:-xTransform, autoAlpha:1}, {x:0, autoAlpha:1} )
        TweenLite.fromTo( self.nextNodeRt, transitionSpeed, {x:-xTransform, opacity:1, delay: 1}, {x:0, opacity:1, delay: 1} )

        self.photoLftActive[parentIdx] = (self.photoLftActive[parentIdx] === self.photoNodesLft[parentIdx].length-1) ? 0 : self.photoLftActive[parentIdx] + 1;
        self.photoRtActive[parentIdx] = (self.photoRtActive[parentIdx] === self.photoNodesRt[parentIdx].length-1) ? 0 : self.photoRtActive[parentIdx] + 1;
    }

    var next = function () {
        pauseInternalPhotoCarousel(self.indexActive);
        var nextIdx = (self.indexActive === self.nodes.length-1) ? 0 : self.indexActive + 1;
        showNode(nextIdx);
    }

    var previous = function () {
        pauseInternalPhotoCarousel(self.indexActive);
        showNode((self.indexActive === 0) ? nodeCount : self.indexActive - 1);
    }

    this.onloadFunc = function () {
        if ( $("#featuredCarousel") && $("#featuredCarousel").length > 0 ) {
            this.populateFeaturedProperties();
            this.initResizeEvent();
        }
    }

}
var Header = function () {

    this.initShrink = function () {
        // shrink header on scroll (only on home page)
        if ( $('body').hasClass('pg-home') ) {
            var _header = $('header')
            var _social = $('header ul.social')

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
            } else {
                TweenLite.to(navList, 0.5, {className:"+=open"})
                TweenLite.to(triggerContainer, 0.45, {width: "100%"})
                TweenLite.to(slideable, 0.5, {className:"+=open"})
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

        // set up click events
        var triggers = $('nav ul.majority > li.has-subs')
        triggers.on('mouseenter', function ( e ) {
            e.preventDefault()
            var t = $(this)
            var idNum = t.attr("data-sub")
            var subNav = $("ul.majority li#sub-" + idNum)
            var allOpenSubs = $("ul.majority li.sub.open")
            if ( subNav.hasClass("open") ) {
                TweenLite.to(subNav, 0.2, {autoAlpha:0, className: "-=open"})
            } else {
                var ulChildren = subNav.children("ul");
                var liChildren = subNav.children("ul").children("li");
                var right = 180 * (liChildren.length/2) * -1
                ulChildren.css("right", right)
                TweenLite.to(allOpenSubs, 0.2, {autoAlpha:0, className: "-=open", onComplete: function () {
                    TweenLite.to(subNav, 0.2, {autoAlpha:1, className: "+=open"})
                }})
                // check if subnav in viewport
                var pos = ulChildren[0].getBoundingClientRect()
                if ( pos.right > window.innerWidth ) {
                    var rightDiff = Math.round(pos.right - (window.innerWidth || document.documentElement.clientWidth)) + 5
                    TweenLite.to(ulChildren, 0.2, {x: -rightDiff})
                }

                ulChildren.on('mouseleave', function (){
                    TweenLite.to(subNav, 0.2, {autoAlpha:0, className: "-=open"})
                });
            }
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

var Home = function () {

    this.initBlockLinks = function () {
        var self = this;
        self.transitionSpeed = 0.8
        self.timeLines = [];

        $(".nav-blocks div.row > div").on('click', function(){
            window.location.href = $(this).attr('data-url');
        })

//        $(".nav-blocks div.row > div").on('mouseenter', function(){
//
//            if ( !self.timeLines[_idx] )  {
//                var _shade = $(this).children("div.shade");
//                var _extra = _shade.children("div.extra")
//                var _more = _shade.children("div.more")
//                var _idx = $(this).index()
//
//                self.timeLines[_idx] = new TimelineLite()
//                self.timeLines[_idx].insert(TweenLite.to(_shade, self.transitionSpeed, {css: {'background-color': 'rgba(18,10,7,0.70)', 'padding': '25% 20%'}}), 0)
//                self.timeLines[_idx].insert(TweenLite.to(_extra, self.transitionSpeed, {autoAlpha:1, height: 70}), -self.transitionSpeed)
//                self.timeLines[_idx].insert(TweenLite.to(_more, self.transitionSpeed, {autoAlpha:0}), -2*self.transitionSpeed)
//            }
//
//            self.timeLines[_idx].play()
//
//        })
//
//        $(".nav-blocks div.row > div").on('mouseleave', function(){
//
//            var _idx = $(this).index()
//
//            self.timeLines[_idx].reverse()
//        })

    }


    this.onloadFunc = function () {
        this.initBlockLinks();
    }
}

var Landing = function () {
    self = this;
    self._postsPerPage = 8;

    this.populateSubPageList = function () {
        var pageListTempl = $('#pageList').html();
        var paginationTempl = $('#pagination').html();
        Mustache.parse(pageListTempl);
        Mustache.parse(paginationTempl);

        // (massive) hack to check if at 'root' landing page
        var multi = ( window.location.pathname.split("/").length >= 3 ) ? "single" : "multi";

        $.post( '/landing/list/'+ CCM_CID + '/' + multi, function(resp) {
            if( resp.code == 1 ) {

                var _data = {};
                // TODO: refactor to reuse this
                if ( resp.pages.length > self._postsPerPage ) {
                    var _pageCollections = [],
                        _increments = [],
                        _pageLink = 1,
                        currentPage = 1;

                    while( resp.pages.length ) {
                        _pageCollections.push(resp.pages.splice(0,self._postsPerPage));
                        _increments.push(_pageLink++);
                    }
                    _data.increments = _increments;
                    _data.pages = _pageCollections[currentPage-1];
                } else {
                    _data.pages = resp.pages;
//                    _data.increments = (resp.pages.length > 0) ? [1] : [];
                    _data.increments = null;
                }

                var pageListRendered = Mustache.render(pageListTempl, _data);
                var paginationRendered = Mustache.render(paginationTempl, _data);
                $('section.subnav div.pagelist').html(pageListRendered);
                $('section.subnav div.pagelist').css('opacity', 1);
                $('section.subnav div.pagination').html(paginationRendered);
                $('section.subnav div.pagination ul li:nth-of-type(2)').addClass('active');

                $("section.subnav div.pagination ul li:not(:first-of-type)").on('click', function () {
                    var pageList = $('section.subnav div.pagelist');
                    // render next collection in list
                    $('section.subnav div.pagelist').css('opacity', 0);
                    var nextPage = $(this).attr("data-next-page") - 1;

                    _data.pages = _pageCollections[nextPage];
                    var pageListRendered = Mustache.render(pageListTempl, _data);

                    TweenLite.to(pageList, 1, {opacity:0, onComplete:function() {
                        pageList.html(pageListRendered);
                        pageList.css('opacity', 1);
                    }});

                    // update pagination link
                    $('section.subnav div.pagination ul li').removeClass('active');
                    $('section.subnav div.pagination ul li:nth-of-type('+ (nextPage + 2) + ')').addClass('active')
                })

            }
        },'json');
    }

    this.onloadFunc = function () {
        if ( $("body.pg-landing section.subnav") && $("body.pg-landing section.subnav").length > 0 ) {
            this.populateSubPageList();
        }
    }
}
var Masthead = function () {
    var self = this;
    this.startCarousel = function () {

        self.circles = $(".circles a")
        self.circles.on('click', function() {
            var index = Array.prototype.slice.call($(".circles a")).indexOf(this);
            showNode(index);
        });

        self.carousel = $("section.hero div.masthead");
        self.nodes = $("section.hero div.masthead div.node");
        self.indexActive = 0;

        self.loopTiming = self.carousel.attr('data-loop-timing') * 1000 || 0;

        if ( self.loopTiming == 0 ) return;

        (function loop( delay ){
            setTimeout(function(){
                next();
                loop(delay);
            }, (self.loopTiming));
        })( 3000 );
    }

    var showNode = function ( index ) {

        var indexNext       = index,
            currentNode     = self.nodes[self.indexActive],
            currentNodeKids = $(".top", currentNode).children(),
            nextNode        = self.nodes[indexNext],
            nextNodeKids    = $(".top", nextNode).children()
        transitionSpeed  = 2;

        // Current
        TweenLite.to(currentNode, transitionSpeed, {autoAlpha:0});
        TweenMax.staggerTo(currentNodeKids, transitionSpeed, {x:200,autoAlpha:0}, (transitionSpeed/currentNodeKids.length));
        // Next
        TweenMax.staggerFromTo(nextNodeKids, transitionSpeed, {x:-200,autoAlpha:0}, {x:0,autoAlpha:1}, (transitionSpeed/nextNodeKids.length));
        TweenLite.to(nextNode, transitionSpeed, {autoAlpha:1});

        self.indexActive = indexNext;
        self.circles.removeClass('active').eq(self.indexActive).addClass('active');
    }

    var next = function () {
        showNode((self.indexActive === self.nodes.length-1) ? 0 : self.indexActive + 1);
    }

    var previous = function () {
        showNode((self.indexActive === 0) ? self.nodes.length : self.indexActive - 1);
    }

    this.initArrows = function () {
        $("section.hero div.masthead a.edit-arrows").on('click', function () {
            if ( $(this).hasClass('icon-arrow-left') ) {
                previous();
            } else {
                next();
            }
        });

    }

    this.onloadFunc = function () {
        if ( $("section.hero div.masthead") && $("section.hero div.masthead").length > 0 ) {
            this.startCarousel();
            this.initArrows();
        }
    }
}
var Modals = function () {
    var self = this;
    this.openModal = function( opts ){
        // remove any existing ones
        $('#modalBox').remove();

        // add modalbox to the DOM
        $('body').append('<div id="modalBox" class="modal hide fade"><div class="modal-content"><div class="modal-header clearfix"><a class="close" data-dismiss="modal">×</a><h3 class="title-target"></h3></div><div class="loadTarget"></div></div></div>');

        // select the modalBox element
        var modalBox = $('#modalBox');

        modalBox.css({ width:opts.width,'margin': 20 }).modal();
        $('h3.title-target',modalBox).empty().text( opts.title );
        $('div.loadTarget', modalBox).empty().load( "/modal" + opts.url, opts.data, function(data, status, xhr){
            if ( status === 'success' ) {
                self.initFormAjaxing();
            }
        });
        modalBox.removeClass("hide");
    }

    this.initModalTriggers = function () {
        $('.modalize').on('click', function (event){
            event.preventDefault();
            var _this = $(this);
            self.openModal({
                width: _this.attr('data-width'),
                title: _this.attr('data-title'),
                url: _this.attr('data-load'),
                data: {
                    entityID: _this.attr('data-entity-id') || null
                }
            });
        })
    }

    this.initFormAjaxing = function () {
        $('form[data-method="json"], form#contact-form').on('submit', function(event){
            event.preventDefault();

            var $this       = $(event.target),
                _closeAfter	= +($this.attr('data-close-modal-delay')),
                _noAlert	= $this.attr('data-cancel-success-alert'),
                _submitURL  = $this.attr('action'),
                _data       = $this.serializeArray();

            _data.push({name:'resp_method',value:'json'});

            // clear any error output
            $('.message', $this).remove();
            $('div.control-group.error', $this).removeClass('error');

            $.post( _submitURL, _data, function(resp){
                // if we're in a modal, we need to append in the .modal-body element,
                // othwerise, just append right after the first form tag
                if( _noAlert != 'true' || resp.code != 1 ){
                    var $modalBody = $('.modal-body', $this);
                    if( $modalBody.length !== 0 ){
                        $modalBody.prepend( assembleOutput(resp) );
                    }else{
                        $this.prepend( assembleOutput(resp) );
                    }

                    // highlight the invalid fields
                    if( typeof(resp.fields) == 'object' ){
                        $.each(resp.fields, function(idx, name){
                            $('[name="'+name+'"]', $this).parents('div.control-group').addClass('error');
                        });
                    }
                }

                if( _closeAfter > 0 && resp.code == 1 ){
                    setTimeout(function(){ $('#modalBox').modal('hide'); }, _closeAfter);
                }

                // fire custom event
                $this.trigger('ajax_form_complete', resp);

            }, 'json');
        });
    }

    function assembleOutput( respObj ){
        var alertClass = respObj.code == 1 ? 'success alert-success alert-info ' : 'error alert-danger';
        output = $('<div class="alert message alert-message info '+alertClass+'"><ul></ul></div>');
        var list = '';
        $.each( respObj.messages, function(idx, msg){
            list += '<li>'+msg+'</li>';
        });
        output.find('ul').append(list);

        return output;
    }

    this.onloadFunc = function () {
        this.initModalTriggers();
    }
}

var Property = function () {

    var self = this,
        galleryThumbs,
        showHideBtn,
        arrowLeft,
        arrowRight,
        thumbs,
        circles;
    self.indexActive = 0;

    this.initCarousel = function () {
        circles = $(".circles a")
        circles.on('click', function() {
            var index = Array.prototype.slice.call($(".circles a")).indexOf(this);
            showNode(index);
        });
        thumbs = $(".markers.thumbs a")
        thumbs.on('click', function(){
            var index = Array.prototype.slice.call($(".markers.thumbs a")).indexOf(this);
            showNode(index);
        });

        self.indexActive = 0;
        self.nodes = $("#gallery .masthead .node");

        var loopTiming = 5000;

        (function loop( delay ){
            setTimeout(function(){
                next();
                loop(delay);
            }, (loopTiming));
        })( 7000 );
    }

    var showNode = function ( index ) {

        var indexNext       = index,
            currentNode     = self.nodes[self.indexActive],
            nextNode        = self.nodes[indexNext],
            transitionSpeed  = 2;

        // Current
        TweenLite.to(currentNode, transitionSpeed, {autoAlpha:0});
        // Next
        TweenLite.to(nextNode, transitionSpeed, {autoAlpha:1});

        self.indexActive = indexNext;
        circles.removeClass('active').eq(self.indexActive).addClass('active');
        thumbs.removeClass('active').eq(self.indexActive).addClass('active');
    }

    var next = function () {
        showNode((self.indexActive === self.nodes.length-1) ? 0 : self.indexActive + 1);
    }

    var previous = function () {
        showNode((self.indexActive === 0) ? nodeCount : self.indexActive - 1);
    }

    this.initToggleGalleryThumbs = function () {
        galleryThumbs = $(".pg-properties section#gallery div.markers.thumbs");
        showHideBtn = $(".pg-properties section#gallery div#showhide")

        arrowLeft = $(".pg-properties section#gallery a.arrow.left");
        arrowRight = $(".pg-properties section#gallery a.arrow.right");

        showHideBtn.on('click', function () {
            if ( showHideBtn.hasClass("up") ) {
                TweenLite.to(showHideBtn, 0.35, {className:"-=up"})
                TweenLite.to(galleryThumbs, 0.25, {className:"+=hidden"})
                TweenLite.to(arrowLeft, 0.25, {opacity:0})
                TweenLite.to(arrowRight, 0.25, {opacity:0})
            } else {
                TweenLite.to(showHideBtn, 0.35, {className:"up"})
                TweenLite.to(galleryThumbs, 0.25, {className:"-=hidden"})
                TweenLite.to(arrowLeft, 0.25, {opacity:1})
                TweenLite.to(arrowRight, 0.25, {opacity:1})
            }
        })
    }

    this.initSlideThumbs = function () {
        arrowLeft = $(".pg-properties section#gallery a.arrow.left");
        arrowRight = $(".pg-properties section#gallery a.arrow.right");

        arrowLeft.on("click", function () {
            TweenLite.to(galleryThumbs, 0.25, {left: '-=77'})
        })
        arrowRight.on("click", function () {
            if ( parseInt(galleryThumbs.css("left").replace("px", "")) < 0 ) {
                TweenLite.to(galleryThumbs, 0.25, {left: '+=77'})
            }
        })
    }

    this.initSortingDropdown = function () {

        var buttons = $("section.pagination div.sorter");
        buttons.on("click", function () {
            var list = $("div.sortbyList")
            var verticalPos = { }

            if ( $(this)[0] == buttons[0] ) {
                $("section.results").append(list)
                verticalPos = { 'top': 0 }
            } else {
                $("section.footer").append(list)
                verticalPos = { 'top': -50 }
            }

            if ( list.css('visibility') == 'visible' ) {
                list.css({ 'visibility': 'hidden' })
            } else {
                list.css({ 'visibility': 'visible', 'right': 0 })
                list.css(verticalPos)
            }
        })
    }

    this.showRelatedProperties = function () {
        // /search/related/{city}/{beds}/{baths}/{price}
        var firstTemplate = $('#relatedList').html();
        Mustache.parse(firstTemplate);
//        var _url = '/search/related/' + PROP_CITY + '/' + PROP_BEDS + '/' + PROP_BATHS + '/' + PROP_PRICE
        var _url = '/search/related/' + PROP_CITY
        $.post( _url, function(resp) {
            if( resp.code && resp.code == 1 ) {
                if ( resp.properties.length >= 3 ) {
                    var rendered1 = Mustache.render(firstTemplate, resp);
                    $('#relatedListings').html(rendered1);
                    $('.featured-round').css('display', 'block')
                } else {
                    $('#relatedListings').html("")
                }
            } else {
                $('#relatedListings').html("")
            }
        },'json');
    }

    this.onloadFunc = function () {
        if ( $(".pg-properties section#gallery div#showhide").length != 0 ) {
            this.initToggleGalleryThumbs();
            this.initSlideThumbs();
            this.initCarousel();
        }

        if ( $("section.pagination div.sortby").length != 0 ) {
            this.initSortingDropdown();
        }
        if ( $("section.related div#relatedListings") && $("section.related div#relatedListings").length != 0 ) {
            this.showRelatedProperties();
        }
        if ( $("body.pg-properties section.subnav") && $("body.pg-properties section.subnav").length > 0 ) {
            this.initSubPageList();
        }
    }

    this.autoInit = function () {

    }();
}

var Regions = function () {
    var self = this;
    this.startCarousel = function () {
        self.carousel = $("section.sub-areas div.masthead");
        self.nodes = $("section.sub-areas div.masthead div.node");
        self.indexActive = 0;

        self.loopTiming = self.carousel.attr('data-loop-timing') * 1000 || 0;

        if ( self.loopTiming == 0 ) return;

        (function loop( delay ){
            self.rotationTimeOut = setTimeout(function(){
                next();
                loop(delay);
            }, (self.loopTiming));
        })( 3000 );
    }

    var showNode = function ( index ) {

        var indexNext       = index,
            currentNode     = self.nodes[self.indexActive],
            nextNode        = self.nodes[indexNext],
            transitionSpeed  = 1;

        var xTransform = $(currentNode).width()
//        $(nextNode).css("left", xTransform);
        // Current
        TweenLite.to(currentNode, transitionSpeed, {x:-xTransform});
        // Next
        TweenLite.fromTo( nextNode, transitionSpeed, {x:xTransform, autoAlpha:1}, {x:0, autoAlpha:1} )

        self.indexActive = indexNext;

        //        $markers.removeClass('active').eq(indexActive).addClass('active');
    }

    var next = function () {
        showNode((self.indexActive === self.nodes.length-1) ? 0 : self.indexActive + 1);
    }

    var previous = function () {
        showNode((self.indexActive === 0) ? self.nodes.length : self.indexActive - 1);
    }

    this.initLlinks = function () {
        $("section.current-level-nav li").on('click', function () {
            showNode($(this).index())
            clearTimeout(self.rotationTimeOut);
        });

    }

    this.onloadFunc = function () {
        if ( $("section.sub-areas div.masthead") && $("section.sub-areas div.masthead").length > 0 ) {
            this.startCarousel();
            this.initLlinks();
        }
    }
}
var ResponsiveVideo = function () {


    this.initVideoResize = function () {
        // Find all YouTube videos
        var $allVideos = $("iframe[src^='https://player.vimeo.com'], iframe[src^='http://player.vimeo.com']"),
            $fluidEl = $("body");

        // Figure out and save aspect ratio for each video
        $allVideos.each(function() {

            $(this)
                .data('aspectRatio', this.height / this.width)

                // and remove the hard coded width/height
                .removeAttr('height')
                .removeAttr('width');

        });

        // When the window is resized
        $(window).resize(function() {

            var newWidth = $fluidEl.width();

            // Resize all videos according to their own aspect ratio
            $allVideos.each(function() {

                var $el = $(this);
                $el
                    .width(newWidth)
                    .height(newWidth * $el.data('aspectRatio'));

            });

        // Kick off one resize to fix all videos on page load
        }).resize();
    }

    this.onloadFunc = function () {
        this.initVideoResize();
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

    this.closeLocationFilter = function () {
        var filters = $("#locationFilters")
        TweenLite.to(filters, 0.25, {className:"hidden"})
    }

    this.searchOnChange = function () {
        // when a filter gets modified, do ajax search
        $formFilters.on('change' , function () {
            var _data = $('form#propertySearch').serializeArray();
            $.post( '/search/count', _data, function(resp){
                if( resp.code == 1 ){
                    $('span.target-result-count').text(resp.resultCount)
                }
            },'json');
        });
    }

    this.onloadFunc = function () {
        if ( $('form#propertySearch').length > 0 ) {
            this.searchOnChange();
            $('form#propertySearch').on("click", function ( e ) {
                if ( $(e.target)[0] != $("button.locations")[0] && $("div#locationFilters").has(e.target).length ===0 ) {
                    LB.Search.closeLocationFilter();
                }
            })
        }
    }
}

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
    addModule('Home');
    addModule('Regions');
    addModule('ResponsiveVideo');

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