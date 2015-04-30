<?php namespace Concrete\Package\Realtor\Controller\Tools {

    class AjaxException extends \Exception {

        protected $fieldName;

        public function __construct( $message, $fieldName = '' ){
            $this->fieldName = $fieldName;
            parent::__construct($message, 0);
        }

        public function getFieldName(){
            return $this->fieldName;
        }

    }
}