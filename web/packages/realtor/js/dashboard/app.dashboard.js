
    var Srk9Dash;
    
    $(function(){
        
        Srk9Dash = new function(){
            
            var self        = this,
                $document   = $(document);
            
            
            // tooltips and popover bindings
//            $document.tooltip({
//                animation: false,
//                selector: '.helpTooltip',
//                trigger: 'hover'
//            }).popover({
//                animation: false,
//                selector: '.helpTip',
//                placement: 'bottom'
//            });

            // send request on change
            $('#regionWrap').on('change', '#numResults', function() {
                window.location = "?numResults=" + $(this).val()
            });
            
            // check all checkboxes
            $document.on('click', '#checkAllBoxes', function(){
                var $this  = $(this),
                    checkd = $this.is(':checked');
                $(':checkbox', 'table#regionSearchTable tbody').prop('checked', checkd).trigger('change');
            });
            
            
            // if any box is checked, enable the actions dropdown
            $('#regionWrap').on('change', '#regionSearchTable tbody :checkbox', function(){
                if( $(':checkbox', '#regionSearchTable > tbody').filter(':checked').length ){
                    $('#actionMenu').prop('disabled', false);
                    return;
                }
                $('#actionMenu').attr('disabled', true);
            });
            
            
            $('#regionWrap').on('click', 'button.delete', function() {
                var regionElm = $(this).parents("tr")
                var id = $(this).attr('data-id')
                if( confirm('Delete this region? This cannot be undone!') ){
                    var deleteURL = "/regions/delete/" + id;
                    $.post( deleteURL, function(resp){
                        console.log(resp);
                        if( resp.code == 1 ){
                            regionElm.fadeOut(150);
                        }else{
                            alert('An error occurred. Try again later.');
                        }
                    }, 'json');
                }

            });
            
        }
        
    });
