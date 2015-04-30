
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Regions'), t(''), false, false ); ?>
	<div id="clinicaWrap">
		<div class="ccm-pane-body">
            <?php Loader::element('editor_config');
            $formHelper = Loader::helper('form');
            $assetLibrary = Loader::helper('concrete/asset_library');
            ?>

            <form method="post" action="<?php echo $this->action('save', $regionObj->getID()); ?>">
                <h4>Add Or Update Region</h4>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Name</td>
                                <td>Parent Region</td>
                            </tr>
                            <tr>
                                <td style="width: 60%"><?php echo $formHelper->text('name', $regionObj->getName()); ?></td>
                                <td style="width: 40%">
                                    <?php echo $formHelper->select('parentRegion', Concrete\Package\Realtor\Src\Regions\Region::$parentRegions, $regionObj->getParentHandle()); ?>
                                </td>

                            </tr>
                            <tr>
                                <td>Search Query</td>
                                <td>Image</td>
                            </tr>
                            <tr>
                                <td style="width: 60%"><?php echo $formHelper->text('searchQuery', $regionObj->getSearchQuery()); ?></td>
                                <td style="width: 40%">
                                    <?php
                                    $al = Loader::helper('concrete/asset_library');
                                    $f = File::getByID((int)$regionObj->getImageID());
                                    echo $al->image('image', 'imageID', t('Select an image'), $f);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Description</td>
                            </tr>
                            <tr class="no-stripe">
                                <td colspan="2">
                                    <div style="background:#fff;">
                                        <?php Loader::element('editor_controls'); ?>
                                        <?php echo $formHelper->textarea('description', $regionObj->getDescription(), array('class' => 'ccm-advanced-editor')); ?>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="clearfix" style="padding-bottom:0;">
                    <button type="submit" class="btn primary pull-right">Save</button>
                    <a href="/dashboard/regions" class="btn btn-default pull-right" style="margin-right: 10px;">Cancel</a>
                </div>
            </form>

        </div>
		<div class="ccm-pane-footer"></div>
	</div>
	
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>