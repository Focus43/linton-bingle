<?php namespace Concrete\Package\Realtor\Src\Cache {

  use \Concrete\Package\Realtor\Src\Cache\Database;

  class RedisCache {
    protected static $_db;

    public static function cache(){
      if ( self::$_db === null ) {
          self::$_db = new Database();
      }
      return self::$_db;
    }
  }

    // use Redis;
    //
    // class RedisCache {
    //
    //     protected static $_db;
    //
    //     public static function cache() {
    //         if ( self::$_db === null ) {
    //             self::$_db = new Redis();
    //             $addr = $_SERVER['CACHE1_HOST'] ? $_SERVER['CACHE1_HOST'] : '127.0.0.1';
    //             $port = $_SERVER['CACHE1_PORT'] ? $_SERVER['CACHE1_PORT'] : 6379;
    //             self::$_db->connect( $addr, $port );
    //             self::$_db->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
    //         }
    //         return self::$_db;
    //     }
    //
    // }
}
