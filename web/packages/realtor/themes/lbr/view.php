<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $isEditMode ? 'cms-edit-mode' : ''; ?>">
<?php $this->inc('elements/head.php'); ?>

<body class="<?php echo $pageClass; ?>">

    <div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
        <main slideable>
            <?php echo $innerContent; ?>
            <?php $this->inc('elements/footer.php'); ?>
            <?php $this->inc('elements/header.php'); ?>
        </main>
        <aside scroll-top class="icn-angle-up"></aside>
    </div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
    <?php $this->inc('elements/googleanalytics.php'); ?>
</body>
</html>