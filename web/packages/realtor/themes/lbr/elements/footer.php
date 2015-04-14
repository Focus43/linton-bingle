<section class="footer">
    <div class="wide-wrap">
        <div class="row table">
            <div class="col-xs-12 col-sm-3"  style="display: table-cell;vertical-align: bottom;">
                <div class="contact">
                    <img src="<?php echo REALTOR_IMAGE_PATH; ?>logo_beige.png">
                    <?php
                    $a = new GlobalArea('Footer - Address');
                    $a->display($c);
                    ?>
                    <ul class="social">
                        <li><a href=""><span class="icon-facebook"></span></a></li>
                        <li><a href=""><span class="icon-twitter"></span></a></li>
                        <li><a href=""><span class="icon-pinterest"></span></a></li>
                        <li><a href=""><span class="icon-google-plus"></span></a></li>
                        <li><a href=""><span class="icon-linkedin"></a></li>
                        <li><a href=""><span class="icon-envelope"></span></a></li>
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
                        <?php $a = new Area("Not JHREA"); $a->display($c); ?>
                        This Web site is not the official Web site of Jackson Hole Real Estate Associates. Jackson Hole Real Estate Associates does not make any representation or warranty regarding any information, including without limitation it's accuracy or completeness, contained on this Web site.
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pull-right">
                        <img src="<?php echo REALTOR_IMAGE_PATH; ?>equal_housing_logo.png">
                        <img src="<?php echo REALTOR_IMAGE_PATH; ?>luxury_logo.png">
                    </div>
                    <div class="col-xs-12 col-sm-8 pull-left small-print">
                        © 2015 Carol Linton Real Estate. All Rights Reserved. Legal/Privacy
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>