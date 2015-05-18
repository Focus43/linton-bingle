var Modals = function () {
    var self = this;
    this.openModal = function( opts ){
        // remove any existing ones
        $('#modalBox').remove();

        // add modalbox to the DOM
        $('body').append('<div id="modalBox" class="modal hide fade"><div class="modal-content"><div class="modal-header clearfix"><a class="close" data-dismiss="modal">×</a><h3 class="title-target"></h3></div><div id="spinner"><span class="icon-spinner spinner"></span></div><div class="loadTarget"></div></div></div>');
        $('div#spinner').css('display', 'inline-block');
        // select the modalBox element
        var modalBox = $('#modalBox');

        modalBox.css({ width:opts.width,'margin': 20 }).modal();
        $('h3.title-target',modalBox).empty().text( opts.title );
        $('div.loadTarget', modalBox).empty().load( "/modal" + opts.url, opts.data, function(data, status, xhr){
            if ( status === 'success' ) {
                $('div#spinner').css('display', 'none');
                self.initFormAjaxing();
            }
        });
        modalBox.removeClass("hide");
    }

    this.initModalTriggers = function () {
        $('.modalize').on('click', function (event){
            event.preventDefault();
            var _this = $(this);
            self.openModal({
                width: _this.attr('data-width'),
                title: _this.attr('data-title'),
                url: _this.attr('data-load'),
                data: {
                    entityID: _this.attr('data-entity-id') || null
                }
            });
        })
    }

    this.initFormAjaxing = function () {
        $('form[data-method="json"], form#contact-form').on('submit', function(event){
            event.preventDefault();

            var $this       = $(event.target),
                _closeAfter	= +($this.attr('data-close-modal-delay')),
                _noAlert	= $this.attr('data-cancel-success-alert'),
                _submitURL  = $this.attr('action'),
                _data       = $this.serializeArray();

            _data.push({name:'resp_method',value:'json'});

            // clear any error output
            $('.message', $this).remove();
            $('div.control-group.error', $this).removeClass('error');

            $.post( _submitURL, _data, function(resp){
                // if we're in a modal, we need to append in the .modal-body element,
                // othwerise, just append right after the first form tag
                if( _noAlert != 'true' || resp.code != 1 ){
                    var $modalBody = $('.modal-body', $this);
                    if( $modalBody.length !== 0 ){
                        $modalBody.prepend( assembleOutput(resp) );
                    }else{
                        $this.prepend( assembleOutput(resp) );
                    }

                    // highlight the invalid fields
                    if( typeof(resp.fields) == 'object' ){
                        $.each(resp.fields, function(idx, name){
                            $('[name="'+name+'"]', $this).parents('div.control-group').addClass('error');
                        });
                    }
                }

                if( _closeAfter > 0 && resp.code == 1 ){
                    setTimeout(function(){ $('#modalBox').modal('hide'); }, _closeAfter);
                }

                // fire custom event
                $this.trigger('ajax_form_complete', resp);

            }, 'json');
        });
    }

    function assembleOutput( respObj ){
        var alertClass = respObj.code == 1 ? 'success alert-success alert-info ' : 'error alert-danger';
        output = $('<div class="alert message alert-message info '+alertClass+'"><ul></ul></div>');
        var list = '';
        $.each( respObj.messages, function(idx, msg){
            list += '<li>'+msg+'</li>';
        });
        output.find('ul').append(list);

        return output;
    }

    this.onloadFunc = function () {
        this.initModalTriggers();
    }
}
