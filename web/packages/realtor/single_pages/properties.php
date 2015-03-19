<?php if( $this->controller->getTask() == 'id' ): ?>

<!--	--><?php
//		Loader::packageElement('property_details', 'linton', array(
//			'propertyObj'	=> $propertyObj,
//			'formHelper'	=> Loader::helper('form'),
//			'lastSearch'	=> LintonPropertySearch::getLastSearchRequest()
//		));
//	?>
	
<?php else: ?>
	
<!--	--><?php //Loader::packageElement('search_fields', 'linton', array('pagingHelper' => $pagingHelper)); ?>

	<div class="opaque-border">
		<div class="opaque-inner clearfix">
			<div class="textured">
				<div class="bottom-border top-area clearfix">
					<h2 style="float:left;">All Properties</h2>
<!--					--><?php //Loader::packageElement('sort_button_bar', 'linton', array(
//						'pagingHelper' => $pagingHelper
//					)); ?>
				</div>
				<div id="propertySearch">
<!--					--><?php //Loader::packageElement('spark_search_results', 'linton', array('searchResults' => $searchResults)) ?>
                    <?php $this->inc('elements/search_results.php'); ?>
				</div>
				<div class="bottom-area">
<!--					--><?php //Loader::packageElement('sort_button_bar', 'linton', array(
//						'pagingHelper' => $pagingHelper
//					)); ?>
				</div>
			</div>
		</div>
	</div>
	
<?php endif; ?>

<p id="mls_disclaimer">Information provided through the Teton IDX Program is provided for consumer's personal, non-commercial use and may
    not be used for any purpose other than to identify prospective properties and individual consumers interested in
    purchasing. Properties displayed through the Teton IDX Program may be selected by and displayed by an IDX
    participant, who may not necessarily be the listing agent. Any information contained herein is deemed reliable, but
    not guaranteed and the Teton MLS is not responsible or liable for the information.<br>
    The information on this sheet has been made available by the MLS and may not be the listing of the provider.</p>