<!--<section class="pagination">-->
    <div class="resultsCtrl">
<!--        --><?php //if ($areaName) {
//            echo "<h3> PROPERTIES IN " . strtoupper($areaName) . "</h3>";
//        } ?>
        <div class="pager">
            <?php echo "Showing <strong>{$paginationResultFrom} to {$paginationResultTo}</strong> of <strong>{$totalResults}</strong>"; ?>
            <br class="visible-xs">
            <a href="<?php echo $previousUrl; ?>">Previous</a>
            <a href="<?php echo $nextUrl; ?>">Next</a>
        </div>

        <div class="sortby clearfix">
            <div class="sorter">
                <div class="copy">SORT BY <?php echo $this->controller->getSortByString(); ?></div>
                <div class="arrow"><i class="icon-expand-more"></i></div>
            </div>
            <div class="list">
                <div class="sortbyList">
                    <ul>
                        <li><a href="<?php echo $this->controller->linkto('properties', array('sortby' => 'price_desc')); ?>"><i class="icon-chevron-down"></i> Price (High to Low)</a></li>
                        <li><a href="<?php echo $this->controller->linkto('properties', array('sortby' => 'price_asc')); ?>"><i class="icon-chevron-down"></i> Price (Low to High)</a></li>
                        <li><a href="<?php echo $this->controller->linkto('properties', array('sortby' => 'beds_desc')); ?>"><i class="icon-chevron-up"></i> Beds (High to Low)</a></li>
                        <li><a href="<?php echo $this->controller->linkto('properties', array('sortby' => 'beds_asc')); ?>"><i class="icon-chevron-down"></i> Beds (Low to High)</a></li>
                        <li><a href="<?php echo $this->controller->linkto('properties', array('sortby' => 'baths_desc')); ?>"><i class="icon-chevron-up"></i> Baths (High to Low)</a></li>
                        <li><a href="<?php echo $this->controller->linkto('properties', array('sortby' => 'baths_asc')); ?>"><i class="icon-chevron-down"></i> Baths (Low to High)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<!--</section>-->
