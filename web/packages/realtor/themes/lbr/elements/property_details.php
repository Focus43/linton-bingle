<?php $photos = $propertyObj->getPhotos(); ?>
<?php $videos = $propertyObj->getVideos(); ?>
<div class="property-detail">


<!--        <img src="--><?php //echo $propertyObj->getFirstPhotoURL(1600) ?><!--" />-->


    <section id="gallery">
        <div class="masthead" data-transition-speed="0.5"<?php if(!$isEditMode && (count($mastheadImages) > 1)){echo ' data-loop-timing="12"';} ?>>
            <?php if(!empty($photos)): foreach($photos AS $index => $p): ?>
                <div class="node" style="background-image:url('<?php echo $p['Uri1600'] ?>');">
                    <div class="inner">
                        <div class="node-content">
                            <div class="hidden-xs" data-viz-d>
                                <?php $index++; $a = new Area("Masthead {$index}"); $a->display($c); ?>
                            </div>
                            <div class="visible-xs" data-viz-m>
                                <?php $a = new Area("Masthead Mobile {$index}"); $a->display($c); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>

            <?php if(count($photos) > 1): ?>
            <div id="showhide">
                <div></div><div></div><div></div><div></div>
            </div>
            <div class="markers thumbs hidden">
            <?php foreach ($photos AS $photoGroup) { ?>
                <a data-url="<?php echo $photoGroup['Uri1600']; ?>"
                   style="border:2px solid transparent;">
                    <img src="<?php echo $photoGroup['UriThumb']; ?>"/>
                </a>
            <?php } ?>
            </div>
            <?php endif; ?>
            <a class="arrow left"><i class="icon-keyboard-arrow-left"></i></a>
            <a class="arrow right"><i class="icon-keyboard-arrow-right"></i></a>
        </div>
        <?php if(count($photos) > 1): ?>
            <div class="circles">
                <?php for($i = 0; $i < count($photos); $i++): ?>
                    <a class="<?php echo $i === 0 ? 'active' : ''; ?>"></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="details">
        <div class="detail-wrapper">
            <h3><?php echo $propertyObj->getPropertyName(); ?></h3>
            <div class="list clearfix">
                <div>
                    <span class="bold">MLS #:</span> <?php echo $propertyObj->getMlsNumber(); ?><br>
                    <span class="bold">Beds:</span> <?php echo $propertyObj->getBathsNumber(); ?><br>
                    <span class="bold">Baths:</span> <?php echo $propertyObj->getBathsFull(); ?>&nbsp;&nbsp;&nbsp;<span class="bold">Half Baths:</span> <?php echo $propertyObj->getBathsHalf(); ?><br>
                    <span class="bold">Property Type:</span> <?php echo $propertyObj->getPropertyType(); ?>
                </div>
                <div>
                    <span class="bold">Area:</span> <?php echo $propertyObj->getMLSAreaMinor(); ?><br>
                    <span class="bold">Total Square Feet:</span> <?php echo $propertyObj->getBuildingAreaTotal(); ?><br>
                    <span class="bold">Price:</span> $<?php echo $propertyObj->getListPrice(); ?><br>
                    <span class="bold hidden-xs">Listing Brokerage:</span> <span class="hidden-xs"><?php echo $propertyObj->getListOfficeName(); ?></span>
                </div>
            </div>
            <p id="property-details"><?php echo $propertyObj->getDescription(); ?></p>
        </div>
    </section>
    <?php if ( count($videos) > 0 ) : ?>
    <section class="video">
        <div class="detail-wrapper">
        <?php foreach ( $videos as $v ) {
            echo "<div class='wrapper'>" . $v . "</div>";
        } ?>
        </div>
    </section>
    <?php endif; ?>
    <section class="googlemap">
        <div id="gmapCanvas"></div>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_KICvnn4IokmN0oXiiPlvlh9lyS3Vqko"></script>
        <script type="text/javascript">
            function initialize() {
                // create property LatLng
                var propLatLng = new google.maps.LatLng(<?php echo $propertyObj->getLatitude(); ?>,<?php echo $propertyObj->getLongitude(); ?>);
                var mapOptions = {
                    center: propLatLng,
                    zoom: 9
                };
                var map = new google.maps.Map(document.getElementById('gmapCanvas'),
                    mapOptions);
                var marker = new google.maps.Marker({
                    position: propLatLng,
                    map: map,
                    title: '<?php echo $propertyObj->getPropertyName(); ?>'
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>

    </section>
</div>