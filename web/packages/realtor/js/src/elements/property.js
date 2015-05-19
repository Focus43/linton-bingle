var Property = function () {

    var _self = this,
        galleryThumbs,
        showHideBtn,
        arrowLeft,
        arrowRight,
        thumbs,
        circles;
    _self.indexActive = 0;

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

        _self.indexActive = 0;
        _self.nodes = $("#gallery .masthead .node");

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
            currentNode     = _self.nodes[_self.indexActive],
            nextNode        = _self.nodes[indexNext],
            transitionSpeed  = 2;

        // Current
        TweenLite.to(currentNode, transitionSpeed, {autoAlpha:0});
        // Next
        TweenLite.to(nextNode, transitionSpeed, {autoAlpha:1});

        _self.indexActive = indexNext;
        circles.removeClass('active').eq(_self.indexActive).addClass('active');
        thumbs.removeClass('active').eq(_self.indexActive).addClass('active');
    }

    var next = function () {
        showNode((_self.indexActive === _self.nodes.length-1) ? 0 : _self.indexActive + 1);
    }

    var previous = function () {
        showNode((_self.indexActive === 0) ? nodeCount : _self.indexActive - 1);
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
        // /search/related/{city}/{type}}/{price}
        var firstTemplate = $('#relatedList').html();
        Mustache.parse(firstTemplate);
        var _url = '/search/related/' + PROP_CITY + '/' + PROP_TYPE + '/' + PROP_PRICE+ '/' + PROP_ID
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
