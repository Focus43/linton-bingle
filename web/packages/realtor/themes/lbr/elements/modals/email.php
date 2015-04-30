<?php defined('C5_EXECUTE') or die(_("Access Denied."));
//	Loader::model('spark/property', 'linton');
//	$sparkProperty = SparkProperty::getByID( $_REQUEST['entityID'] );

	$formHelper = Loader::helper('form');
?>

<div class="modal-body">
    <div id="content-email" >
        <form id="contact-form" data-method="json" action="/process_form">
            <div class="row padless">
                <div class="col-xs-12 col-sm-6 col-md-6"><?php echo $formHelper->text('share_sender_name_first', '', array('style'=>'width:95%;','placeholder'=>'FIRST NAME')); ?></div>
                <div class="col-xs-12 col-sm-6 col-sm-6 col-md-6"><?php echo $formHelper->text('share_sender_name_last', '', array('style'=>'width:95%;','placeholder'=>'LAST NAME')); ?></div>
            </div>
            <div class="row padless">
                <div class="col-xs-12 col-sm-6 col-sm-6 col-md-6"><?php echo $formHelper->text('share_sender_email', '', array('style'=>'width:95%;', 'placeholder'=>'EMAIL')); ?></div>
                <div class="col-xs-12 col-sm-6 col-sm-6 col-md-6"><?php echo $formHelper->text('share_sender_name_last', '', array('style'=>'width:95%;','placeholder'=>'PHONE 123-456-7890')); ?></div>
            </div>
            <div class="row padless">
                <div class="col-sm-12 col-sm-12 col-md-12"><?php echo $formHelper->textarea('share_message', '', array('rows'=>'4', 'style'=>'width:97%;', 'placeholder'=>'MESSAGE')); ?></div>
            </div>
            <div class="row padless">
                <div class="col-xs-12 col-sm-12 col-md-12 captcha clearfix">
                    <?php
                    $captcha = Loader::helper('validation/captcha');
                    echo $captcha->display();
                    $captcha->showInput(array('placeholder'=>'TYPE LETTERS IN IMAGE'));
                    ?>
                </div>
<!--                <div class="col-xs-12 col-sm-6 col-md-6">--><?php //echo $captcha->showInput(); ?><!--</div>-->
            </div>





<!--						<tr>-->
<!--							<td class="v-middle">Share With</td>-->
<!--							<td colspan="3" class="supertip" title="Recipients" data-content="To share this property with multiple recipients, seperate email addresses with a comma (ex: jon@gmail.com, alex@gmail.com)">-->
<!--								<div class="control-group">-->
<!--									<div class="controls">-->
<!--										--><?php //echo $formHelper->text('share_recipients', '', array('style'=>'width:97%;','placeholder'=>'Email address(es) of people to share with')) ?>
<!--									</div>-->
<!--								</div>-->
<!--							</td>-->
<!--						</tr>-->

<!--						<tr>-->
<!--							<td>Copy Me</td>-->
<!--							<td colspan="3" class="form-inline">-->
<!--								<label class="checkbox">-->
<!--									--><?php //echo $formHelper->checkbox('cc_me', 1); ?><!-- Send me a copy of this email-->
<!--								</label>-->
<!--							</td>-->
<!--						</tr>-->

            <p style="font-size:11px;">This correspondence is private. Your email will not be viewed or stored by Carol Linton, Jackson Hole Real Estate Associates, or any third parties.</p>
            <input type="hidden" name="type" value="general_contact" />
<!--					<input type="hidden" name="localeID" value="--><?php //echo $sparkProperty->getPropertyID(); ?><!--" />-->
        </form>
        </div>
</div>
<div class="modal-footer">
	<button id="submitForm" class="btn btn-red">Send Message</button>
</div>

<script type="text/javascript">
	$(function(){
//		$('.supertip').popover({
//			'placement': 'top'
//		});
//
//		// autofill message
//		$('#share_sender_name').on('blur', function(){
//			var $this = $(this),
//				$msg  = $('#share_message'),
//				name  = $this.val();
//			if( $msg.val() == '' && name != '' ){
//				$msg.val( 'Hi, its ' + name + ', thought you might be interested in this property.' );
//			}
//		});
		
		// submit the form of the active tab
		$('#submitForm').on('click', function() {
            event.preventDefault();
			$('form#contact-form').submit();
		});
	});
</script>

