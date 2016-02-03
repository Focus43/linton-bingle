<?php namespace Concrete\Package\Realtor\Src\Cache {
  use Loader;
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
    protected $tableName = 'SparkCache';
    /**
     * @param $key
     * @return string | null
     */
    public function get( $key ){
      // $db = Loader::db();
      // $curTime = time();
      // //$escKey = addslashes($key);
      // $result = $db->execute("SELECT * FROM {$this->tableName} WHERE cacheKey = ? and expUTC >= $curTime", array($key));
      // //$result = Loader::db()->Execute($query);
      // while ($row = $result->FetchRow()) {
      //   $test = $row['column'];
      // }
      // print_r($result);
      // exit;
      // if( ! $result ){
      //    return null;
      // }
      // return $result;
      return null;
    }

    /**
     * @param $key
     * @param $value
     * @param null $exp (optional)?
     */
    public function set( $key, $value, $exp ){
      // get current seconds UTC timestamp
      // + $exp for the createdUTC
      // $expires = time() + $exp;

      // Loader::db()->Execute("INSERT INTO {$this->tableName} (cacheKey,cacheValue,expUTC) VALUES (?,?,?)", array($key, $value, $expires));

    }

    public function _serialize( $value ){
      return serialize($value);
    }

    public function _unserialize( $value ){
      return unserialize($value);
    }

  }

}
