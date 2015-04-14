var Featured = function () {

    var self = this;

    var populateFeaturedProperties = function () {

        var firstTemplate = $('#featuredInitial').html();
        Mustache.parse(firstTemplate);
        var secondTemplate = $('#featuredList').html();
        Mustache.parse(secondTemplate);

        $.post( '/search/featured', function(resp) {
            if( resp.code == 1 ) {
                if ( resp.properties.length > 0 ) {
                    if ( resp.properties.length > 1 ) {
                        // cahnge to random
                        var firstProp = resp.properties.splice(2, 1)[0];
                        var rendered1 = Mustache.render(firstTemplate, firstProp);
                        $('#featuredCarousel').html(rendered1);

                        setTimeout(function () {
                            var rendered2 = Mustache.render(secondTemplate, resp);
                            $('#completeList').html(rendered2);
                            self.adjustPropertyWidth();

//                            self.startCarousel();
                        }, 2000);
                    }

                } else {
                   // either render a message template or just shrink section to 0 height
                }
            }
        },'json');

    }

    this.adjustPropertyWidth = function () {
        var baseWidth = $('div.property.first').width() + 'px';
        $('div#completeList div.property').width(baseWidth);
        $('div#completeList div.property').css("top", "0");
    }

    this.startCarousel = function () {
        self.nodes = $("#featuredCarousel .property");
        self.indexActive = 0;

        var loopTiming = 3000;

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
        showNode((self.indexActive === 0) ? nodeCount : self.indexActive - 1);
    }


    this.onloadFunc = function () {
        if ( $("#featuredCarousel") && $("#featuredCarousel").length > 0 ) {
            populateFeaturedProperties();
        }
    }

}