<div class="masthead" data-transition-speed="0.5"<?php if(!$isEditMode && (count($fileListResults) > 1)){echo ' data-loop-timing="12"';} ?>>
    <?php if(!empty($fileListResults)): foreach((array)$fileListResults AS $fileObj): ?>
        <div class="node" >
            <div class="inner clearfix">
                <div class="node-image" style="background-image:url('<?php echo $fileObj->getRelativePath(); ?>');"></div>
                <div class="node-content">
                    <div class="hidden-xs" data-viz-d>
                        <?php echo $fileObj->getAttribute("associated_copy"); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; endif; ?>
</div>
<?php //if(count($fileListResults) > 1): ?>
<!--    <div class="circles">-->
<!--        --><?php //for($i = 0; $i < count($fileListResults); $i++): ?>
<!--            <a class="--><?php //echo $i === 0 ? 'active' : ''; ?><!--"></a>-->
<!--        --><?php //endfor; ?>
<!--    </div>-->
<?php //endif; ?>