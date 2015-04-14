<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $isEditMode ? 'cms-edit-mode' : ''; ?>">
<?php $this->inc('elements/head.php'); ?>

<body class="<?php echo $pageClass; ?>">

    <div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
        <?php $this->inc('elements/header.php'); ?>

        <main slideable>
            <?php echo $innerContent; ?>
        </main>
        <aside scroll-top class="icn-angle-up"></aside>
    </div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>