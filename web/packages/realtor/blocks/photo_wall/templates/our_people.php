<?php
$textHelper = Loader::helper('text');
$ak = FileAttributeKey::getByHandle(Concrete\Package\Realtor\Controller::FILE_ATTR_INVOLVEMENT_LEVEL);
$ctrl = $ak->getController();
$opts = $ctrl->getOptions();
$userInvolvementLevels = array();
foreach($opts AS $optObj){ /** $optObj \Concrete\Attribute\Select\Option */
    array_push($userInvolvementLevels, $optObj->getSelectAttributeOptionValue());
}
?>

<div isotope>
    <ul class="list-inline text-center" isotope-filters>
        <li><a class="active" data-filter="*">Show All</a></li>
        <?php
            foreach($userInvolvementLevels AS $levelString){
                echo '<li><a data-filter="['.$textHelper->handle($levelString).']">'.$levelString.'</a></li>' . "\n";
            }
        ?>
    </ul>
    <div class="grid-wrapper">
        <div isotope-grid>
            <?php
                foreach((array)$fileListResults AS $fileObj){
                    Loader::packageElement('partials/person_grid', \Concrete\Package\Realtor\Controller::PACKAGE_HANDLE, array(
                        'fileObj'    => $fileObj,
                        'textHelper' => $textHelper
                    ));
                }
            ?>
        </div>
    </div>
</div>