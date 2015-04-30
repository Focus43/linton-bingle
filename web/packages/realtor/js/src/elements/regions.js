var Regions = function () {
    var self = this;
    this.startCarousel = function () {
        self.carousel = $("section.sub-areas div.masthead");
        self.nodes = $("section.sub-areas div.masthead div.node");
        self.indexActive = 0;

        loopTiming = self.carousel.attr('data-loop-timing') * 1000 || 0;

        if ( loopTiming == 0 ) return;

        (function loop( delay ){
            setTimeout(function(){
                next();
                loop(delay);
            }, (loopTiming));
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
        });

    }

    this.onloadFunc = function () {
        if ( $("section.sub-areas div.masthead") && $("section.sub-areas div.masthead").length > 0 ) {
            this.startCarousel();
            this.initLlinks();
        }
    }
}