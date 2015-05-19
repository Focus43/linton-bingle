var Regions = function () {
    var _self = this;
    this.startCarousel = function () {
        _self.carousel = $("section.sub-areas div.masthead");
        _self.nodes = $("section.sub-areas div.masthead div.node");
        _self.indexActive = 0;

        _self.loopTiming = _self.carousel.attr('data-loop-timing') * 1000 || 0;

        if ( _self.loopTiming == 0 ) return;

        (function loop( delay ){
            _self.rotationTimeOut = setTimeout(function(){
                next();
                loop(delay);
            }, (_self.loopTiming));
        })( 3000 );
    }

    var showNode = function ( index ) {

        var indexNext       = index,
            currentNode     = _self.nodes[_self.indexActive],
            nextNode        = _self.nodes[indexNext],
            transitionSpeed  = 1;

        var xTransform = $(currentNode).width()
//        $(nextNode).css("left", xTransform);
        // Current
        TweenLite.to(currentNode, transitionSpeed, {x:-xTransform});
        // Next
        TweenLite.fromTo( nextNode, transitionSpeed, {x:xTransform, autoAlpha:1}, {x:0, autoAlpha:1} )

        _self.indexActive = indexNext;

        //        $markers.removeClass('active').eq(indexActive).addClass('active');
    }

    var next = function () {
        showNode((_self.indexActive === _self.nodes.length-1) ? 0 : _self.indexActive + 1);
    }

    var previous = function () {
        showNode((_self.indexActive === 0) ? _self.nodes.length : _self.indexActive - 1);
    }

    this.initLlinks = function () {
        $("section.current-level-nav li").on('click', function () {
            showNode($(this).index())
            clearTimeout(_self.rotationTimeOut);
        });

    }

    this.onloadFunc = function () {
        if ( $("section.sub-areas div.masthead") && $("section.sub-areas div.masthead").length > 0 ) {
            this.startCarousel();
            this.initLlinks();
        }
    }
}