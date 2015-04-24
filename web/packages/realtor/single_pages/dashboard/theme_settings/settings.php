<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Theme Settings'), t('Configure Miscellaneous Items'), false, false ); ?>
    <style type="text/css">
        #theme-settings {}
        #theme-settings h3 {margin-bottom:8px;}
        #theme-settings .btn {width:100%;display:block;}
        #theme-settings table td {vertical-align:middle;}
        #theme-settings table tbody tr td:first-child {width:1%;white-space:nowrap;}
    </style>

    <div id="theme-settings" class="ccm-pane-body">

        <form action="<?php echo $this->action('save'); ?>" method="POST">
            <div class="row">
                <div class="span-pane-half">
                    <h3>Social Links</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Facebook</td>
                            <td><?php echo $formHelper->text('theme_social_link_facebook', $pkgConfig->get('theme_social_link_facebook'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Twitter</td>
                            <td><?php echo $formHelper->text('theme_social_link_twitter', $pkgConfig->get('theme_social_link_twitter'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Youtube</td>
                            <td><?php echo $formHelper->text('theme_social_link_youtube', $pkgConfig->get('theme_social_link_youtube'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>LinkedIn</td>
                            <td><?php echo $formHelper->text('theme_social_link_linkedin', $pkgConfig->get('theme_social_link_linkedin'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Pinterest</td>
                            <td><?php echo $formHelper->text('theme_social_link_pinterest', $pkgConfig->get('theme_social_link_linkedin'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Google+</td>
                            <td><?php echo $formHelper->text('theme_social_link_googleplus', $pkgConfig->get('theme_social_link_linkedin'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="span-pane-half">
                    <h3>Display</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Email Address</td>
                            <td><?php echo $formHelper->text('theme_email_address', $pkgConfig->get('theme_email_address'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td><?php echo $formHelper->text('theme_phone_number', $pkgConfig->get('theme_phone_number'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="span-pane-half">
                    <h3>Footer Items</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Twitter Feed Handle</td>
                            <td><?php echo $formHelper->text('theme_twitter_feed_handle', $pkgConfig->get('theme_twitter_feed_handle'), array('class' => 'input-block-level', 'placeholder' => 'Leave off @ symbol')); ?></td>
                        </tr>
                        <tr>
                            <td>Twitter Feed Widget ID</td>
                            <td><?php echo $formHelper->text('theme_twitter_widget_id', $pkgConfig->get('theme_twitter_widget_id'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-large btn-block btn-success">Save</button>
        </form>

    </div>
    <div class="ccm-pane-footer"></div>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>