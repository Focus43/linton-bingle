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
</header>