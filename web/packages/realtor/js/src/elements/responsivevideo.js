var ResponsiveVideo = function () {

    this.initVideoResize = function () {
        // Find all videos
        var $allVideos = $("iframe[src^='https://player.vimeo.com'], iframe[src^='http://player.vimeo.com']")
//            ,
//            $fluidEl = $("body");

        // Figure out and save aspect ratio for each video
        $allVideos.each(function() {
            $(this).data('aspectRatio', this.height / this.width)
                // and remove the hard coded width/height
                .removeAttr('height')
                .removeAttr('width');

        });

        // When the window is resized
        $(window).resize(function() {

//            var newWidth = $fluidEl.width();
            // Resize all videos according to their own aspect ratio
            $allVideos.each(function() {
                var $el = $(this);
                var newWidth = $el.parent().width();
                $el.width(newWidth).height(newWidth * $el.data('aspectRatio'));
            });

        // Kick off one resize to fix all videos on page load
        }).resize();
    }

    this.onloadFunc = function () {
        this.initVideoResize();
    }
}