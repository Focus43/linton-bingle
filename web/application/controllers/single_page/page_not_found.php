<?php
namespace Application\Controller\SinglePage;
use \Concrete\Package\Realtor\Controller AS PackageController;
class PageNotFound extends \Concrete\Controller\SinglePage\PageNotFound {

    public function view() {
        $this->set('pkgConfig', PackageController::getPackageConfigObj());
    }
}
