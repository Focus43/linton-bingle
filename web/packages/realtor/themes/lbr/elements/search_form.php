<?php

use Concrete\Package\Realtor\Src\PropertySearch\SparkConnection as SparkConnection;

$formHelper = Loader::helper('form');
//$lastSearch = LintonPropertySearch::getLastSearchRequest();
?>
<section class="search">
    <div class="skinny-wrap">
        <div class="property-search">
            <h3>PROPERTY SEARCH</h3>
            <p>Use the filters below to search through our many listings to find the property that fits you.</p>
            <form id="propertySearch" method="get" action="<?php echo View::url('properties'); ?>" class="clearfix">
                <div class="clearfix">
                    <!-- Locations Trigger -->
                    <div class="dropdown">
                        <button onclick="LB.Search.toggleLocationFilter( event )" class="locations">Locations</button>
                    </div>
                    <!-- beds -->
                    <div class="dropdown">
                        <?php echo $formHelper->select('beds', array(''=>'BEDROOMS') + array_combine(range(1,10), range(1,10)), $lastSearch['beds'], array('class'=>'beds')); ?>
                    </div>

                    <!-- baths -->
                    <div class="dropdown">
                        <?php echo $formHelper->select('baths', array(''=>'BATHS') + array_combine(range(1,10), range(1,10)), $lastSearch['baths'], array('class'=>'baths', 'placeholder'=>'baths')); ?>
                    </div>

                    <div class="or">OR</div>

                    <div class="mls">
                        <?php echo $formHelper->text('mls_id', $lastSearch['mls_id'], array('placeholder'=>'Search By MLS #')); ?><button class="btn btn-red" type="submit">GO</button>
                    </div>
                </div>

                <div class="property-types clearfix">
                    <?php foreach(SparkConnection::getPropertyTypes() AS $key => $value){ ?>
                        <div class="type"><?php echo $formHelper->checkbox( "property_type[]", $key, in_array($key, (array)$lastSearch['property_type']) ) . ' ' . $value; ?></div>
                    <?php } ?>
                </div>

                <div class="pricerange clearfix">
                    <div class="dropdown">
                        <?php echo $formHelper->select('pricerange', array(''=>'PRICE RANGE') + array_combine(range(1,10), range(1,10)), $lastSearch['pricerange'], array('class'=>'pricerange')); ?>
                    </div>
                </div>

                <p class="big-match"><strong><span class="target-result-count">0</span> properties</strong></p>
                <p>There are <strong><span class="target-result-count"><?php echo $pagingHelper->resultCount; ?>0</span> properties</strong> matching your search criteria.</p>

                <div class="buttons">
                    <a class="btn btn-red" onclick="$('form#propertySearch').submit();">View Search Results <i class="icon-chevron-right icon-white"></i></a>
                    <a class="btn btn-white" onclick="LB.Search.clearFields(this, true);" data-within="#propertySearch">Clear All</a>
                </div>

                <div id="locationFilters" class="hidden">
                    <div class="clearfix">
                        <h5>LOCATIONS</h5>
                        <button onclick="LB.Search.toggleLocationFilter( event )" class="btn btn-white close">x</button>
                        <a class="btn btn-red" onclick="LB.Search.clearFields(this);" data-within="#locationFilters">Clear</a>
                    </div>
                    <ul class="outer">
                        <li class="heading">Jackson Hole, WY</li>
                        <ul class="inner">
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "1 - Teton Village", in_array("1 - Teton Village", (array) $lastSearch['mls_area_minor'])); ?> Teton Village</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "2 - Racquet Club/Teton Pines", in_array("2 - Racquet Club/Teton Pines", (array) $lastSearch['mls_area_minor'])); ?> Racquet Club/Teton Pines</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "3 - W Snake N of Wilson", in_array("3 - W Snake N of Wilson", (array) $lastSearch['mls_area_minor'])); ?> West Snake River North of Wilson</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "4 - W Snake S of Wilson", in_array("4 - W Snake S of Wilson", (array) $lastSearch['mls_area_minor'])); ?> West Snake River South of Wilson</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "5 - Skyline Ranch to Sagebrush Dr", in_array("5 - Skyline Ranch to Sagebrush Dr", (array) $lastSearch['mls_area_minor'])); ?> Skyline Ranch to Sagebrush Dr</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "6 - East Gros Ventre Butte", in_array("6 - East Gros Ventre Butte", (array) $lastSearch['mls_area_minor'])); ?> East Gros Ventre Butte</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "7 - N of Gros Ventre Jct", in_array("7 - N of Gros Ventre Jct", (array) $lastSearch['mls_area_minor'])); ?> North of Gros Ventre Jct</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "8 - Town of Jackson", in_array("8 - Town of Jackson", (array) $lastSearch['mls_area_minor'])); ?> Town of Jackson</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "9 - South of Jackson to Snake River Bridge", in_array("9 - South of Jackson to Snake River Bridge", (array) $lastSearch['mls_area_minor'])); ?> South of Jackson to Snake River Bridge</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "10 - South of Snake River Bridge to County Line", in_array("10 - South of Snake River Bridge to County Line", (array) $lastSearch['mls_area_minor'])); ?> South of Snake River Bridge to County Line</label></li>

                        </ul>
                        <li class="heading">Teton Valley, ID</li>
                        <ul class="inner">
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "12 - Alta, WY", in_array("12 - Alta, WY", (array) $lastSearch['mls_area_minor'])); ?> Alta, WY</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "17 - Driggs Area", in_array("17 - Driggs Area", (array) $lastSearch['mls_area_minor'])); ?> Driggs Area</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "19 - Tetonia Area", in_array("19 - Tetonia Area", (array) $lastSearch['mls_area_minor'])); ?> Tetonia Area</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "18 - West Side Teton Valley", in_array("18 - West Side Teton Valley", (array) $lastSearch['mls_area_minor'])); ?> West Side Teton Valley</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "16 - Victor Area", in_array("16 - Victor Area", (array) $lastSearch['mls_area_minor'])); ?> Victor Area</label></li>
                        </ul>
                        <li class="heading">Lincoln County, WY:</li>
                        <ul class="inner">
                            <li><label><?= $formHelper->checkbox('city[]', "Afton", in_array("Afton", (array) $lastSearch['city'])); ?> Afton</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Alpine", in_array("Alpine", (array) $lastSearch['city'])); ?> Alpine</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Bedford", in_array("Bedford", (array) $lastSearch['city'])); ?> Bedford</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Etna", in_array("Etna", (array) $lastSearch['city'])); ?> Etna</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Freedom", in_array("Freedom", (array) $lastSearch['city'])); ?> Freedom</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Grover", in_array("Grover", (array) $lastSearch['city'])); ?> Grover</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "11 - Star Valley/Lincoln County, WY", in_array("11 - Star Valley/Lincoln County, WY", (array) $lastSearch['mls_area_minor'])); ?> Star Valley</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Star Valley Ranch", in_array("Star Valley Ranch", (array) $lastSearch['city'])); ?> Star Valley Ranch</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Thayne", in_array("Thayne", (array) $lastSearch['city'])); ?> Thayne</label></li>
                        </ul>
                        <li class="heading">Other Wyoming:</li>
                        <ul class="inner">
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "13 - Dubois/Fremont County, WY", in_array("13 - Dubois/Fremont County, WY", (array) $lastSearch['mls_area_minor'])); ?> Dubois/Fremont County, WY</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "14 - N. Sublette County, WY", in_array("14 - N. Sublette County, WY", (array) $lastSearch['mls_area_minor'])); ?> North Sublette County, WY</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "14A - So. Sublette County, WY", in_array("14A - So. Sublette County, WY", (array) $lastSearch['mls_area_minor'])); ?> South Sublette County, WY</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Bondurant", in_array("Bondurant", (array) $lastSearch['city'])); ?> Bondurant</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Cody", in_array("Cody", (array) $lastSearch['city'])); ?> Cody</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Daniel", in_array("Daniel", (array) $lastSearch['city'])); ?> Daniel</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Dubois", in_array("Dubois", (array) $lastSearch['city'])); ?> Dubois</label></li>
                            <li><label><?= $formHelper->checkbox('city[]', "Pinedale", in_array("Pinedale", (array) $lastSearch['city'])); ?> Pinedale</label></li>
                            <li><label><?= $formHelper->checkbox('mls_area_minor[]', "15 - Other", in_array("15 - Other", (array) $lastSearch['mls_area_minor'])); ?> Other Wyoming</label></li>
                        </ul>
                    </ul>
                    <button onclick="LB.Search.toggleLocationFilter( event )" class="btn btn-white close">x</button>
                </div>

            </form>
        </div>
    </div>
</section>
