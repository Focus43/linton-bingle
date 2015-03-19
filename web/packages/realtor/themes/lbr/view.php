<!DOCTYPE HTML>
<html ng-app="sequence" ng-controller="CtrlRoot" ng-class="rootClasses" lang="<?php echo LANGUAGE; ?>" class="<?php echo $isEditMode ? 'cms-edit-mode' : ''; ?>">
<?php $this->inc('elements/head.php'); ?>

<body>

    <div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
        <?php $this->inc('elements/header.php'); ?>

        <main slideable>
            <section>
                <?php echo $innerContent; ?>
            </section>

            <footer>TitleCard Capital&trade;. Copyright &copy; <?php echo date('Y'); ?></footer>
        </main>
        <aside scroll-top class="icn-angle-up"></aside>
    </div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>