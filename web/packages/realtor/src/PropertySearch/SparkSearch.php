<?php namespace Concrete\Package\Realtor\Src\PropertySearch {

    class SparkSearch {

        protected $_filterQuery     = "MlsStatus Eq 'A' And StateOrProvince Eq 'WY'",
            $_apiMethod			    = 'getListings',
            $_customSearchParams 	= array(),
            $_params;


        public function __construct( array $request = array(), $cacheRequest = false ) {
            $this->_request = $request;
//            if( $cacheRequest && !empty($this->_request) ){
//                Cache::set( __CLASS__, session_id(), $this->_request );
//            }
        }

        public function get() {
            $this->setupFilterQuery();
            $this->setSearchParams( $this->apiSearchParams() );

            // are the results already cached?
//            $cached = Cache::get( __CLASS__, $this->getChecksum() );
//            if( $cached instanceof SparkSearchResults ){
//                return $cached;
//            }

            // run the query against the API
            $apiResults = call_user_func_array(array( SparkConnection::sparkApi(), $this->_apiMethod), array(
                $this->searchParams()
            ));

            // convert results from array to SparkProperty objects
            $sparkProperties = $this->apiResultsToSparkPropertyObjects( $apiResults );

            // create a new SparkSearchResults instance
//            $searchResult = new SparkSearchResults( $sparkProperties, SparkConnection::sparkApi() );

            // cache the results
//            Cache::set( __CLASS__, $this->getChecksum(), $searchResult, $this->getCacheLifetime() );

//            return $searchResult;
            return $sparkProperties;

//            return parent::get();
        }

        /**
         * Set the query that should be run against the api (eg. getListings, getMyListings)
         * @param string $method
         */
        public function setApiMethod( $method ){
            $this->_apiMethod = $method;
        }


        /**
         * Pass custom parameters
         * @param array $params
         */
        public function setSearchParams( array $params = array() ){
            $this->_customSearchParams = array_merge( $this->_customSearchParams, $params );
        }

        /**
         * @return string
         */
        public static function expression( $field, $comparison, $value ) {
            $sub = is_numeric($value) ? "%s %s %s" : "%s %s '%s'";
            return t($sub, $field, $comparison, $value);
        }

        /**
         * Compile the filter string for the _filter api search parameter.
         * @return void
         */
        protected function setupFilterQuery() {
            // min price
            if( isset($this->_request['priceMin']) && $this->_request['priceMin'] > SparkConnection::getMinPrice() ){
                $expression = self::expression('ListPrice', 'Ge', number_format($this->_request['priceMin'], 2, '.', '') );
                $this->applyFilter( $expression );
            }

            // max price
            if( isset($this->_request['priceMax']) && $this->_request['priceMax'] < SparkConnection::getMaxPrice() ){
                $expression = self::expression('ListPrice', 'Le', number_format($this->_request['priceMax'], 2, '.', '') );
                $this->applyFilter( $expression );
            }

            // beds
            if( $this->_request['beds'] >= 1 ){
                $expression = self::expression('BedsTotal', 'Ge', (int) $this->_request['beds']);
                $this->applyFilter( $expression );
            }

            // baths
            if( $this->_request['baths'] >= 1 ){
                $expression = self::expression('BathsTotal', 'Ge', number_format($this->_request['baths'], 2, '.', '') );
                $this->applyFilter( $expression );
            }

            // property types subquery
            if( !empty($this->_request['property_type']) ){
                $propertyTypeQueries = array_map(function( $type ){
                    return self::expression('PropertyType', 'Eq', $type);
                }, (array) $this->_request['property_type']);
                $expression = join(' Or ', $propertyTypeQueries);
                $this->applyFilter( $expression, 'And', '(%s)' );
            }

            // cities and areas subquery
            if( !empty($this->_request['city']) || !empty($this->_request['mls_area_minor'])){
                $cityQueries = array();
                if( !empty($this->_request['city'])) {
                    $cityQueries = array_map(function( $city ){
                        return self::expression('City', 'Eq', $city);
                    }, (array) $this->_request['city']);
                }
                $areaQueries = array();
                if (!empty($this->_request['mls_area_minor'])) {
                    $areaQueries = array_map(function ($area) {
                        return self::expression('MLSAreaMinor', 'Eq', $area);
                    }, (array) $this->_request['mls_area_minor']);
                }
                $expression = join(' Or ', array_merge($areaQueries, $cityQueries));
                $this->applyFilter( $expression, 'And', '(%s)' );
            }

            // search by mls id
            if( !empty($this->_request['mls_id']) ){
                $expression = self::expression('ListingId', 'Eq', $this->_request['mls_id']);
                $this->applyFilter($expression);
            }
        }

        /**
         * Compile the sorting string for the _orderby api search parameter
         * @return string
         */
        protected function getOrderByQuery() {
            $sort = '-ListPrice';
            if( isset($this->_request['sortby']) ){
                switch( true ){
                    case $this->_request['sortby'] == 'price_desc':
                        $sort = '-ListPrice';
                        break;
                    case $this->_request['sortby'] == 'price_asc':
                        $sort = '+ListPrice';
                        break;
                    case $this->_request['sortby'] == 'beds_desc':
                        $sort = '-BedsTotal';
                        break;
                    case $this->_request['sortby'] == 'beds_asc':
                        $sort = '+BedsTotal';
                        break;
                    case $this->_request['sortby'] == 'baths_desc':
                        $sort = '-BathsTotal';
                        break;
                    case $this->_request['sortby'] == 'baths_asc':
                        $sort = '+BathsTotal';
                        break;
                }
            }

            return $sort;
        }

        /**
         * Compile the parameters for the request to the API, based off
         * of the request from the user
         */
        protected function apiSearchParams(){
            $params = array(
                '_page' => $this->pagingLocation() // set which page to get
            );

            // set how to order the results
            $order = $this->getOrderByQuery();
            if( $order != '' ){
                $params['_orderby'] = $order;
            }

            return $params;
        }

        /**
         * Return which page to get for the _page api search parameters
         * @return int
         */
        protected function pagingLocation(){
            return isset($this->_request['_paging']) ? (int) $this->_request['_paging'] : 1;
        }

        /**
         * This method will add a string conditional to the $filterQuery property
         * @param string $joiner  : Use 'And' or 'Or'
         * @param string $wrapper
         * @return void
         */
        protected function applyFilter( $expression, $joiner = 'And', $wrapper = '%s' ) {
            $assemble = " {$joiner} {$wrapper}";
            $this->_filterQuery .= t( $assemble, $expression );
        }

        /**
         * Get a list of $param options to pass the Spark api
         * @return array
         */
        private function searchParams() {
            if( $this->_params == null ){
                $defaults = array(
                    '_pagination'	=> 1,
                    '_limit'		=> 10,
                    '_page'			=> 1,
                    '_filter'		=> $this->_filterQuery,
                    '_expand'		=> 'Photos'
                );

                $this->_params = empty($this->_customSearchParams) ? $defaults : array_merge($defaults, $this->_customSearchParams);
            }

            return $this->_params;
        }

        /**
         * Turn the results from the API from an array into an array of
         * SparkProperty objects
         * @param array $apiResults
         * @return array
         */
        private function apiResultsToSparkPropertyObjects( array $apiResults = array() ){
            $collection = array();
            foreach( $apiResults AS $prop ){
                $listingData		= $prop['StandardFields'];
                $listingData['Id']	= $prop['Id'];
                $collection[]		= new SparkProperty( $listingData, true );
            }
            return $collection;
        }

    }
}

//        public function get() {
//            // are the results already cached?
//            $cached = Cache::get( __CLASS__, $this->getChecksum() );
//            if( $cached instanceof SparkSearchResults ){
//                return $cached;
//            }
//
//            // run the query against the API
//            $apiResults = call_user_func_array(array( $this->sparkApi(), $this->_apiMethod), array(
//                $this->searchParams()
//            ));
//
//            // convert results from array to SparkProperty objects
//            $sparkProperties = $this->apiResultsToSparkPropertyObjects( $apiResults );
//
//            // create a new SparkSearchResults instance
//            $searchResult = new SparkSearchResults( $sparkProperties, $this->sparkApi() );
//
//            // cache the results
//            Cache::set( __CLASS__, $this->getChecksum(), $searchResult, $this->getCacheLifetime() );
//
//            return $searchResult;
//        }