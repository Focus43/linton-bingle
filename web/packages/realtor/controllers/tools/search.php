<?php namespace Concrete\Package\Realtor\Controller\Tools {

    use Controller;
    use Concrete\Package\Realtor\Src\PropertySearch\SparkSearch as SparkSearch;
    use  Concrete\Package\Realtor\Src\Cache\RedisCache;

    class Search extends Controller {

        public function resultsCount () {
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

        // /search/related/{city}/{beds}/{baths}/{price}
        public function relatedProperties ( $city = "Jackson", $beds = "3", $baths = "2" ) {
            $respObj = new \stdClass;
            $respObj->code = 1;
            $respObj->properties = array();

//            $search = new SparkSearch( array('city' => $city, 'beds' => $beds, 'baths' => $baths, 'priceMin' => $price - 200000, 'priceMax' => $price + 200000) );
            $search = new SparkSearch( array('city' => $city) );
            $search->setApiMethod('getMyListings');
            $search->setSearchParams(array('_limit' => 3,'_select' => 'Photos.Uri800, Id, StreetName, StreetSuffix, City, StateOrProvince, ListingId, PublicRemarks' ));
            $results = $search->get()->getResults();

            if ( $results && count($results) >= 3 ) {
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
            } else {
                $respObj->code = 0;
            }

            echo json_encode($respObj);
            exit;
        }
    }
}