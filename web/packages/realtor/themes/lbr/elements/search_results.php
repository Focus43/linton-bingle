<?php

	$imageHelper	= Loader::helper('image');
	$textHelper 	= Loader::helper('text');

	foreach($searchResults AS $sparkProperty){ 
//		$pageURL = View::url('properties', 'id', $sparkProperty->getId());
        print_r($sparkProperty);
		?>
        <br><br>
<!--		<div class="property-row clearfix">-->
<!--			<a class="pic textured less-padding" href="--><?php //echo $pageURL; ?><!--">-->
<!--				<img src="--><?php //echo $sparkProperty->getFirstPhotoURL(); ?><!--" />-->
<!--			</a>-->
<!--			<div class="info">-->
<!--				<h3>--><?php //echo $sparkProperty->getPropertyName(); ?><!--</h3>-->
<!--				<p>--><?php //echo $textHelper->shortenTextWord( $sparkProperty->getPublicRemarks(), 250 ); ?><!--</p>-->
<!--				<div class="details">-->
<!--					<p>MLS Number: <strong>--><?php //echo $sparkProperty->getListingId(); ?><!--</strong><br />-->
<!--						Property Type: <strong>--><?php //echo $sparkProperty->getPropertyType(); ?><!--</strong><br />-->
<!--						Price: <strong>$--><?php //echo number_format( (int) $sparkProperty->getListPrice(), 2 ); ?><!--</strong><br />-->
<!--						Beds: <strong>--><?php //echo $sparkProperty->getBedsTotal(); ?><!--</strong> &nbsp;&nbsp; Full Baths: <strong>--><?php //echo $sparkProperty->getBathsTotal(); ?><!--</strong>-->
<!--					</p>-->
<!--					<a class="btn linton-blue" href="--><?php //echo $pageURL; ?><!--">View Property Details <i class="icon-chevron-right icon-white"></i></a>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
	<?php }
