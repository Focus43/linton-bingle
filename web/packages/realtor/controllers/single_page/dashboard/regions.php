<?php namespace Concrete\Package\Realtor\Controller\SinglePage\Dashboard {

    use Concrete\Package\Realtor\Src\Regions\Region as Region;
    use Concrete\Package\Realtor\Src\Regions\RegionList as RegionList;
    use \Concrete\Core\Page\Controller\DashboardPageController;
    use Loader;

	class Regions extends DashboardPageController {

		public $helpers = array('form');

		public function on_start() {
//            echo 'search on start';exit;
		}


		public function view(){
			$searchInstance = 'region' . time();
			$this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'realtor'));
//			$this->addHeaderItem( '<meta id="srk9ToolsDir" value="'.SRK9_TOOLS_URL.'" />' );
			$this->addFooterItem('<script type="text/javascript">$(function() { ccm_setupAdvancedSearch(\''.$searchInstance.'\'); });</script>');
			$this->addFooterItem(Loader::helper('html')->javascript('dashboard/app.dashboard.js', 'realtor'));
			$this->set('listObject', $this->regionListObj());
			$this->set('listResults', $this->regionListObj()->getPage());
			$this->set('searchInstance', $searchInstance);
		}


		public function regionListObj(){
			if( $this->_regionListObj === null ){
				$this->_regionListObj = new RegionList();
				$this->applySearchFilters( $this->_regionListObj );
			}
			return $this->_regionListObj;
		}


		private function applySearchFilters( RegionList $listObj ){
			if( !empty($_REQUEST['numResults']) ){
				$listObj->setItemsPerPage( $_REQUEST['numResults'] );
			}
			
			if( !empty($_REQUEST['keywords']) ){
				$listObj->filterByKeywords( $_REQUEST['keywords'] );
			}

			
			return $listObj;
		}
	
	}
}