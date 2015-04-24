<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="pg-landing">
<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <main slideable>
        <section class="hero">
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
        <section class="wide-wrap"><h2><?php echo $c->getCollectionName(); ?></h2></section>
        <section class="content wide-wrap">
            <?php $a = new Area("Content 1"); $a->display($c); ?>
        </section>
        <section class="content wide-wrap">
            <?php $a = new Area("Content 2"); $a->display($c); ?>
        </section>
        <?php $this->inc('elements/footer.php'); ?>
        <?php $this->inc('elements/header.php'); ?>
    </main>

</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>