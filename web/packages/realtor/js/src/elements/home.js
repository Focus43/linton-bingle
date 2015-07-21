var Home = function () {

    this.initBlockLinks = function () {
        var _self = this;
        _self.transitionSpeed = 0.8
        _self.timeLines = [];

        $(".nav-blocks div.row > div").on('click', function(){
            window.location.href = $(this).attr('data-url');
        })
    }

    this.initLayoutAndLookdown = function () {
        // move arrow to bottom of view port, and set image height to same height
        var _vpheight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0),
            _top = _vpheight - 100;

        $("div.look-down").css('top', _top + "px")
        $("section.hero").css('height', _vpheight + "px")
        $("section.hero .masthead .node").css('height', _vpheight + "px")

        $("div.look-down").on('click', function() {
            var  _scrollTo = $("section.featured").position().top
            TweenLite.to(window, 1, {scrollTo:{y:_scrollTo, x:0}, ease:Power2.easeOut});
        })
    }

    this.onloadFunc = function () {
        this.initBlockLinks()
        this.initLayoutAndLookdown()
    }
}
