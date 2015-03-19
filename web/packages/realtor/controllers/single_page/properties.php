<?php namespace Concrete\Package\Realtor\Controller\SinglePage {

    use Concrete\Package\Realtor\Src\PropertySearch\SparkSearch as SparkSearch;
    use Concrete\Package\Realtor\Src\PropertySearch\SparkProperty as SparkProperty;
    use Concrete\Package\Realtor\Controller\RealtorPageController;

	class Properties extends RealtorPageController {
		
		public function view() {
			// instaniate search
			$search = new SparkSearch( $_REQUEST, true );
			$searchResults = $search->get();
			// pass property list results
			$this->set('searchResults', $searchResults);
			// pass the paging helper
//			$this->set('pagingHelper', $searchResults->paging());
		}
		
		
		public function id( $id = null ) {
			$this->loadProperty($id );
		}

        public function print_friendly($id = null) {
//            $propertyObj = $this->loadProperty($id);
//            $firstPhotoUrl = $propertyObj->getFirstPhotoURL(640);
//            $this->set('firstPhotoUrl', empty($firstPhotoUrl) ? null : $firstPhotoUrl);
//            $this->set('latitude', $propertyObj->getLatitude());
//            $this->set('longitude', $propertyObj->getLongitude());
//            $area = $propertyObj->getMLSAreaMinor();
//            $this->set('area', 'Other' == $area ? null : $area);
//            $price = (int) $propertyObj->getListPrice();// number_format((int) $sparkProperty->getListPrice(), 2)
//            $this->set('price', $price > 0 ? '$' . number_format($price) : null);
//            $this->set('beds', $propertyObj->getBedsTotal());
//            $this->set('fullBaths', $propertyObj->getBathsFull());
//            $this->set('halfBaths', $propertyObj->getBathsHalf());
//            $squareFeet = (int) $propertyObj->getBuildingAreaTotal();
//            $this->set('squareFeet', $squareFeet > 0 ? number_format($squareFeet) : null);
//            $mls = $propertyObj->getListingId();
//            $this->set('mls', empty($mld) ? null : $mls);
//            $details = $propertyObj->getPublicRemarks();
//            $this->set('details', empty($details) ? null : nl2br($details));
//
//            $this->render('print');
        }

        private function loadProperty($id) {
            $propertyObj = SparkProperty::getByID($id);
            $this->set('propertyObj', $propertyObj);
            return $propertyObj;
        }
		
	}
}
