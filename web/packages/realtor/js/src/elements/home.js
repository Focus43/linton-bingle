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
