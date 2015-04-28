<?php if( !empty($buttonObj->getClasses()) ): ?>
    <a class="btn <?php echo join(' ', $buttonObj->getClasses()); ?>" href="<?php echo View::url($buttonObj->getPageObj()->getCollectionPath()); ?>" target="<?php echo $buttonObj->getTarget(); ?>">
        <?php echo $buttonObj; ?>
    </a>
<?php else: ?>
    <a class="btn btn-default" href="<?php echo View::url($buttonObj->getPageObj()->getCollectionPath()); ?>" target="<?php echo $buttonObj->getTarget(); ?>">
        <?php echo $buttonObj; ?>
    </a>
<?php endif;