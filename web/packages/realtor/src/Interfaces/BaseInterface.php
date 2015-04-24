<?php namespace Concrete\Package\Realtor\Src\Interfaces {
    /**
     * Interface BaseInterface
     * @package Concrete\Package\Realtor\Src\Abstracts
     */
    interface BaseInterface {
        const PACKAGE_HANDLE    = 'sequence';
        const TIMESTAMP_FORMAT  = 'Y-m-d H:i:s';
        public function setPropertiesFromArray( array $properties = array() );
        public static function getByID( $id );
    }
}