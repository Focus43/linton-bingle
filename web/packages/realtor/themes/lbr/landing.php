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
                                <div class="hidden-xs" data-viz-d>
                                    <h3><?php $a = new Area("Header"); $a->display($c); ?></h3>
                                    <p><?php $a = new Area("Copy"); $a->display($c); ?></p>
                                    <?php $a = new Area("Button"); $a->display($c); ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
        <section class="content wide-wrap">
            <?php $a = new Area("Content"); $a->display($c); ?>
        </section>

        <?php $this->inc('elements/footer.php'); ?>
        <?php $this->inc('elements/header.php'); ?>
    </main>

</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>