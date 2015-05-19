<div class="area-details">
    <section class="hero">
        <div class="masthead" data-transition-speed="0.5"<?php if(!$isEditMode && (count($mastheadImages) > 1)){echo ' data-loop-timing="7"';} ?>>
            <?php if(!empty($mastheadImages)): foreach($mastheadImages AS $index => $fileObj): if ( $fileObj && $fileObj->getRelativePath() ): ?>
                <div class="node" style="background-image:url('<?php echo $fileObj->getRelativePath(); ?>');">
                    <div class="inner">
                        <div class="node-content">
                            <div>
                                <h2><?php echo $fileObj->getTitle(); ?></h2>
                                <?php echo $fileObj->getDescription(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; endforeach; endif; ?>

            <?php if(count($mastheadImages) > 1): ?>
                <?php if ( $isEditMode ) { ?>
                    <a class="edit-arrows arrows icon-keyboard-arrow-left"></a>
                    <a class="edit-arrows arrows icon-keyboard-arrow-right"></a>
                <?php } ?>
                <div class="circles">
                    <?php for($i = 0; $i < count($mastheadImages); $i++): ?>
                        <a class="<?php echo $i === 0 ? 'active' : ''; ?>"></a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="current-level-nav skinny-wrap">
        <h2>NEIGHBORHOODS IN <?php echo $areaName; ?></h2>
        <ul>
        <?php foreach ( $areaSubs as $sub ) : ?>
            <li><a data-area="<?php echo $sub->getShortName(); ?>"><?php echo $sub->getName(); ?></a></li>
        <?php endforeach; ?>
        </ul>
    </section>

    <section class="sub-areas">
        <div class="masthead" data-transition-speed="0.5"<?php if(!$isEditMode && (count($mastheadImages) > 1)){echo ' data-loop-timing="5"';} ?>>
            <?php if(!empty($areaSubs)): foreach($areaSubs AS $index => $sub): ?>
                <?php
                $image = File::getByID((int)$sub->getImageID());
                $imagePath = ( $image && $image->getRelativePath() && $image->getRelativePath() != "" ) ? $image->getRelativePath() : REALTOR_IMAGE_PATH . 'nav_placeholder.jpg';
                ?>
                <div class="node" data-sub="<?php echo $sub->getShortName(); ?>">
                    <div class="inner clearfix">
                        <div class="node-image"style="background-image:url('<?php echo $imagePath; ?>');"></div>
                        <div class="node-content">
                            <div>
                                <h3><a href="/properties?<?php echo $sub->getSearchQuery(); ?>"><?php echo $sub->getName(); ?></a></h3>
                                <p><?php echo $sub->getDescription(); ?></p>
                                <a class="btn btn-white" href="/properties?<?php echo $sub->getSearchQuery(); ?>">VIEW PROPERTIES</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </section>
</div>