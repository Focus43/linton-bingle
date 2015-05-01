<?php namespace Concrete\Package\Realtor\Src\PropertySearch {

    use Concrete\Package\Realtor\Controller AS PackageController;
    use  Concrete\Package\Realtor\Src\Cache\RedisCache;


    require_once(REALTOR_SRC_PATH . "SparkApi/lib/Core.php");
    require_once(REALTOR_SRC_PATH . "SparkApi/lib/MemcacheCache.php");

    class SparkConnection {

        private static $_sparkAPI;

        /**
         * @return SparkAPI_APIAuth
         */
        public static function sparkApi() {
            if( self::$_sparkAPI === null ){
                self::$_sparkAPI = new \SparkAPI_APIAuth( PackageController::SPARK_API_KEY, PackageController::SPARK_API_SECRET );
                self::$_sparkAPI->SetDeveloperMode( true );
    //            self::$_sparkAPI->SetDeveloperMode( (C5_APPLICATION_ENVIRONMENT == 'production' ? false : true) );
                self::$_sparkAPI->SetApplicationName('lintonbingle.com');
                $auth = self::$_sparkAPI->Authenticate();
                if( $auth === false ){
                    throw new \Exception( 'A problem occurred searching for the property you requested.' );
                }
            }
            return self::$_sparkAPI;
        }

        /**
         * @return array
         */
        public static function getPropertyTypes( $bustCache = false ){

            if ( !$bustCache ) {
                $typesHash = RedisCache::cache()->get(__CLASS__ . 'property_types');
                if ($typesHash) { $types = RedisCache::cache()->_unserialize($typesHash); }
                if( is_array($types) ) {
                    return $types;
                }
            }

            // cache missed; load from the API
            $types = (array) self::sparkApi()->GetPropertyTypes();

            // cache it
            $toCache = RedisCache::cache()->_serialize($types);
            RedisCache::cache()->set(__CLASS__ . 'property_types', $toCache, 2592000);

            return $types;
        }

        /**
         * @return int
         */
        public static function getMinPrice( $bustCache = false ){
//            if( !$bustCache ){
//                $minPrice = (int) Cache::get( __CLASS__, 'min_price' );
//                if( $minPrice >= 1 ){
//                    return $minPrice;
//                }
//            }

            // if cache missed; query Spark API for lowest priced property
            $listing = self::sparkApi()->GetMyListings(array(
                '_pagination' 	=> 1,
                '_limit'		=> 1,
                '_filter'		=> "MlsStatus Eq 'A' And StateOrProvince Eq 'WY'",
                '_orderby'		=> '+ListPrice'
            ));
            $price = (int) $listing[0]['StandardFields']['ListPrice'];

            // cache it
//            Cache::set( __CLASS__, 'min_price', $price, (Config::get('FULL_PAGE_CACHE_LIFETIME_CUSTOM') * 60) );

            return $price;
        }


        /**
         * @return int
         */
        public static function getMaxPrice( $bustCache = false ){
//            if( !$bustCache ){
//                $maxPrice = (int) Cache::get( __CLASS__, 'max_price' );
//                if( $maxPrice >= 1 ){
//                    return $maxPrice;
//                }
//            }

            // if cache missed; query Spark API for highest priced property
            $listing = self::sparkApi()->GetMyListings(array(
                '_pagination' 	=> 1,
                '_limit'		=> 1,
                '_filter'		=> "MlsStatus Eq 'A' And StateOrProvince Eq 'WY'",
                '_orderby'		=> '-ListPrice'
            ));
            $price = (int) $listing[0]['StandardFields']['ListPrice'];

            // cache it
//            Cache::set( __CLASS__, 'max_price', $price, (Config::get('FULL_PAGE_CACHE_LIFETIME_CUSTOM') * 60) );

            return $price;
        }
    }
}
