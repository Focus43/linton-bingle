<head data-image-path="<?php echo SEQUENCE_IMAGE_PATH; ?>" data-tools-path="<?php echo URL::route(array('', 'sequence')); ?>">
<base href="/" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="no" />
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
<?php echo $html->css($view->getStylesheet('theme.less')); ?>
</head>
