<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="pg-default">
<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <main slideable>
        <section class="hero">
            <div class="masthead">
                <div class="node" >
                    <div class="inner clearfix">
                        <div class="node-image" style="background-image: url('<?php echo ($c->getAttribute('page_image')) ? $c->getAttribute('page_image')->getRelativePath() : REALTOR_IMAGE_PATH . 'nav_placeholder.jpg' ?>')">
<!--                            --><?php //$a = new Area("Choose Background Image"); $a->display($c); ?>
                        </div>
                        <div class="node-content">
                            <div>
                                <h3>
                                    <?php echo $c->getCollectionName(); ?>
<!--                                    --><?php //$a = new Area("Header"); $a->display($c); ?>
                                </h3>
                                <div>
                                    <?php echo $c->getCollectionDescription(); ?>
<!--                                    --><?php //$a = new Area("Copy"); $a->display($c); ?>
                                </div>
                                <?php $a = new Area("Button"); $a->display($c); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php if ( substr_count($_SERVER['REQUEST_URI'], "blog") == 0 ) : ?>
        <section class="current-level-nav skinny-wrap">
            <?php
            $blockTypeNav                                       = BlockType::getByHandle('autonav');
            $blockTypeNav->controller->orderBy                  = 'display_asc';
            $blockTypeNav->controller->displayPages             = 'current';
            $blockTypeNav->controller->displaySubPages          = 'enough';
            $blockTypeNav->controller->displaySubPageLevels     = 'enough';
            $blockTypeNav->controller->displaySubPageLevelsNum  = 1;
            $blockTypeNav->render('templates/landing_page_main_nav');
            ?>
        </section>
        <?php endif; ?>

        <section class="content wide-wrap">
            <div class="content-padding"><?php $a = new Area("Content 1"); $a->display($c); ?></div>
        </section>
        <section class="content wide-wrap" style="padding-bottom: 20px;">
            <div class="content-padding"><?php $a = new Area("Content 2"); $a->display($c); ?></div>
        </section>
        <?php $this->inc('elements/footer.php'); ?>
        <?php $this->inc('elements/header.php'); ?>
    </main>

</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>