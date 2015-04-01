<header>
    <a class="trigger"></a>
    <nav>
        <div class="logo"></div>
        <?php
        $blockTypeNav                                       = BlockType::getByHandle('autonav');
        $blockTypeNav->controller->orderBy                  = 'display_asc';
        $blockTypeNav->controller->displayPages             = 'top';
        $blockTypeNav->controller->displaySubPages          = 'all';
        $blockTypeNav->controller->displaySubPageLevels     = 'custom';
        $blockTypeNav->controller->displaySubPageLevelsNum  = 1;
        $blockTypeNav->render('templates/sidebar_nav');
        ?>
    </nav>
</header>