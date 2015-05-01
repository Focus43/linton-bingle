<?php namespace Concrete\Package\Realtor\Src\Cache {

    use Redis;

    class RedisCache {

        protected static $_redis;

        public static function cache() {
            if ( self::$_redis === null ) {
                self::$_redis = new Redis();
                $addr = $_SERVER['CACHE1_HOST'] ? $_SERVER['CACHE1_HOST'] : '127.0.0.1';
                $port = $_SERVER['CACHE1_PORT'] ? $_SERVER['CACHE1_PORT'] : 6379;
                self::$_redis->connect( $addr, $port );
                self::$_redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
            }
            return self::$_redis;
        }

    }
}
