<?php namespace Concrete\Package\Realtor\Controller\Tools {

    use Concrete\Core\Form\Service\Validation;
    use Concrete\Package\Realtor\Controller\Tools\AjaxException;
    use Loader;

    class AjaxHandler extends Validation {

        const FAILURE_CODE	= 0,
            SUCCESS_CODE	= 1;

        protected $exceptions = array(),
            $jsonHelper,
            $captcha,
            $stringValidation,
            $respObj;


        public function __construct(){
            parent::__construct();
            $this->jsonHelper = Loader::helper('json');
            $this->captcha	  = Loader::helper('validation/captcha');
            $this->stringValidation = Loader::helper('validation/strings');
            $this->setData( $_REQUEST );

            // setup the response object
            $this->respObj = new \stdClass;
            $this->respObj->code = self::FAILURE_CODE;
            $this->respObj->messages = array();
        }


        public function __toString(){
            if( !empty($this->exceptions) ){
                $this->respObj->code = self::FAILURE_CODE;
                foreach($this->exceptions AS $exception){ /* @var $exception Exception */
                    $this->respObj->messages[] = $exception->getMessage();
                    if( $exception instanceof AjaxException ){
                        if( $this->respObj->fields == null ){
                            $this->respObj->fields = array();
                        }
                        $this->respObj->fields[] = $exception->getFieldName();
                    }
                }
            }else{
                $this->respObj->code	   = self::SUCCESS_CODE;
                $this->respObj->messages[] = 'Your message has been sent!';
            }
            return $this->jsonHelper->encode( $this->respObj );
        }


        public function execute(){
            if( !($this->captcha->check()) ){
                //$this->addException( new Exception('Captcha code is incorrect.') );
                $this->invalidate('', 'Captcha code is incorrect. Click Captcha image to get new captcha.');
            }

            // first, run validation
            if( !($this->test()) ){
                foreach($this->fieldsInvalid AS $error){
                    $this->addException( new AjaxException($error->message, $error->field) );
                }
            }else{
                try {
                    $this->mailHelper()->sendMail();
                }catch(Exception $e){
                    $this->addException($e);
                }
            }

            // return the class object (we use __toString to echo the $respObj)
            return $this;
        }


        public function setSender( $email, $name = null ){
            $this->mailHelper()->from( $email, $name );
        }


        public function addRecipient( $email, $name = null ){
            $this->mailHelper()->to($email, $name);
        }


        public function addCC( $email, $name = null ){
            $this->mailHelper()->cc($email, $name);
        }


        public function setSubject($subject){
            $this->mailHelper()->setSubject($subject);
        }


        public function setBody($body){
            $this->mailHelper()->setBody($body);
        }


        public function setTemplate($template, $pkgHandle = null){
            // before we set the template, set all the $_REQUEST variables
            foreach($_REQUEST AS $k => $v){
                $this->mailHelper()->addParameter($k, $v);
            }
            $this->mailHelper()->load($template, $pkgHandle);
        }


        public function addTemplateParameter($key, $val){
            $this->mailHelper()->addParameter($key, $val);
        }


        public function isValidEmail( $email ){
            return (bool) $this->stringValidation->email($email);
        }


        public function invalidate( $fieldName, $message ){
            $f = new \stdClass;
            $f->field = $fieldName;
            $f->message = $message;
            $this->fieldsInvalid[] = $f;
        }


        /**
         * We keep track of all the exceptions in an array,
         * so we can standardize the output when we render it
         */
        protected function addException( \Exception $e ){
            $this->exceptions[] = $e;
        }


        /**
         * Get the active instance of the mailHelper class
         * @return MailHelper
         */
        protected function mailHelper(){
            if( $this->mailHelper === null ){
                $this->mailHelper = Loader::helper('mail');
            }
            return $this->mailHelper;
        }
    }
}
