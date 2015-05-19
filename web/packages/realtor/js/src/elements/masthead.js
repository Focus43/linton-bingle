var Masthead = function () {
    var _self = this;
    this.startCarousel = function () {

        _self.circles = $(".circles a")
        _self.circles.on('click', function() {
            var index = Array.prototype.slice.call($(".circles a")).indexOf(this);
            showNode(index);
        });

        _self.carousel = $("section.hero div.masthead");
        _self.nodes = $("section.hero div.masthead div.node");
        _self.indexActive = 0;

        _self.loopTiming = _self.carousel.attr('data-loop-timing') * 1000 || 0;

        if ( _self.loopTiming == 0 ) return;

        (function loop( delay ){
            setTimeout(function(){
                next();
                loop(delay);
            }, (_self.loopTiming));
        })( 3000 );
    }

    var showNode = function ( index ) {

        var indexNext       = index,
            currentNode     = _self.nodes[_self.indexActive],
            currentNodeKids = $(".top", currentNode).children(),
            nextNode        = _self.nodes[indexNext],
            nextNodeKids    = $(".top", nextNode).children()
        transitionSpeed  = 2;

        // Current
        TweenLite.to(currentNode, transitionSpeed, {autoAlpha:0});
        TweenMax.staggerTo(currentNodeKids, transitionSpeed, {x:200,autoAlpha:0}, (transitionSpeed/currentNodeKids.length));
        // Next
        TweenMax.staggerFromTo(nextNodeKids, transitionSpeed, {x:-200,autoAlpha:0}, {x:0,autoAlpha:1}, (transitionSpeed/nextNodeKids.length));
        TweenLite.to(nextNode, transitionSpeed, {autoAlpha:1});

        _self.indexActive = indexNext;
        _self.circles.removeClass('active').eq(_self.indexActive).addClass('active');
    }

    var next = function () {
        showNode((_self.indexActive === _self.nodes.length-1) ? 0 : _self.indexActive + 1);
    }

    var previous = function () {
        showNode((_self.indexActive === 0) ? _self.nodes.length : _self.indexActive - 1);
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