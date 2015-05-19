<?php namespace Concrete\Package\Realtor\Controller\Tools {

    use Page;
    use PageList;
    use Controller;
    use Concrete\Package\Realtor\Src\PropertySearch\SparkProperty as SparkProperty;

    class Modal extends Controller {

        public function email(  ) {
            include REALTOR_MODAL_PATH . "/email.php";
        }
        public function inquire(  ) {
            include REALTOR_MODAL_PATH . "/email.php";
        }

        public function processForm () {

            $captcha = \Loader::helper('validation/captcha');

            $handler = new AjaxHandler();

//            switch( true ){
//                case $_REQUEST['type'] == 'inquire':
//                    $sparkProperty = SparkProperty::getByID( $_REQUEST['localeID'] );
//                    // validation
//                    $handler->addRequired('name', 'Name field is required.');
//                    $handler->addRequiredEmail('email', 'A valid email address is required.');
//                    $handler->addRequired('phone', 'Phone field is required.');
//                    // mail settings
////                    $handler->addRecipient( LINTON_EMAIL_ADDRESS );
//                    $handler->addRecipient( "superrunt@gmail.com" );
//                    $handler->setSender( "lintonbingle@gmail.com" );
//                    $handler->addTemplateParameter('sparkProperty', $sparkProperty);
//                    $handler->setTemplate('contact', 'realtor');
//                    break;
//
//
//
//                case $_REQUEST['type'] == 'general_contact':
                    // validation
                    $handler->addRequired('share_sender_name_first', 'First name is required.');
                    $handler->addRequired('share_sender_name_last', 'Last name is required.');
                    $handler->addRequiredEmail('share_sender_email', 'A valid email address is required.');
//                    if( isset($_REQUEST['brochure']) ){
//                        // if a brochure is requested, we need all the address fields too!
//                        $handler->addRequired('address1', 'An address is required to receive brochure.');
//                        $handler->addRequired('city', 'A city is required to receive brochure.');
//                        $handler->addRequired('state', 'A state is required to receive brochure.');
//                        $handler->addRequired('zip', 'A zip is required to receive brochure.');
//                    }

                    if ( isset($_REQUEST['propertyID']) ) {
                        $sparkProperty = SparkProperty::getByID( $_REQUEST['propertyID'] );
                        $handler->addTemplateParameter('propertyName', $sparkProperty->getPropertyName());
                        $handler->addTemplateParameter('MLSNumber', $sparkProperty->getMlsNumber());
                    }
                    // mail settings
                    $handler->addRecipient( LINTON_EMAIL_ADDRESS );
//                    $handler->addRecipient( "superrunt@gmail.com" );
                    $handler->setSender( "lintonbingle@gmail.com" );
                    $handler->setTemplate('contact', 'realtor');
//                    print_r($handler);exit;
//                    break;
//            }


            // run it
            echo $handler->execute();
        }
    }
}