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