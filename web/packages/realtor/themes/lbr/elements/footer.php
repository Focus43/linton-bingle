<?php
    // $pkgConfig = \Concrete\Package\Realtor\Controller::getPackageConfigObj();
?>
<section class="footer">
    <div class="wide-wrap">
        <div class="row table">
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