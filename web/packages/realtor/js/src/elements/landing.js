var Landing = function () {

    var populateSubPageList = function () {
        var template = $('#pageList').html();
        Mustache.parse(template);

        // (massive) hack to check if at 'root' landing page
        var multi = ( window.location.pathname.split("/").length >= 3 ) ? "single" : "multi";

        $.post( '/landing/list/'+ CCM_CID + '/' + multi, function(resp) {
            if( resp.code == 1 ) {
                if ( resp.pages.length > 0 ) {
                    var rendered = Mustache.render(template, resp);
                    $('section.subnav').html(rendered);
                } else {
                    $('section.subnav').html("")
                }
            }
        },'json');
    }

    this.onloadFunc = function () {
        if ( $("body.pg-landing section.subnav") && $("body.pg-landing section.subnav").length > 0 ) {
            populateSubPageList();
        }
    }
}