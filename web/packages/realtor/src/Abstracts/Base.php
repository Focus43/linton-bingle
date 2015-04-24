<?php

namespace Concrete\Package\Realtor\Src\Abstracts {
    use Concrete\Package\Realtor\Src\Interfaces\BaseInterface;
    /**
     * Class Base
     * @package Concrete\Package\Realtor\Src\Abstracts
     */
    abstract class Base implements BaseInterface {
        /**
         * @param array $properties
         */
        public function setPropertiesFromArray( array $properties = array() ){
            foreach($properties as $key => $prop) {
                $this->{$key} = $prop;
            }
            return $this;
        }
    }
}
