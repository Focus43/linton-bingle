<head data-image-path="<?php echo REALTOR_IMAGE_PATH; ?>" data-tools-path="<?php echo URL::route(array('', 'realtor')); ?>">
<base href="/" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="no" />
<script>PKG_MODAL_PATH = "<?php echo REALTOR_MODAL_PATH; ?>"</script>
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
<?php
    if( ! $this->controller instanceof \Concrete\Package\Realtor\Controller\RealtorPageController ){
        \Concrete\Package\Realtor\Controller\RealtorPageController::attachThemeAssets($this->controller);
    }
?>
    <?php $this->inc('elements/facebookpixelcode.php'); ?>
</head>
