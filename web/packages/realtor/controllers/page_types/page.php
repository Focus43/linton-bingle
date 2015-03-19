<?php namespace Concrete\Package\Realtor\Controller\PageType {

    use FileSet;
    use Concrete\Package\Realtor\Controller\RealtorPageController;

    class Page extends RealtorPageController {

        protected $_includeThemeAssets = true;

        public function view(){
            parent::view();
//            $this->set('mastheadHelper', new \Concrete\Package\Realtor\Src\Helpers\Masthead($this->getPageObject()));
        }

    }

}