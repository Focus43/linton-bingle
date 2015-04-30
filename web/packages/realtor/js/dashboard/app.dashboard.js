
    var Srk9Dash;
    
    $(function(){
        
        Srk9Dash = new function(){
            
            var self        = this,
                $document   = $(document);
            
            
            // tooltips and popover bindings
            $document.tooltip({
                animation: false,
                selector: '.helpTooltip',
                trigger: 'hover'
            }).popover({
                animation: false,
                selector: '.helpTip',
                placement: 'bottom'
            });
            
            
            // check all checkboxes
            $document.on('click', '#checkAllBoxes', function(){
                var $this  = $(this),
                    checkd = $this.is(':checked');
                $(':checkbox', 'table#regionSearchTable tbody').prop('checked', checkd).trigger('change');
            });
            
            
            // if any box is checked, enable the actions dropdown
            $('#srk9Wrap').on('change', '#regionSearchTable tbody :checkbox', function(){
                if( $(':checkbox', '#regionSearchTable > tbody').filter(':checked').length ){
                    $('#actionMenu').prop('disabled', false);
                    return;
                }
                $('#actionMenu').attr('disabled', true);
            });
            
            
            $('#srk9Wrap').on('change', '#actionMenu', function(){
                var $this   = $(this),
                    tools   = $('#srk9ToolsDir').attr('value'),
                    $checkd = $('tbody', '#regionSearchTable').find(':checkbox').filter(':checked'),
                    data    = $checkd.serializeArray();
                
                switch( $this.val() ){
                    case 'delete':
                        if( confirm('Delete these records? This cannot be undone!') ){
                            var deleteURL = tools + $('#actionMenu').attr('data-action-delete');
                            $.post( deleteURL, data, function(resp){
                                if( resp.code == 1 ){
                                    $checkd.parents('tr').fadeOut(150);
                                }else{
                                    alert('An error occurred. Try again later.');
                                }
                            }, 'json');
                        }
                        break;
                }
                
                // reset the menu
                $this.val('');
            });
            
        }
        
    });
