<?php $photos = $propertyObj->getPhotos(); ?>
<?php $videos = $propertyObj->getVideos(); ?>
<script>
    PROP_CITY = "<?php echo $propertyObj->getCity() ?>";
    PROP_TYPE = "<?php echo $propertyObj->getPropertyType(false); ?>";
    PROP_PRICE = "<?php echo $propertyObj->getListPricePlain() ?>";
    PROP_ID = "<?php echo $propertyObj->getPropertyID() ?>";
</script>
<div class="property-detail">
    <section id="gallery">
        <div class="masthead" data-transition-speed="0.5"<?php if(!$isEditMode && (count($mastheadImages) > 1)){echo ' data-loop-timing="6"';} ?>>
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
            <h1><?php echo $propertyObj->getPropertyName(); ?></h1>
            <div class="list clearfix">
                <div>
                    <span class="bold">MLS #:</span> <?php echo $propertyObj->getMlsNumber(); ?><br>
                    <span class="bold">Beds:</span> <?php echo $propertyObj->getBedsNumber(); ?><br>
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
            <div class="action-buttons">
                <a href="/properties/print_friendly/<?= $propertyObj->getPropertyID() ?>" class="btn btn-red" id="brochure">VIEW BROCHURE</a>
                <button class="btn btn-red modalize" id="inquire" data-title="Inquire About Property"data-entity-id="<?php echo $propertyObj->getPropertyID(); ?>" data-load="/inquire">INQUIRE ABOUT PROPERTY</button>

                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-white">BACK TO SEARCH</a>
            </div>
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
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA_KICvnn4IokmN0oXiiPlvlh9lyS3Vqko"></script>
        <script type="text/javascript">
            function initialize() {
                var propLatLng = new google.maps.LatLng(<?php echo $propertyObj->getLatitude(); ?>,<?php echo $propertyObj->getLongitude(); ?>);
                var mapOptions = {
                    zoom: 13,
                    center: propLatLng,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DEFAULT,
                        mapTypeIds: [
                            google.maps.MapTypeId.ROADMAP,
                            google.maps.MapTypeId.TERRAIN
                        ]
                    },
                    zoomControl: true,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.SMALL
                    },
                    scrollwheel: false
                };
                var map = new google.maps.Map(document.getElementById('gmapCanvas'), mapOptions);
                var marker = new google.maps.Marker({
                    position: propLatLng,
                    map: map,
                    title: '<?php echo $propertyObj->getPropertyName(); ?>'
                });
            }

            google.maps.event.addDomListener(window, 'load', initialize);

        </script>
        <div class="featured-round">Related Properties</div>
    </section>
    <section class="related">
        <div id="relatedListings">
            <div style="text-align: center;padding: 20px;"><span class="icon-spinner spinner spinner--steps"></span></div>
        </div>
        <script id="relatedList" type="x-tmpl-mustache">
                {{#properties}}
                <div class="property clearfix">
                    <a href="/properties/id/{{id}}"><div class="main-image" style="background-image:url('{{mainImage}}')"></div></a>
                    <h4>{{name}}</h4>
                    <p class="hidden-sm">{{shortDescription}}</p>
                    <a class="btn btn-white" href="/properties/id/{{id}}">VIEW DETAILS</a>
                </div>
                {{/properties}}
                <div class="featured-round">Related Properties</div>
            </script>
    </section>
</div>