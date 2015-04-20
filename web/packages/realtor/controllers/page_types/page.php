<?php namespace Concrete\Package\Realtor\Controller\PageType {

    use FileSet,
        FileList;
    use Concrete\Package\Realtor\Controller\RealtorPageController;
    use Concrete\Package\Realtor\Controller as PackageController;

    class Page extends RealtorPageController {

        protected $_includeThemeAssets = true;

        public function view(){
            parent::view();
            $this->set('mastheadImages', $this->getMastheadImages());
        }

        protected function getMastheadImages () {
            return FileSet::getByName(PackageController::FILE_SET_MASTHEAD)->getFiles();
        }
    }
}