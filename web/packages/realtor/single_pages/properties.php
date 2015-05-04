    <?php if ( $propertyObj ) {
            $this->inc('elements/property_details.php');
        } else { ?>

            <?php if ( $area ) {
                $this->inc('elements/area_details.php');
            } else {
                $this->inc('elements/search_form.php');
            } ?>

            <?php $this->inc('elements/search_pagination.php'); ?>
            <section class="results skinny-wrap">
                <?php foreach ( $searchResults as $idx => $p ) : ?>
                    <div class="listing clearfix">
                        <a href="/properties/id/<?php echo $p->getPropertyID(); ?>/"><div class="photo" style="background-image: url('<?php echo $p->getFirstPhotoURL("640"); ?>')"></div></a>
                        <div class="details">
                            <a href="/properties/id/<?php echo $p->getPropertyID(); ?>/"><?php echo $p->getPropertyName(true); ?></a>
                            <div class="numbers clearfix">
                                <div class="left">
                                    MLS #: <?php echo $p->getMlsNumber(); ?><br>
                                    Property Type: <?php echo $p->getPropertyType(); ?>
                                </div>
                                <div class="right">
                                    Price: $<?php echo $p->getListPrice(); ?><br>
                                    Beds: <?php echo $p->getBedsNumber(); ?> Bath: <?php echo $p->getBathsNumber(); ?><br>
                                </div>
                            </div>
                            <div class="description"><?php echo Concrete\Core\Utility\Service\Text::shortenTextWord($p->getDescription(), 500); ?></div>
                        </div>
                    </div>
                    <?php if ( count($searchResults) > $idx + 1 ) : ?><div class="divider-line"></div><?php endif; ?>
                <?php endforeach; ?>
            </section>
            <div class="skinny-wrap small-print disclaimer">
                Information provided through the Teton IDX Program is provided for consumer's personal, non-commercial use and may
                not be used for any purpose other than to identify prospective properties and individual consumers interested in
                purchasing. Properties displayed through the Teton IDX Program may be selected by and displayed by an IDX
                participant, who may not necessarily be the listing agent. Any information contained herein is deemed reliable, but
                not guaranteed and the Teton MLS is not responsible or liable for the information.<br>
                The information on this sheet has been made available by the MLS and may not be the listing of the provider.
            </div>

        <?php } ?>


