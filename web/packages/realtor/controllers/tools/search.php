<?php namespace Concrete\Package\Realtor\Controller\Tools {

    use Controller;
    use Concrete\Package\Realtor\Src\PropertySearch\SparkSearch as SparkSearch;

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
            $search->setSearchParams(array('_limit' => 25));
//            $search->setSearchParams(array('_limit' => 3));
            $results = $search->get();

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
    }
}