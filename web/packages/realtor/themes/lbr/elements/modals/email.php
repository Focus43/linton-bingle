<?php defined('C5_EXECUTE') or die(_("Access Denied."));
use Concrete\Package\Realtor\Src\PropertySearch\SparkProperty as SparkProperty;
$pkgConfig = \Concrete\Package\Realtor\Controller::getPackageConfigObj();
if ($_REQUEST['entityID']) {
    $sparkProperty = SparkProperty::getByID( $_REQUEST['entityID'] );
}
	$formHelper = Loader::helper('form');
?>

<div class="modal-body">
    <div id="content-email" >
        <?php if ( $_REQUEST['entityID'] ) : ?>
        <p>
            MLS #: <strong><?php echo $sparkProperty->getMlsNumber(); ?></strong><br />
            Property Title: <strong><?php echo $sparkProperty->getPropertyName(); ?></strong><br />
<!--            City, State: <strong>--><?php //echo $sparkProperty->getCity() . ', ' . $sparkProperty->getStateOrProvince(); ?><!--</strong><br />-->
            Price: <strong>$<?php echo $sparkProperty->getListPrice(); ?></strong>
        </p>
        <?php endif; ?>
        <form id="contact-form" data-method="json" action="/process_form">
            <div class="row padless">
                <div class="col-xs-12 col-sm-6 col-md-6"><?php echo $formHelper->text('share_sender_name_first', '', array('style'=>'width:95%;','placeholder'=>'FIRST NAME')); ?></div>
                <div class="col-xs-12 col-sm-6 col-sm-6 col-md-6"><?php echo $formHelper->text('share_sender_name_last', '', array('style'=>'width:95%;','placeholder'=>'LAST NAME')); ?></div>
            </div>
            <div class="row padless">
                <div class="col-xs-12 col-sm-6 col-sm-6 col-md-6"><?php echo $formHelper->text('share_sender_email', '', array('style'=>'width:95%;', 'placeholder'=>'EMAIL')); ?></div>
                <div class="col-xs-12 col-sm-6 col-sm-6 col-md-6"><?php echo $formHelper->text('share_sender_phone', '', array('style'=>'width:95%;','placeholder'=>'PHONE 123-456-7890')); ?></div>
            </div>
            <div class="row padless">
                <div class="col-sm-12 col-sm-12 col-md-12"><?php echo $formHelper->textarea('share_message', '', array('rows'=>'4', 'style'=>'width:97%;', 'placeholder'=>'MESSAGE')); ?></div>
            </div>

            <?php if ( $_REQUEST['entityID'] ) : ?>
            <div class="row padless checkboxes">
                <label class="checkbox">
                    <?php echo $formHelper->checkbox('inquiry[]', 'I would like more information about this property'); ?> I would like more information about this property
                </label><br>
                <label class="checkbox">
                    <?php echo $formHelper->checkbox('inquiry[]', 'I  would like more information about similar properties'); ?> I  would like more information about similar properties
                </label><br>
                <label class="checkbox">
                    <?php echo $formHelper->checkbox('inquiry[]', 'I am interested in selling a similar property'); ?> I am interested in selling a similar property
                </label><br>
                <label class="checkbox">
                    <?php echo $formHelper->checkbox('inquiry[]', 'Other'); ?> Other
                </label>
            </div>
            <?php endif; ?>

            <div class="row padless">
                <div class="col-xs-12 col-sm-12 col-md-12 captcha clearfix">
                    <?php
                    $captcha = Loader::helper('validation/captcha');
                    echo $captcha->display();
                    $captcha->showInput(array('placeholder'=>'TYPE LETTERS IN IMAGE'));
                    ?>
                </div>
            </div>

            <p style="font-size:11px;">This correspondence is private. Your email will not be viewed or stored by Carol Linton, Jackson Hole Real Estate Associates, or any third parties.</p>
            <input type="hidden" name="type" value="general_contact" />
            <?php if ( $_REQUEST['entityID'] ) : ?><input type="hidden" name="propertyID" value="<?php echo $sparkProperty->getPropertyID(); ?>" /><?php endif; ?>
        </form>

        
    </div>
</div>
<div class="modal-footer">
	<button id="submitForm" class="btn btn-red">Send Message</button>
</div>

<section class="footer">
    <div class="wide-wrap">
        <div class="row">
            <div class="col-xs-12 col-sm-3"  style="display: table-cell;vertical-align: bottom;">
                <div class="contact">
                    <img src="<?php echo REALTOR_IMAGE_PATH; ?>logo_beige.png">
                    <div class="address">
                        <?php echo $pkgConfig->get('theme.address_physical'); ?><br>
<!--                        --><?php //echo $pkgConfig->get('theme.address_po'); ?><!--<br>-->
                        <?php echo $pkgConfig->get('theme.address_state'); ?><br>
                        <?php echo $pkgConfig->get('theme.phone_number_office'); ?><br><br>
                        <?php $contact_email = $pkgConfig->get('theme.email_address'); ?>
                        <a class="email" href="mailto:<?php echo $contact_email;?>"><?php echo $contact_email;?></a>
                    </div>
                    <ul class="social">
                        <?php if ($pkgConfig->get('theme.social_link_facebook')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_facebook'); ?>"><span class="icon-facebook"></span></a></li><?php endif; ?>
                        <?php if ($pkgConfig->get('theme.social_link_twitter')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_twitter'); ?>"><span class="icon-twitter"></span></a></li><?php endif; ?>
                        <?php if ($pkgConfig->get('theme.social_link_pinterest')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_pinterest'); ?>"><span class="icon-pinterest"></span></a></li><?php endif; ?>
                        <?php if ($pkgConfig->get('theme.social_link_googleplus')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_googleplus'); ?>"><span class="icon-google-plus"></span></a></li><?php endif; ?>
                        <?php if ($pkgConfig->get('theme.social_link_linkedin')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_linkedin'); ?>"><span class="icon-linkedin"></a></li><?php endif; ?>
                        <?php if ($pkgConfig->get('theme.email_address')): ?>
                            <li class="to-mail"><a href="mailto:<?php echo $pkgConfig->get('theme.email_address'); ?>"><span class="icon-envelope"></span></a></li>
                            <li class="to-form"><a href="#" class="modalize" data-width="600" data-title="Email Us" data-load="/email"><span class="icon-envelope"></span></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3">
                <img class="portrait" src="<?php echo REALTOR_IMAGE_PATH; ?>linton_bingle_portrait.png">
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="row logos">
                    <div class="col-xs-12 col-sm-6"><img src="<?php echo REALTOR_IMAGE_PATH; ?>jackson_hole_realestate.png"></div>
                    <div class="col-xs-12 col-sm-6"><img src="<?php echo REALTOR_IMAGE_PATH; ?>christies_logo.png"></div>
                </div>
                <div class="row">
                    <div class="col-xs-12 small-print">
<!--                        --><?php //$a = new GlobalArea("Not JHREA"); $a->display($c); ?>
                        This Web site is not the official Web site of Jackson Hole Real Estate Associates. Jackson Hole Real Estate Associates does not make any representation or warranty regarding any information, including without limitation it's accuracy or completeness, contained on this Web site.
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pull-right">
                        <img src="<?php echo REALTOR_IMAGE_PATH; ?>equal_housing_logo.png">
                        <img src="<?php echo REALTOR_IMAGE_PATH; ?>luxury_logo.png">
                    </div>
                    <div class="col-xs-12 col-sm-8 pull-left small-print">
                        &copy;<?php echo date('Y');?> LintonBingle Associate Brokers. All Rights Reserved. <a href="<?php echo BASE_URL . '/legal-privacy'?>">Legal/Privacy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


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

