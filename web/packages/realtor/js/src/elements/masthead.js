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