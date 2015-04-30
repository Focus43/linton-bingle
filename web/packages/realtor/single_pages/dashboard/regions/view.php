<?php //Loader::packageElement('flash_message', 'srk9', array('flash' => $flash)); ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Dog Search'), t('View dogs for sale.'), false, false ); ?>
	
	<div id="regionWrap">
		<div class="ccm-pane-options">
			<form method="get" id="ccm-<?php echo $searchInstance; ?>-advanced-search" action="<?php // echo SRK9_TOOLS_URL . 'dashboard/dogs/search_results'; ?>">
				<!-- default search options -->
				<div class="ccm-pane-options-permanent-search">
					<div class="pull-left">
						<div class="span2">
							<?php echo $form->text('keywords', $_REQUEST['keywords'], array('class' => 'input-block-level helpTooltip', 'placeholder' => t('Keyword Search'), 'title' => 'Name')); ?>
						</div>
						<div class="span2">
							<?php echo $form->select('numResults', array('10' => 'Show 10 (Default)', '25' => 'Show 25', '50' => 'Show 50', '100' => 'Show 100', '500' => 'Show 500'), $_REQUEST['numResults'], array('class' => 'input-block-level helpTooltip', 'title' => '# of results to display')); ?>
						</div>
						<div class="span1">
							<button type="submit" class="btn info pull-right">Search</button>
							<img src="<?php echo ASSETS_URL_IMAGES?>/loader_intelligent_search.gif" width="43" height="11" class="ccm-search-loading" id="ccm-locales-search-loading" />
						</div>
					</div>
					<div class="pull-right">
						<a class="btn success" href="<?php echo View::url('dashboard/regions/detail/add'); ?>">Add Region</a>
					</div>
				</div>
			</form>
		</div>
		
		<?php Loader::packageElement('dashboard/regions/search_results', 'realtor', array(
			'searchInstance'	=> $searchInstance,
			'listObject'		=> $listObject,
			'listResults'		=> $listResults,
			'pagination'		=> $pagination
		)); ?>
	</div>
	
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>