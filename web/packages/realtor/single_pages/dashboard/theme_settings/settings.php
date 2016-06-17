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
                            <td><?php echo $formHelper->text('social_link_facebook', $pkgConfig->get('theme.social_link_facebook'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Twitter</td>
                            <td><?php echo $formHelper->text('social_link_twitter', $pkgConfig->get('theme.social_link_twitter'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Youtube</td>
                            <td><?php echo $formHelper->text('social_link_youtube', $pkgConfig->get('theme.social_link_youtube'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Instagram</td>
                            <td><?php echo $formHelper->text('social_link_instagram', $pkgConfig->get('theme.social_link_instagram'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>LinkedIn</td>
                            <td><?php echo $formHelper->text('social_link_linkedin', $pkgConfig->get('theme.social_link_linkedin'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Pinterest</td>
                            <td><?php echo $formHelper->text('social_link_pinterest', $pkgConfig->get('theme.social_link_pinterest'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Google+</td>
                            <td><?php echo $formHelper->text('social_link_googleplus', $pkgConfig->get('theme.social_link_googleplus'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="span-pane-half">
                    <h3>Contact</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Email Address</td>
                            <td><?php echo $formHelper->text('email_address', $pkgConfig->get('theme.email_address'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number - Cell</td>
                            <td><?php echo $formHelper->text('phone_number_cell', $pkgConfig->get('theme.phone_number_cell'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number - Office</td>
                            <td><?php echo $formHelper->text('phone_number_office', $pkgConfig->get('theme.phone_number_office'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Fax</td>
                            <td><?php echo $formHelper->text('fax', $pkgConfig->get('theme.fax'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="span-pane-half">
                    <h3>Address</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Address - Physical</td>
                            <td><?php echo $formHelper->text('address_physical', $pkgConfig->get('theme.address_physical'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Address - Mailing</td>
                            <td><?php echo $formHelper->text('address_po', $pkgConfig->get('theme.address_po'), array('class' => 'input-block-level')); ?></td>
                        </tr>
                        <tr>
                            <td>Address - State, Zip</td>
                            <td><?php echo $formHelper->text('address_state', $pkgConfig->get('theme.address_state'), array('class' => 'input-block-level')); ?></td>
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