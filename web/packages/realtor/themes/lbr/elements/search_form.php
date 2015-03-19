<?php

use Concrete\Package\Realtor\Src\PropertySearch\SparkConnection as SparkConnection;

$formHelper = Loader::helper('form');
//$lastSearch = LintonPropertySearch::getLastSearchRequest();
?>

<div id="searchFields" class="opaque-border">
    <div class="opaque-inner clearfix">
        <div class="textured" style="float:left;width:700px;margin-right:5px;">

            <form method="get" action="<?php echo View::url('properties'); ?>" class="clearfix">
                <a class="btn btn-mini btn-inverse" style="float:right;" onclick="LINTON.clearFields(this, true);" data-within="#filters">Clear All</a>
                <div class="form-inline" style="float:left;">
                    <span class="help-inline search">Search &nbsp;</span>
                    <div class="form-inline input-append">
                        <?php echo $formHelper->text('mls_id', $lastSearch['mls_id'], array('class'=>'span3','placeholder'=>'Search By MLS #')); ?><button class="btn linton-blue" type="submit">Find It &nbsp;<i class="icon-chevron-right icon-white"></i></button>
                    </div>
                </div>
            </form>

            <form id="filters" method="get" action="<?php echo View::url('properties'); ?>" class="clearfix">
                <!-- property types -->
                <div class="property-types form-inline">
                    <?php foreach(SparkConnection::getPropertyTypes() AS $key => $value){ ?>
                        <label class="checkbox">
                            <?php echo $formHelper->checkbox( "property_type[]", $key, in_array($key, (array)$lastSearch['property_type']) ) . ' ' . $value; ?>
                        </label>
                    <?php } ?>
                </div>

                <div class="clearfix">
                    <!-- price -->
                    <div class="price-box">
                        <table>
                            <tr>
                                <td class="text-label">Price Range:</td>
                                <td>
                                    <input id="priceMinDisplay" type="text" value="" class="unclearable" />
                                    <input id="priceMin" type="hidden" name="priceMin" class="unclearable" value="<?php echo $lastSearch['priceMin'] ? $lastSearch['priceMin'] : '25000'; ?>" data-abs-min="25000" />
                                </td>
                                <td>
                                    <input id="priceMaxDisplay" type="text" value="" class="unclearable" />
                                    <input id="priceMax" type="hidden" name="priceMax" class="unclearable" value="<?php echo $lastSearch['priceMax'] ? $lastSearch['priceMax'] : '35000000'; ?>" data-abs-max="35000000" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">
                                    <div id="price-slider"></div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- beds -->
                    <div style="float:left;margin-top:4px;margin-right:10px;">
                        <strong style="display:block;">Beds</strong>
                        <?php
                        echo $formHelper->select('beds', array(''=>'') + array_combine(range(1,10), range(1,10)), $lastSearch['beds'], array('style'=>'margin:0;padding:2px;height:auto;width:48px;'));
                        ?>
                    </div>

                    <!-- baths -->
                    <div style="float:left;margin-top:4px;margin-right:10px;">
                        <strong style="display:block;">Baths</strong>
                        <?php
                        echo $formHelper->select('baths', array(''=>'') + array_combine(range(1,10), range(1,10)), $lastSearch['baths'], array('style'=>'margin:0;padding:2px;height:auto;width:48px;'));
                        ?>
                    </div>

                    <!-- cities -->
                    <div style="float:left;margin-top:6px;margin-right:0;">
                        <div class="opaque-border toggleable off" data-toggle-group="searchbox" style="position:relative;">
                            <div class="opaque-inner toggleable">
                                <strong><i class="icon-plus"></i> Select Locations</strong>
                            </div>
                            <div class="opaque-border sub" style="width:545px;">
                                <div class="opaque-inner">
                                    <div id="locationFilters" class="textured clearfix">
                                        <p><strong>Property Locations</strong> &nbsp;&nbsp;&nbsp; <a class="btn btn-mini" onclick="LINTON.clearFields(this);" data-within="#locationFilters">Clear All</a></p>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <input type="hidden" name="search" value="1" />
            </form>
        </div>

        <div class="textured" style="float:left;width:212px;">
            <a class="btn btn-large" style="width:181px;margin-bottom:10px;"><span class="target-result-count"><?php echo $pagingHelper->resultCount; ?></span> Matches</a>
            <p>There are <strong><span class="target-result-count"><?php echo $pagingHelper->resultCount; ?></span> properties</strong> matching your search criteria.</p>
            <a class="btn linton-blue" onclick="$('form#filters').submit();">View Search Results <i class="icon-chevron-right icon-white"></i></a>
        </div>

    </div>
</div>