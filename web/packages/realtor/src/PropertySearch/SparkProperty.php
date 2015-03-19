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

        // TODO: move to parent?
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
                $request = SparkConnection::sparkApi()->getListing($id, array('_expand' => 'Photos, Videos'));

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


        public function getPropertyID() {
            return $this->getId();
        }


        /**
         * @return string
         */
        public function getPropertyName() {
            return "{$this->StreetNumber} {$this->StreetName} {$this->StreetSuffix} {$this->City} {$this->StateOrProvince}";
        }


        /**
         * @return string
         */
        public function getPropertyType() {
            $types = SparkData::getPropertyTypes();
            return $types[ $this->PropertyType ];
        }

//        public function getMLSAreaMinor() {
//            $area = $this->__call('getMLSAreaMinor');
//            $areaWithoutLeadingNum = preg_replace("/^(?:\s*[0-9]+\s)/", '', $area);
//            return ltrim($areaWithoutLeadingNum, ' -');
//        }


        /**
         * Get the URL to the first photo in the set of photo results. Defaults
         * to the photo size @ 300, other options are: Thumb, 640, 800, 1024, 1280, Large
         * @return string
         */
        public function getFirstPhotoURL( $size = "300" ){
            $pics = $this->getPhotos();
            return $pics[0]["Uri{$size}"];
        }

    }
}