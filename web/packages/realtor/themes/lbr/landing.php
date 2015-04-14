<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="pg-home">
<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <main slideable>
        <section class="hero">
            <div class="masthead" data-transition-speed="0.5"<?php if(!$isEditMode && (count($mastheadImages) > 1)){echo ' data-loop-timing="12"';} ?>>
                <?php if(!empty($mastheadImages)): foreach($mastheadImages AS $index => $fileObj): ?>
                    <div class="node" style="background-image:url('<?php echo $fileObj->getRelativePath(); ?>');">
                        <div class="inner">
                            <div class="node-content">
                                <div class="hidden-xs" data-viz-d>
                                    <?php $index++; $a = new Area("Masthead {$index}"); $a->display($c); ?>
                                </div>
<!--                                <div class="visible-xs" data-viz-m>-->
<!--                                    --><?php //$a = new Area("Masthead Mobile {$index}"); $a->display($c); ?>
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>

                <?php if(count($mastheadImages) > 1): ?>
                    <?php if ( $isEditMode ) { ?>
                        <a class="arrows icon-arrow-left"></a>
                        <a class="arrows icon-arrow-right"></a>
                    <?php } ?>
                    <div class="markers">
                        <?php for($i = 0; $i < count($mastheadImages); $i++): ?>
                            <a class="<?php echo $i === 0 ? 'active' : ''; ?>"><i class="icn-circle"></i></a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
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