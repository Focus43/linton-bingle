<!DOCTYPE HTML>
<html>
<head>
    <meta name="robots" content="noindex, nofollow" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Jackson Hole MLS property search: <?= $propertyObj->getPropertyName() ?></title>
    <link rel="stylesheet" type="text/css" href="/packages/realtor/css/print.css"/>
</head>
<body onload="window.print()">
<div id="container">
    <div id="top">
        <div class="left">
            <h1><?= $propertyObj->getPropertyName() ?></h1>
            <?php if(!empty($area)): ?><h2><?= $area ?></h2><?php endif; ?>
            <?php if(!empty($firstPhotoUrl)): ?><img src="<?= $firstPhotoUrl; ?>" width="298" id="mainImage"/><?php endif; ?>
            <?php if(!empty($latitude) && !empty($longitude)): ?>
<!--                <img src="http://maps.google.com/maps/api/staticmap?sensor=false&size=298x199&markers=color:orange|--><?//= $latitude . ',' . $longitude ?><!--&zoom=12&key=AIzaSyB8v02iNSe4NYyS7YQmTMwklN7FZds52Ck" width="298" id="mapImage"/>-->
            <?php endif; ?>
        </div>
        <div class="right">
            <div id="agentInfo">
                <h4>LintonBingle Associate Brokers</h4>
                Phone: +1 (307) 732-7518 (Office)<br>
                Email: lintonbingle@gmail.com
<!--                <br>-->
<!--                +1 (307) 699-1139 (Carol's Cell)<br>-->
<!--                +1 (307) 732-8090 (Betsy's Cell)-->
            </div>

            <div id="propertyDetails">
                <?php if(!empty($price)): ?><span id="price"><?= $price ?></span><?php endif; ?>
                <div id="propertyInfo">
                    Property Type: <?= $propertyObj->getPropertyType() ?><br>
                    <?php if($beds > 0): ?>Beds: <?= $beds ?><br><?php endif; ?>
                    <?php if($fullBaths > 0 || $halfBaths > 0): ?>Baths: <?= $fullBaths > 0 ? $fullBaths . '&nbsp;&nbsp;&nbsp;' : '' ?><?= $halfBaths > 0 ? 'Half Baths: ' . $halfBaths : '' ?><br><?php endif; ?>
                    <?php if(!empty($squareFeet)): ?>Total Square Feet: <?= $squareFeet ?><br><?php endif; ?>
                    Listing Brokerage: <?= $propertyObj->getListOfficeName() ?>
                </div>
                <?php if(!empty($mls)): ?>
                    <div id="mls">
                        MLS Number: <?= $mls ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <?php if(!empty($details)): ?>
        <div id="description">
            <h3>Description</h3>
            <?= $details ?>
        </div>
    <?php endif; ?>
    <div id="middle">
        <div class="left">
            <h1><?= $propertyObj->getPropertyName() ?></h1>
            <?php if (!empty($area)): ?><h2><?= $area ?></h2><?php endif; ?>
        </div>
        <div class="right">
            <div id="agentInfo">
                <h4>LintonBingle Associate Brokers</h4>
                <?php echo $pkgConfig->get('theme.phone_number_office'); ?> (Office)
<!--                <br>-->
<!--                --><?php //echo $pkgConfig->get('theme.phone_number_cell'); ?><!-- (Cell)<br>-->
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <?php foreach ($propertyObj->getPhotos() AS $photoGroup): ?>
        <div class="photo"><img src="<?= $photoGroup['Uri640'] ?>" height="132"></div>
    <?php endforeach; ?>
</div>

<script type="text/javascript">

//    var _gaq = _gaq || [];
//    _gaq.push(['_setAccount', 'UA-23055981-1']);
//    _gaq.push(['_trackPageview']);
//
//    (function () {
//        var ga = document.createElement('script');
//        ga.type = 'text/javascript';
//        ga.async = true;
//        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
//        var s = document.getElementsByTagName('script')[0];
//        s.parentNode.insertBefore(ga, s);
//    })();

</script>
</body>
</html>