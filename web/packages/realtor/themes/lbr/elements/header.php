<header>
    <div class="trigger"><a></a></div>
    <nav>
        <a href="/" class="logo"></a>
        <div class="navigation clearfix">
            <?php
            $blockTypeNav                                       = BlockType::getByHandle('autonav');
            $blockTypeNav->controller->orderBy                  = 'display_asc';
            $blockTypeNav->controller->displayPages             = 'top';
            $blockTypeNav->controller->displaySubPages          = 'all';
            $blockTypeNav->controller->displaySubPageLevels     = 'custom';
            $blockTypeNav->controller->displaySubPageLevelsNum  = 1;
            $blockTypeNav->controller->pkgConfig                = $pkgConfig;
            $blockTypeNav->render('templates/sidebar_nav');
            ?>
        </div>
    </nav>
    <ul class="social hidden-sm">
        <?php if ($pkgConfig->get('theme.social_link_facebook')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_facebook'); ?>"><span class="icon-facebook"></span></a></li><?php endif; ?>
        <?php if ($pkgConfig->get('theme.social_link_twitter')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_twitter'); ?>"><span class="icon-twitter"></span></a></li><?php endif; ?>
        <?php if ($pkgConfig->get('theme.social_link_pinterest')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_pinterest'); ?>"><span class="icon-pinterest"></span></a></li><?php endif; ?>
        <?php if ($pkgConfig->get('theme.social_link_googleplus')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_googleplus'); ?>"><span class="icon-google-plus"></span></a></li><?php endif; ?>
        <?php if ($pkgConfig->get('theme.social_link_linkedin')): ?><li><a href="<?php echo $pkgConfig->get('theme.social_link_linkedin'); ?>"><span class="icon-linkedin"></a></li><?php endif; ?>
        <?php if ($pkgConfig->get('theme.email_address')): ?>
            <li class="visible-sm"><a href="mailto:<?php echo $pkgConfig->get('theme.email_address'); ?>"><span class="icon-envelope"></span></a></li>
            <li class="hidden-sm"><a href="#" class="modalize" data-width="600" data-title="Email Us" data-load="/email"><span class="icon-envelope"></span></a></li>
        <?php endif; ?>
    </ul>
</header>