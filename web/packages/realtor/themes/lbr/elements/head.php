<head data-image-path="<?php echo REALTOR_IMAGE_PATH; ?>" data-tools-path="<?php echo URL::route(array('', 'realtor')); ?>">
<base href="/" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="no" />
<script>PKG_MODAL_PATH = "<?php echo REALTOR_MODAL_PATH; ?>"</script>
<?php 
// check to see if we are on a property details page 
// if so, bring in property-specific details
if ( $propertyObj ){
  $propertyPageTitle = $propertyObj->getPropertyName() . ' | LintonBingle Associate Brokers';
  $propertyPageDesc = $propertyObj->getDescription(); 
}
if(isset($propertyPageTitle)){
  Loader::element('header_required', 
    array(
      'pageTitle' => $propertyPageTitle, 
      'pageDescription' => $propertyPageDesc
    )
  );
} else {
  Loader::element('header_required');
}
?>

<?php
    if( ! $this->controller instanceof \Concrete\Package\Realtor\Controller\RealtorPageController ){
        \Concrete\Package\Realtor\Controller\RealtorPageController::attachThemeAssets($this->controller);
    }
?>
    <link rel="shortcut icon" href="/application/files/4714/5029/2458/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="/application/files/4714/5029/2458/favicon.ico" type="image/x-icon" />
    
    <?php $this->inc('elements/facebookpixelcode.php'); ?>
</head>
