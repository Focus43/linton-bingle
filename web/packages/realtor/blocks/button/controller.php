<?php namespace Concrete\Package\Realtor\Block\Button;

use Loader;
use BlockType;
use Package;

class Controller extends \Concrete\Core\Block\BlockController {

    const TARGET_SELF   = '_self',
          TARGET_BLANK  = '_blank';

    public static $linkTargets = array(
        self::TARGET_SELF   => 'This Window',
        self::TARGET_BLANK  => 'New Window/Tab'
    );

    protected $serializedData;

    protected $btTable 									= 'btButton';
    protected $btInterfaceWidth 						= '350';
    protected $btInterfaceHeight						= '370';
    protected $btDefaultSet                             = 'lineal';
    protected $btCacheBlockRecord 						= true;
    protected $btCacheBlockOutput 						= true;
    protected $btCacheBlockOutputOnPost 				= true;
    protected $btCacheBlockOutputForRegisteredUsers 	= false;
    protected $btCacheBlockOutputLifetime 				= 0;

    public function getBlockTypeDescription(){
        return t("Add a styled button");
    }


    public function getBlockTypeName(){
        return t("Button");
    }


    public function view(){
        $this->set('buttonObj', $this->getButtonObj());
    }


    public function add(){
        $this->edit();
    }


    public function composer(){
        $this->edit();
    }


    public function edit(){
        $this->requireAsset('select2');
        $this->set('pageSelector', Loader::helper('form/page_selector'));
        $this->set('buttonObj', $this->getButtonObj());
        $this->set('classOptions', $this->classOptions());
    }


    /**
     * @return mixed|stdClass
     */
    protected function getButtonObj(){
        if( $this->_buttonModel === null ){
            $this->_buttonModel = new Model\Button($this->serializedData);
        }
        return $this->_buttonModel;
    }


    /**
     * Parse _classes.json file, if included.
     * @return array|mixed|null
     */
    protected function classOptions(){
        if( $this->_classOptions === null ){
            $filePath = $this->blockDirectoryPath('_classes.json');
            if( file_exists($filePath) ){
                try {
                    $parsed = json_decode( \Core::make('helper/file')->getContents($filePath) );
                    if( json_last_error() === JSON_ERROR_NONE ){
                        $this->_classOptions = (array) $parsed;
                    }
                }catch(\Exception $e){ /* fail gracefully */ }
            }else{
                $this->_classOptions = array();
            }
        }
        return $this->_classOptions;
    }


    /**
     * Make sure the form input is valid eh?
     * @param $args
     * @return bool
     */
    public function validate($args){
        $error = Loader::helper('validation/error');
        if( empty($args['pageID']) || ((int)$args['pageID'] < 1) ){
            $error->add(t('Link To field is required.'));
        }
        if( $error->has() ){
            return $error;
        }
    }


    /**
     * Called automatically by framework
     * @param array $args
     */
    public function save( $args ){
        $buttonModel = new Model\Button(array(
            'pageID'  => (int) $args['pageID'],
            'label'   => $args['label'],
            'target'  => $args['target'],
            'classes' => $args['classes']
        ));
        parent::save(array('serializedData' => json_encode($buttonModel)));
    }


    /**
     * Get file system path to the root of the block directory.
     * @param $append string
     * @return string
     */
    protected function blockDirectoryPath( $append = '' ){
        if( $this->_blockDirPath === null ){
            $packageObj = Package::getByID(BlockType::getByHandle($this->btHandle)->getPackageID());
            $this->_blockDirPath = DIR_PACKAGES . '/' . $packageObj->getPackageHandle() . '/' . DIRNAME_BLOCKS . '/' . $this->btHandle;
        }
        return sprintf('%s/%s', $this->_blockDirPath, $append);
    }

}