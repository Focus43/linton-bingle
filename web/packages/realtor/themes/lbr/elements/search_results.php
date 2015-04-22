<?php

	$imageHelper	= Loader::helper('image');
	$textHelper 	= Loader::helper('text');

	foreach($searchResults AS $sparkProperty){ 
//		$pageURL = View::url('properties', 'id', $sparkProperty->getId());
        print_r($sparkProperty);
		?>
        <br><br>
	<?php }
