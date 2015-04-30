<?php namespace Concrete\Package\Realtor\Controller\SinglePage\Dashboard\Regions {

    use Concrete\Package\Realtor\Src\Regions\Region;
    use \Concrete\Core\Page\Controller\DashboardPageController;

	class Detail extends DashboardPageController {
	
	
		public function on_start(){
//            echo 'start';exit;
//			$this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'srk9'));
		}
	
	
		public function view() {
            // just redirecting to the list page
			$this->redirect('/dashboard/regions/regions');
		}
		
		
		public function add(){
			$this->set('regionObj', new Region);
		}
		
		
		public function edit( $id ){
//            echo 'edit';exit;
			$this->set('regionObj', Region::getByID($id));
		}
		
		
		public function save( $id = null ) {
			$personnelObj = Region::getByID($id);
			$personnelObj->setPropertiesFromArray($_POST);
			$personnelObj->save();
			$this->redirect('/dashboard/regions');
		}
	
	}
}