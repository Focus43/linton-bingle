<?php $columns = Concrete\Package\Realtor\Src\Regions\RegionColumnSet::getCurrent();
	$imageHelper = Loader::helper('image');
?>
<style>
    #regionSearchTable.group-left tbody tr td, #regionSearchTable.group-left th {
        padding-left: 15px !important;padding-bottom: 5px;padding-right: 15px;padding-top: 5px;
    }
    thead { border-bottom: 1px solid #ccc; }
    .ccm-pane-options-permanent-search .search { width: 590px;float: left;padding-bottom: 25px; }
    .ccm-pane-options-permanent-search .search div { width: 50%;float: left;padding-right: 50px; }
    .ccm-pane-options-permanent-search .search div #keywords { width: 170px;float: left;padding-right: 5px; }
    .ccm-pane-options-permanent-search .search div button { float: right; }
    select#actionMenu { margin: 20px 0; }
</style>

<div id="ccm-<?php echo $searchInstance; ?>-search-results">
	<div class="ccm-pane-body">
		
		<table id="regionSearchTable" border="0" cellspacing="0" cellpadding="0" class="group-left ccm-results-list">
			<thead>
				<tr>
					<th><input id="checkAllBoxes" type="checkbox" /></th>
					<th>Region Image</th>
					<?php foreach($columns->getColumns() as $col) { ?>
		                <th><?php echo $col->getColumnName() ?></th>
	                <?php } ?>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($listResults AS $region): ?>
					<tr>
						<td><input type="checkbox" name="id[]" value="<?php echo $region->getID(); ?>" /></td>
						<td>
							<?php if($region->getPictureFileObj() && $region->getPictureFileObj()->getFileID() >= 1): ?>
								<img class="thumbnail" src="<?php echo $imageHelper->getThumbnail($region->getPictureFileObj(), 75, 65, true)->src; ?>" />
							<?php else: ?>
								<span class="thumbnail" style="display:block;width:75px;height:55px;background:#f1f1f1;font-size:11px;text-align:center;padding-top:10px;">None</span>
							<?php endif; ?>
						</td>
						<?php foreach($columns->getColumns() AS $colObj){ ?>
							<td class="<?php echo strtolower($colObj->getColumnName()); ?>"><?php echo $colObj->getColumnValue($region); ?></td>
						<?php } ?>
                        <td><button class="btn btn-danger delete" data-id="<?php echo $region->getID(); ?>">Delete</button></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<!-- # of results -->
		<?php $listObject->displaySummary(); ?>
	</div>
	
	<!-- paging stuff -->
<!--	<div class="ccm-pane-footer">-->
<!--		--><?php //$listObject->displayPagingV2((SRK_TOOLS_URL . 'dashboard/personnel/search_results'), array()) ?>
<!--	</div>-->
</div>
