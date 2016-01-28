<?php namespace Concrete\Package\Realtor\Src\Cache {

  /**
   * Class Database
   * @package Concrete\Package\Realtor\Src\Cache
   * ------------------------------------------------------------
   * cacheKey | cacheValue | expUTC
   * ------------------------------------------------------------
   *
   * ------------------------------------------------------------
   */
  class Database {

    /**
     * @param $key
     * @return string | null
     */
    public function get( $key ){
      //$result = "select from _ where key = ${key} and expUTC >= current time";
      if( ! $result ){
        return null;
      }
      return $result;
    }

    /**
     * @param $key
     * @param $value
     * @param null $exp (optional)?
     */
    public function set( $key, $value, $exp = null ){
      // get current seconds UTC timestamp
      // + $exp for the createdUTC
      //
    }

    public function _serialize( $value ){
      return serialize($value);
    }

    public function _unserialize( $value ){
      return unserialize($value);
    }

  }

}
