var Landing = function () {
    self = this;
    self._postsPerPage = 8;

    this.populateSubPageList = function () {
        var pageListTempl = $('#pageList').html();
        var paginationTempl = $('#pagination').html();
        Mustache.parse(pageListTempl);
        Mustache.parse(paginationTempl);

        // (massive) hack to check if at 'root' landing page
        var multi = ( window.location.pathname.split("/").length >= 3 ) ? "single" : "multi";

        $.post( '/landing/list/'+ CCM_CID + '/' + multi, function(resp) {
            if( resp.code == 1 ) {

                var _data = {};
                // TODO: refactor to reuse this
                if ( resp.pages.length > self._postsPerPage ) {
                    var _pageCollections = [],
                        _increments = [],
                        _pageLink = 1,
                        currentPage = 1;

                    while( resp.pages.length ) {
                        _pageCollections.push(resp.pages.splice(0,self._postsPerPage));
                        _increments.push(_pageLink++);
                    }
                    _data.increments = _increments;
                    _data.pages = _pageCollections[currentPage-1];
                } else {
                    _data.pages = resp.pages;
                    _data.increments = (resp.pages.length > 0) ? [1] : [];
                }

                var pageListRendered = Mustache.render(pageListTempl, _data);
                var paginationRendered = Mustache.render(paginationTempl, _data);
                $('section.subnav div.pagelist').html(pageListRendered);
                $('section.subnav div.pagelist').css('opacity', 1);
                $('section.subnav div.pagination').html(paginationRendered);
                $('section.subnav div.pagination ul li:nth-of-type(2)').addClass('active');

                $("section.subnav div.pagination ul li:not(:first-of-type)").on('click', function () {
                    var pageList = $('section.subnav div.pagelist');
                    // render next collection in list
                    $('section.subnav div.pagelist').css('opacity', 0);
                    var nextPage = $(this).attr("data-next-page") - 1;

                    _data.pages = _pageCollections[nextPage];
                    var pageListRendered = Mustache.render(pageListTempl, _data);

                    TweenLite.to(pageList, 1, {opacity:0, onComplete:function() {
                        pageList.html(pageListRendered);
                        pageList.css('opacity', 1);
                    }});

                    // update pagination link
                    $('section.subnav div.pagination ul li').removeClass('active');
                    $('section.subnav div.pagination ul li:nth-of-type('+ (nextPage + 2) + ')').addClass('active')
                })

            }
        },'json');
    }

    this.onloadFunc = function () {
        if ( $("body.pg-landing section.subnav") && $("body.pg-landing section.subnav").length > 0 ) {
            this.populateSubPageList();
        }
    }
}