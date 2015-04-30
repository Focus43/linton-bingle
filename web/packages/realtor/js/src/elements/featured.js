var Featured = function () {

    var self = this;

    self.photoNodesLft = {}
    self.photoNodesRt = {}
    self.photoLftActive = {}
    self.photoRtActive = {}
    self.internalRotTimeouts = {}

    var populateFeaturedProperties = function () {

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

    var initResizeEvent = function () {
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
            populateFeaturedProperties();
            initResizeEvent();
        }
    }

}