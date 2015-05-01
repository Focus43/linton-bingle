<?php namespace Concrete\Package\Realtor\Src\PropertySearch {

    class SparkProperty {

        /**
         * Create a new SparkProperty object.
         * @param array $properties
         * @param bool	$setCache
         */
        public function __construct( $properties = array(), $setCache = false ){
            $this->setPropertiesFromArray($properties);
            // cache it?
//            if( $setCache === true ){
//                Cache::set( __CLASS__, $this->Id, $this, (Config::get('FULL_PAGE_CACHE_LIFETIME_CUSTOM') * 60) );
//            }
        }

        public function setPropertiesFromArray($arr) {
            foreach($arr as $key => $prop) {
                $this->{$key} = $prop;
            }
        }

        /**
         * *NOT* the mlsID, but the propertyID from the SparkAPI
         */
        public static function getByID( $id, $bustCache = false ){
            try {
                // if we can load from the cache, do it
//                if( !$bustCache ){
//                    $propertyObj = Cache::get( __CLASS__, $id );
//                    if( is_object($propertyObj) ){ return $propertyObj; }
//                }

                // if we get here, call it from the API
                $request = SparkConnection::sparkApi()->getListing($id, array('_expand' => 'Photos, Videos', '_select' => ''));

                // an error occurred; throw exception
                if( SparkConnection::sparkApi()->GetErrors() ){
                    throw new Exception('Unable to find the specified property.');
                }

                // format the data, for use when creating new object
                $listingData 		= $request['StandardFields'];
                $listingData['Id']	= $request['Id'];

                // instantiate self with properties, and set true to force caching
                $self = new self( $listingData, true );

                // return it
                return $self;

            }catch(Exception $e){
                throw $e;
            }
        }

        public static function getByMls($mlsId)
        {
            $request = self::sparkApi()->GetListings(array('_filter' => "ListingId Eq '$mlsId'"));
            if(!count($request)) {
                return null;
            }
            $listingData = $request[0]['StandardFields'];
            $listingData['Id'] = $request[0]['Id'];

            $self = new self($listingData);
            return $self;
        }

        /**
         * @return string
         */
        public function getPropertyID() {
            return $this->Id;
        }
        /**
         * @return string
         */
        public function getListOfficeName() {
            return $this->ListOfficeName;
        }
        /**
         * @return string
         */
        public function getListPrice() {
            return number_format( $this->ListPrice );
        }
        /**
         * @return string
         */
        public function getListPricePlain() {
            return $this->ListPrice;
        }
        /**
         * @return string
         */
        public function getStateOrProvince() {
            return $this->StateOrProvince;
        }
        /**
         * @return string
         */
        public function getBuildingAreaTotal() {
            return number_format( (int) $this->BuildingAreaTotal, 2 );
        }
        /**
         * @return string
         */
        public function getPropertyName( $shouldBreak = false ) {
            if ( $shouldBreak ) {
                return "{$this->StreetNumber} {$this->StreetName} {$this->StreetSuffix} <br>{$this->City}, {$this->StateOrProvince}";
            } else {
                return "{$this->StreetNumber} {$this->StreetName} {$this->StreetSuffix}, {$this->City}, {$this->StateOrProvince}";
            }
        }
        /**
         * @return string
         */
        public function getDescription() {
            return $this->PublicRemarks;
        }
        /**
         * @return string
         */
        public function getMlsNumber() {
            return $this->ListingId;
        }
        /**
         * @return string
         */
        public function getCity() {
            return $this->City;
        }
        /**
         * @return string
         */
        public function getBedsNumber() {
            return $this->BedsTotal && $this->BedsTotal != "********" ? $this->BedsTotal : "N/A";
        }
        /**
         * @return string
         */
        public function getBathsNumber() {
            $totalBath = 0;
            if ( $this->BathsFull && $this->BathsFull != "********" ) {
                $totalBath += $this->BathsFull;
            }
            if ( $this->BathsHalf && $this->BathsHalf != "********" ) {
                $totalBath += $this->BathsHalf;
            }

            return $totalBath > 0 ? $totalBath : "N/A";
        }
        /**
         * @return string
         */
        public function getBathsHalf() {
            return $this->BathsHalf && $this->BathsHalf != "********" ? $this->BathsHalf : "N/A";
        }
        /**
         * @return string
         */
        public function getBathsFull() {
            return $this->BathsFull && $this->BathsFull != "********" ? $this->BathsFull : "N/A";
        }
        /**
         * @return array
         */
        public function getPhotos() {
            return $this->Photos;
        }
        /**
         * @return string
         */
        public function getPropertyType() {
            $types = SparkConnection::getPropertyTypes();
            return $types[ $this->PropertyType ];
        }

        public function getMLSAreaMinor() {
            $area = $this->MLSAreaMinor;
            $areaWithoutLeadingNum = preg_replace("/^(?:\s*[0-9]+\s)/", '', $area);
            return ltrim($areaWithoutLeadingNum, ' -');
        }

        public function getLongitude() {
            return $this->Longitude;
        }
        public function getLatitude() {
            return $this->Latitude;
        }
        public function getVideos() {
            $videos = array();
            if ( count($this->Videos) > 0 ) {
                foreach ( $this->Videos as $v ) {
                    array_push($videos, $v["ObjectHtml"]);
                }
            }
            return $videos;
        }


        /**
         * Get the URL to the first photo in the set of photo results. Defaults
         * to the photo size @ 300, other options are: Thumb, 640, 800, 1024, 1280, 1600, 2048, Large
         * @return string
         */
        public function getFirstPhotoURL( $size = "300" ){
            $pics = $this->getPhotos();
            return $pics[0]["Uri{$size}"];
        }

        public function getPhotosForFeaturedProperty( $size = "300" ) {
            $urls = array();
            $pics = $this->getPhotos();
            array_shift($pics);
            foreach ( $pics as $p ) {
                $urls[] = $p["Uri{$size}"];
            }

            return $urls;
        }

    }
}