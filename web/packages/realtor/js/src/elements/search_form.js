var Search = function () {

    var _self = this,
        $document = $(document),
        $sortBy = $('.sortBy'),
        $formFilters = $('form#propertySearch input, form#propertySearch select'),
        $priceMin = $('#priceMin'),
        $priceMax = $('#priceMax'),
        $priceMinDisplay = $('#priceMinDisplay'),
        $priceMaxDisplay = $('#priceMaxDisplay'),
        $scrollable = $('.scrollable'),
        $priceSlider = $('#price-slider');


    this.clearFields = function( _this ) {
        var $within  = $( $(_this).attr('data-within') ),
            $targets = $('input, select', $within).not('.unclearable');

        $targets.each( function( idx, el ) {
            var element = $(el);
            if('radio' == element.attr('type') || 'checkbox' == element.attr('type')) {
                element[0].checked = false;
            } else {
                element.val('')
            }
        });
    }

    this.toggleLocationFilter = function ( e ) {
        e.preventDefault();
        var filters = $("#locationFilters")

        if ( filters.hasClass('hidden') ) {
            TweenLite.to(filters, 0.25, {className:"-=hidden"})
        } else {
            TweenLite.to(filters, 0.25, {className:"hidden"})
        }
     }

    this.closeLocationFilter = function () {
        var filters = $("#locationFilters")
        TweenLite.to(filters, 0.25, {className:"hidden"})
    }

    this.searchOnChange = function () {
        // when a filter gets modified, do ajax search
        var _this = this
        this.getCount = function (data) {
            $.post( '/search/count', data, function(resp){
                if( resp.code == 1 ){
                    $('span.target-result-count').text(resp.resultCount)
                }
            },'json');
        }

        $formFilters.on('change' , function () {
            var _data = $('form#propertySearch').serializeArray();
            _this.getCount(_data)
        });

        this.getCount()
    }

    this.onloadFunc = function () {
        if ( $('form#propertySearch').length > 0 ) {
            this.searchOnChange();
            $('form#propertySearch').on("click", function ( e ) {
                if ( $(e.target)[0] != $("button.locations")[0] && $("div#locationFilters").has(e.target).length ===0 ) {
                    LB.Search.closeLocationFilter();
                }
            })
        }
    }
}
