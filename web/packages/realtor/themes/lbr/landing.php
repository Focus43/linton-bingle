<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="pg-landing">
<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <main slideable>
        <section class="hero">
<!--            --><?php //$a = new Area("Photo"); $a->display($c); ?>
            <div class="masthead">
                    <div class="node" >
                        <div class="inner clearfix">
                            <div class="node-image"><?php $a = new Area("Choose Background Image"); $a->display($c); ?></div>
                            <div class="node-content">
                                <div>
                                    <h3><?php $a = new Area("Header"); $a->display($c); ?></h3>
<!--                                    <div class="hidden-xs">--><?php //$a = new Area("Copy"); $a->display($c); ?><!--</div>-->
                                    <div><?php $a = new Area("Copy"); $a->display($c); ?></div>
                                    <?php $a = new Area("Button"); $a->display($c); ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
        <section class="current-level-nav skinny-wrap">
            <?php
            $blockTypeNav                                       = BlockType::getByHandle('autonav');
            $blockTypeNav->controller->orderBy                  = 'display_desc';
            $blockTypeNav->controller->displayPages             = 'second_level';
            $blockTypeNav->controller->displaySubPages          = 'enough';
            $blockTypeNav->controller->displaySubPageLevels     = 'enough';
            $blockTypeNav->controller->displaySubPageLevelsNum  = 1;
            $blockTypeNav->render('templates/landing_page_main_nav');
            ?>
        </section>
        <section class="subnav wide-wrap">
            <?php
            //then within each listing create a new page list instance
            $pageList = new \PageList();
            $pageList->filterByParentID($c->getCollectionID());
            $pageList->sortByPublicDateDescending();
            $pageList->get(10);
            $pages = $pageList->get();
            var_dump($pages);
            //that will grab a collection of all the current pages within that page
            //then you should just need to play around with echoing out the bits you need?
            //something like
            //no idea if this would work I can not remember if the $pages is an object or an array? but I think its an array
            foreach($pages as $page){
            //display page information
            }

            ?>


<!--            --><?php
//            $blockTypeNav                                       = BlockType::getByHandle('autonav');
//            $blockTypeNav->controller->orderBy                  = 'display_desc';
//            $blockTypeNav->controller->displayPages             = 'below';
//            $blockTypeNav->controller->displaySubPages          = 'all';
//            $blockTypeNav->controller->displaySubPageLevels     = 'all';
//            $blockTypeNav->controller->displaySubPageLevelsNum  = 1;
//            $blockTypeNav->render('templates/landing_page_nav');
//            ?>

        </section>

        <?php $this->inc('elements/footer.php'); ?>
        <?php $this->inc('elements/header.php'); ?>
    </main>

</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>