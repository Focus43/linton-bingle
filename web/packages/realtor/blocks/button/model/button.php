<?php namespace Concrete\Package\Lineal\Block\Button\Model {

    use Page;

    /**
     * Class Button
     * @package Concrete\Package\Lineal\Block\Button\Model
     */
    class Button implements \JsonSerializable {

        protected $pageID,
                  $label,
                  $target,
                  $classes;

        /** @return mixed */
        public function getPageID(){ return $this->pageID; }
        /** @return mixed */
        public function getLabel(){ return $this->label; }
        /** @return mixed */
        public function getTarget(){ return $this->target; }
        /** @return array|null */
        public function getClasses(){ return (array) $this->classes; }

        /**
         * @return Page
         */
        public function getPageObj(){
            if( $this->_pageObj === null ){
                $this->_pageObj = Page::getByID($this->pageID);
            }
            return $this->_pageObj;
        }

        /**
         * So you can do: echo $instance and it'll return either the label (if set)
         * or default to the page name.
         * @return mixed
         */
        public function __toString(){
            if( empty($this->label) ){
                return $this->getPageObj()->getCollectionName();
            }
            return $this->label;
        }

        /**
         * Pass in either: a serialized json string, an array of properties, or null.
         * @param mixed|stdClass|null $data
         */
        public function __construct( $data = null ){
            $this->initializeFromMixed($data);
        }

        /**
         * Implementation for JsonSerializable interface.
         * @return mixed|object
         */
        public function jsonSerialize(){
            return (object) get_object_vars($this);
        }

        /**
         * Handle mixed data type initialization.
         * @param null $data
         */
        protected function initializeFromMixed( $data = null ){
            if( is_null($data) ){ return; }

            if( is_array($data) ){
                $this->setPropertiesFromArray($data);
                return;
            }

            if( is_string($data) ){
                $unserialized = json_decode($data);
                if( json_last_error() === JSON_ERROR_NONE ){
                    $this->setPropertiesFromArray(get_object_vars($unserialized));
                }
            }
        }

        /**
         * Take properties from an array and set them as values on $this.
         * @param array $properties
         * @return $this
         */
        protected function setPropertiesFromArray( array $properties = array() ){
            foreach($properties AS $prop => $val){
                $this->{$prop} = $val;
            }
            return $this;
        }

    }

}