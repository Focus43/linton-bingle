<?php namespace Concrete\Package\Realtor\Controller\Tools {

    use Page;
    use PageList;
    use Controller;
    use Concrete\Package\Realtor\Controller\Tools\AjaxHandler as AjaxHandler;

    class Modal extends Controller {

        public function email(  ) {
            include REALTOR_MODAL_PATH . "/email.php";
        }

        public function processForm () {
//            Loader::library('ajax_handler', 'realtor');
//            Loader::model('spark/property', 'linton');
            $captcha = \Loader::helper('validation/captcha');

            $handler = new AjaxHandler();

            switch( true ){
//                case $_REQUEST['type'] == 'inquire':
//                    $sparkProperty = SparkProperty::getByID( $_REQUEST['localeID'] );
//                    // validation
//                    $handler->addRequired('name', 'Name field is required.');
//                    $handler->addRequiredEmail('email', 'A valid email address is required.');
//                    $handler->addRequired('phone', 'Phone field is required.');
//                    // mail settings
//                    $handler->addRecipient( LINTON_EMAIL_ADDRESS );
//                    $handler->addTemplateParameter('sparkProperty', $sparkProperty);
//                    $handler->setTemplate('inquire', 'linton');
//                    break;


//                case $_REQUEST['type'] == 'share':
//                    $sparkProperty = SparkProperty::getByID( $_REQUEST['localeID'] );
//                    // validation
//                    $handler->addRequired('share_sender_name', 'Your name is required.');
//                    $handler->addRequiredEmail('share_sender_email', 'Your email address must be valid.');
//                    $handler->addRequired('share_message', 'You must include at least a brief message.');
//                    $handler->addRequired('share_recipients', 'You must specify the email address(es) of recipients.');
//                    // validate all the recipients in the share_with field
//                    $recipients = explode(',', $_REQUEST['share_recipients']);
//                    foreach($recipients AS $email){
//                        $email = trim($email);
//                        if( !$handler->isValidEmail($email) ){
//                            $handler->invalidate( 'share_recipients', 'The "share with" field contains invalid email addresses.' );
//                            break;
//                        }else{
//                            // email *is* valid, so add a recipient
//                            $handler->addRecipient($email);
//                        }
//                    }
//                    // mail settings (recipients are set above)
//                    $handler->setSender( $_REQUEST['share_sender_email'], $_REQUEST['share_sender_name'] );
//                    $handler->addTemplateParameter('sparkProperty', $sparkProperty);
//                    $handler->setTemplate('share', 'linton');
//                    if( (bool)$_REQUEST['cc_me'] ){
//                        $handler->addRecipient( $_REQUEST['share_sender_email'] );
//                    }
//                    break;


                case $_REQUEST['type'] == 'general_contact':
                    // validation
                    $handler->addRequired('share_sender_name_first', 'First name is required.');
                    $handler->addRequired('share_sender_name_last', 'Last name is required.');
                    $handler->addRequiredEmail('share_sender_email', 'A valid email address is required.');
                    if( isset($_REQUEST['brochure']) ){
                        // if a brochure is requested, we need all the address fields too!
                        $handler->addRequired('address1', 'An address is required to receive brochure.');
                        $handler->addRequired('city', 'A city is required to receive brochure.');
                        $handler->addRequired('state', 'A state is required to receive brochure.');
                        $handler->addRequired('zip', 'A zip is required to receive brochure.');
                    }
                    // mail settings
                    $handler->addRecipient( LINTON_EMAIL_ADDRESS );
                    $handler->setTemplate('contact', 'realtor');
                    break;
            }


            // run it
            echo $handler->execute();
        }
    }
}