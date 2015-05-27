<?php namespace Concrete\Package\Realtor\Controller\Tools {

    use Controller;
    use Concrete\Package\Realtor\Src\PropertySearch\SparkSearch as SparkSearch;
    use  Concrete\Package\Realtor\Src\Cache\RedisCache;

    class Search extends Controller {

        public function resultsCount ( ) {
            $respObj = new \stdClass;
            $respObj->code = 1;
            $respObj->resultCount = 0;

            $search = new SparkSearch( $_REQUEST, true );
            $searchResults = $search->getNumberOfResults();
            $respObj->resultCount = $searchResults;

            echo json_encode($respObj);
            exit;
        }

        public function featuredProperties () {
            $respObj = new \stdClass;
            $respObj->code = 1;
            $respObj->properties = array();

            $search = new SparkSearch();
            $search->setApiMethod('getMyListings');
            $search->setSearchParams(array('_limit' => 25, '_select' => '', '_expand' => 'Photos', '_pagination'	=> 0));

            // are the results already cached?
            $cachedHash = RedisCache::cache()->get(__CLASS__ . "featured_properties");
            if ( $cachedHash ) { $cached = RedisCache::cache()->_unserialize($cachedHash); }
            if( $cached ){
                $results = $cached;
            } else {
                $results = $search->get()->getResults();
                // cache it
                $toCache = RedisCache::cache()->_serialize($results);
                RedisCache::cache()->set(__CLASS__ . "featured_properties", $toCache, 24*60);
            }
            if ( $results ) {
                foreach ( $results as $r ) {
                    $property = new \stdClass;
                    $property->mainImage = $r->getFirstPhotoURL("800");
                    $property->name = $r->getPropertyName();
                    $property->description = $r->getDescription();
                    $property->id = $r->getPropertyID();

                    // photos divided in two arrays
                    $photos = $r->getPhotosForFeaturedProperty("640");
                    foreach ( $photos as $idx => $p ) {
                        if ( $idx%2 == 0 ) {
                            $property->photos2[] = $p;
                        } else {
                            $property->photos1[] = $p;
                        }
                    }

                    // short description
                    if (strlen($property->description) > 200) {
                        $property->shortDescription = wordwrap($property->description, 200);
                        $property->shortDescription = substr($property->shortDescription, 0, strpos($property->shortDescription, "\n")) . "...";
                    }

                    $respObj->properties[] = $property;
                }
            } else {
                $respObj->code = 0;
            }

            echo json_encode($respObj);
            exit;
        }

        // /search/related/{city}/{type}}/{price}
        public function relatedProperties ( $city, $type, $price = 0, $currentId ) {
            $respObj = new \stdClass;
            $respObj->code = 1;
            $respObj->properties = array();

            $results = self::getProperties($city, $type, $price, $currentId);
            $searchesTried = 1;

            if ( !$results || count($results) < 3 ) {
                do {
                    switch ($searchesTried) {
                        case 1:
                            $results = self::getProperties(null, $type, $price, $currentId);
                            $searchesTried ++;
                            break;
                        case 2:
                            $results = self::getProperties(null, $type, null, $currentId);
                            $searchesTried ++;
                            break;
                    }
                } while ( $searchesTried < 3 && (!$results || count($results) < 3) );
            }

            if ( count($results) < 3 ) {
                $respObj->code = 0;
            } else {
                self::jsonifyResults($results, $respObj);
            }

            echo json_encode($respObj);
            exit;
        }


        private function getProperties ( $city, $type, $price, $currentId ) {
            $searchParams = array();

            if ( $city ) {
                $searchParams['city'] = $city;
            }
            if ( $type ) {
                $searchParams['property_type'] = $type;
            }

            // find the price range this price belongs to
            if ( $price && $price != 0 ) {
                foreach ( SparkSearch::$priceRanges as $idx => $rangeArr ) {
                    if ( isset($rangeArr['priceMax']) && ($rangeArr['priceMin'] <= $price) && ($price <= $rangeArr['priceMax']) ) {
                        $searchParams = array_merge($searchParams, SparkSearch::$priceRanges[$idx]);
                        break;
                    } else {
                        $searchParams = array_merge($searchParams, array_slice(SparkSearch::$priceRanges, -1, 1, true));
                        break;
                    }
                }
            }
            $search = new SparkSearch( $searchParams );

            $search->setApiMethod('getMyListings');
            $search->setSearchParams(array('_limit' => 5,'_select' => 'Photos.Uri800, Id, StreetName, StreetSuffix, City, StateOrProvince, ListingId, PublicRemarks' ));

            $results = $search->get()->getResults();

            foreach ( $results as $idx => $r ) {
                if ( $r->Id == $currentId ) {
                    unset($results[$idx]);
                }
            }

            return $results;
        }

        private function jsonifyResults ( $results, &$respObj ) {
            $results = array_slice($results, 0, 3);
            foreach ( $results as $r ) {
                $property = new \stdClass;
                $property->mainImage = $r->getFirstPhotoURL("800");
                $property->name = $r->getPropertyName();
                $property->description = $r->getDescription();
                $property->id = $r->getPropertyID();

                // short description
                if (strlen($property->description) > 90) {
                    $property->shortDescription = wordwrap($property->description, 90);
                    $property->shortDescription = substr($property->shortDescription, 0, strpos($property->shortDescription, "\n")) . "...";
                }

                $respObj->properties[] = $property;
            }

        }
    }
}