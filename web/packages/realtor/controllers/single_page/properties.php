<?php namespace Concrete\Package\Realtor\Controller\SinglePage {

    use Concrete\Package\Realtor\Src\PropertySearch\SparkSearch as SparkSearch;
    use Concrete\Package\Realtor\Src\PropertySearch\SparkProperty as SparkProperty;
    use Concrete\Package\Realtor\Controller\RealtorPageController;
    use Concrete\Package\Realtor\Src\Regions\RegionList as RegionList;
    use Concrete\Package\Realtor\Src\Regions\Region as Region;
    use FileSet;

	class Properties extends RealtorPageController {

        var $currentPage = 1,
            $totalPages,
            $resultBottom,
            $pageSize,
            $totalResults;
		
		public function view() {
            $this->_includeThemeAssets = true;
            parent::view();
            $this->set('pageClass', 'pg-properties');
            // first check if area page
            if ( $_REQUEST && $_REQUEST["area_page"] ) {
                $this->set("area", $_REQUEST["area_page"]);
                $this->set("areaSubs", $this->regionListObj($_REQUEST["area_page"]));
                $this->set('mastheadImages', FileSet::getByName($_REQUEST["area_page"])->getFiles());
                $areaName = Region::$parentRegions[$_REQUEST["area_page"]];
                $this->set("areaName", $areaName);

            }
			// search
			$search = new SparkSearch( $_REQUEST, true );
            $search->setSearchParams( array('_limit'	=> 5) );
			$searchResults = $search->get();
			// pass property list results
			$this->set('searchResults', $searchResults->getResults());
			// set up the paging stuff
            $this->pageSize = $searchResults->getpageSize();
            $this->currentPage = $searchResults->getCurrentPage();
            $this->totalPages = $searchResults->getTotalPages();
            $this->totalResults = $searchResults->getResultCount();
            // pass the paging stuff
			$this->set('totalPages', $this->totalPages);
            $this->set('totalResults', $this->totalResults);
            $this->set('currentPage', $this->currentPage);
            $this->set('paginationResultFrom', $this->getResultsFrom());
            $this->set('paginationResultTo', $this->getResultsTo());
            $this->set('previousUrl', $this->prevPageURL());
            $this->set('nextUrl', $this->nextPageURL());
		}

		public function id( $id = null ) {
            $this->_includeThemeAssets = true;
            parent::view();
            $this->set('pageClass', 'pg-properties');
			$this->loadProperty($id );
		}

        public function regionListObj( $parent ){
            if( $this->_regionListObj === null ){
                $this->_regionListObj = new RegionList();
                $this->_regionListObj->filterByParent( $parent );
            }
            return $this->_regionListObj->get();
        }

        public function print_friendly($id = null) {
            $propertyObj = $this->loadProperty($id);
            $firstPhotoUrl = $propertyObj->getFirstPhotoURL(640);
            $this->set('firstPhotoUrl', empty($firstPhotoUrl) ? null : $firstPhotoUrl);
            $this->set('latitude', $propertyObj->getLatitude());
            $this->set('longitude', $propertyObj->getLongitude());
            $area = $propertyObj->getMLSAreaMinor();
            $this->set('area', 'Other' == $area ? null : $area);
            $price = (int) $propertyObj->getListPrice();// number_format((int) $sparkProperty->getListPrice(), 2)
            $this->set('price', $price > 0 ? '$' . number_format($price) : null);
            $this->set('beds', $propertyObj->getBedsTotal());
            $this->set('fullBaths', $propertyObj->getBathsFull());
            $this->set('halfBaths', $propertyObj->getBathsHalf());
            $squareFeet = (int) $propertyObj->getBuildingAreaTotal();
            $this->set('squareFeet', $squareFeet > 0 ? number_format($squareFeet) : null);
            $mls = $propertyObj->getListingId();
            $this->set('mls', empty($mld) ? null : $mls);
            $details = $propertyObj->getPublicRemarks();
            $this->set('details', empty($details) ? null : nl2br($details));

            $this->render('print');
        }

        /**
         * @return string
         */
        public function prevPageURL(){
            $args = $this->currentPage > 1 ?
                array('_paging' => ($this->currentPage - 1))
                : array();
            return $this->composeLink( $args );
        }

        /**
         * @return string
         */
        public function getSortByString(){
            $sortby = urldecode( $_REQUEST['sortby'] );
            switch( true ){
                case $sortby == 'price_desc':
                    return 'Price (High to Low)';
                    break;
                case $sortby == 'price_asc':
                    return 'Price (Low To High)';
                    break;
                case $sortby == 'beds_desc':
                    return 'Beds (High to Low)';
                    break;
                case $sortby == 'beds_asc':
                    return 'Beds (Low To High)';
                    break;
                case $sortby == 'baths_desc':
                    return 'Baths (High to Low)';
                    break;
                case $sortby == 'baths_asc':
                    return 'Baths (Low To High)';
                    break;
                default:
                    return '';
            }
        }

        /**
         * @return string
         */
        public function linkto( $path, $queryParams = array() ){
            return \View::url( $path ) . '?' . http_build_query(array_merge($_REQUEST, $queryParams));
        }

        /**
         * @return string
         */
        public function nextPageURL(){
            $args = $this->currentPage < $this->totalPages ?
                array('_paging' => ($this->currentPage + 1))
                : array();
            return $this->composeLink( $args );
        }

        private function getResultsFrom(){
            if( $this->resultBottom == null ){
                $this->resultBottom = 1;
                if( $this->totalPages > 1 ){
                    if( $this->currentPage > 1 ){
                        $this->resultBottom = ($this->currentPage * $this->pageSize) - $this->pageSize + 1;
                    }
                }
            }
            return (int) $this->resultBottom;
        }


        private function getResultsTo(){
            $resultUpper = $this->resultBottom + $this->pageSize - 1;
            if( $this->currentPage == 1 ){
                $resultUpper = $this->currentPage * $this->pageSize;
            }
            if( $this->currentPage == $this->totalPages ){
                $this->resultBottom = $this->totalResults;
            }
            return (int) $resultUpper;
        }

        private function loadProperty($id) {
            $propertyObj = SparkProperty::getByID($id);
            $this->set('propertyObj', $propertyObj);
            return $propertyObj;
        }

        /**
         * Pass in an array of extra arguments that'll be used to add to the query string
         * @return string
         */
        private function composeLink( array $args = array() ){
            $query = array_merge($_REQUEST, $args);
            return ( empty($query) ) ? \View::url( 'properties' ) : \View::url( 'properties' ) . '?' . http_build_query( $query );
        }

	}
}
