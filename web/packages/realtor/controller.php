<?php namespace Concrete\Package\Realtor {
    defined('C5_EXECUTE') or die(_("Access Denied."));

    /** @link https://github.com/concrete5/concrete5-5.7.0/blob/develop/web/concrete/config/app.php#L10-L90 Aliases */
    use Loader; /** @see \Concrete\Core\Legacy\Loader */
    use Router; /** @see \Concrete\Core\Routing\Router */
    use Route; /** @see \Concrete\Core\Support\Facade\Route */
    use Package; /** @see \Concrete\Core\Package\Package */
    use BlockType; /** @see \Concrete\Core\Block\BlockType\BlockType */
    use BlockTypeSet; /** @see \Concrete\Core\Block\BlockType\Set */
    use PageType; /** @see \Concrete\Core\Page\Type\Type */
    use PageTemplate; /** @see \Concrete\Core\Page\Template */
    use PageTheme; /** @see \Concrete\Core\Page\Theme\Theme */
    use FileSet; /** @see \Concrete\Core\File\Set\Set */
    use CollectionAttributeKey; /** @see \Concrete\Core\Attribute\Key\CollectionKey */
    use UserAttributeKey; /** @see \Concrete\Core\Attribute\Key\UserKey */
    use FileAttributeKey; /** @see \Concrete\Core\Attribute\Key\FileKey */
    use Group; /** @see \Concrete\Core\User\Group\Group */
    use GroupSet; /** @see \Concrete\Core\User\Group\GroupSet */
    use SinglePage; /** @see \Concrete\Core\Page\Single */
    use Config; /** @see \Concrete\Core\Support\Facade\COnfig */
    use Concrete\Core\Page\Type\PublishTarget\Type\Type as PublishTargetType;

    class Controller extends Package {

        const PACKAGE_HANDLE                = 'realtor',
            // Collection Attributes
            COLLECTION_ATTR_IMAGE           = 'page_image',
            // User Attributes
            FILE_ATTR_ASSOCIATED_COPY       = 'associated_copy',
            // File Set
            FILE_SET_MASTHEAD               = 'Masthead Slider',
            FILE_SET_MASTHEAD_BLOG          = 'Masthead Blog';

        const SPARK_API_KEY		= 'tet_2315_key_1';
        const SPARK_API_SECRET	= 'gqG9DqbiWbLBP0xzk9lvG';

        private static $configObj;

        protected $pkgHandle 			= self::PACKAGE_HANDLE;
        protected $appVersionRequired 	= '5.7';
        protected $pkgVersion 			= '0.65';


        /**
         * @return string
         */
        public function getPackageName(){
            return t('Realtor');
        }


        /**
         * @return string
         */
        public function getPackageDescription() {
            return t('Realtor Theme');
        }

        /**
         * Get a Config instance with the package object preset. This takes care of
         * memoizing the config object so the same Config instance can be used multiple
         * times throughout the same request.
         * @return Config
         */
        public static function getPackageConfigObj(){
            return Package::getByHandle(self::PACKAGE_HANDLE)->getConfig();
        }

        /**
         * Run hooks high up in the load chain.
         * @return void
         */
        public function on_start(){

            define('LINTON_EMAIL_ADDRESS', "lintonbingle@jhrea.com");

            define('REALTOR_IMAGE_PATH', DIR_REL . '/packages/' . $this->pkgHandle . '/images/');
            define('REALTOR_SRC_PATH', DIR_BASE . '/packages/realtor/src/');
            define('REALTOR_MODAL_PATH', DIR_BASE . '/packages/realtor/themes/lbr/elements/modals');

            Route::register('/search/count',
                '\Concrete\Package\Realtor\Controller\Tools\Search::resultsCount'
            );
            Route::register('/search/featured',
                '\Concrete\Package\Realtor\Controller\Tools\Search::featuredProperties'
            );
            Route::register('/search/related/{city}/{type}/{price}/{currentId}',
                '\Concrete\Package\Realtor\Controller\Tools\Search::relatedProperties'
            );
            Route::register('/landing/list/{id}/{multi}',
                '\Concrete\Package\Realtor\Controller\Tools\Landing::getPageListForId'
            );
            Route::register('/modal/email',
                '\Concrete\Package\Realtor\Controller\Tools\Modal::email'
            );
            Route::register('/modal/inquire',
                '\Concrete\Package\Realtor\Controller\Tools\Modal::inquire'
            );
            Route::register('/process_form',
                '\Concrete\Package\Realtor\Controller\Tools\Modal::processForm'
            );
            Route::register('/regions/delete/{id}',
                '\Concrete\Package\Realtor\Controller\Tools\Regions::delete'
            );
        }

        /**
         * Proxy to the parent uninstall method
         * @return void
         */
        public function uninstall() {
            parent::uninstall();

            try {
                // delete database tables (if applicable)
            }catch(Exception $e){ /* FAIL GRACEFULLY */ }
        }


        /**
         * Run before install or upgrade to ensure dependencies
         * are present.
         * @todo: include package dependency checks
         */
        private function checkDependencies(){
//            require_once(REALTOR_SRC_PATH . "SparkApi/lib/Core.php");
        }


        /**
         * @return void
         */
        public function upgrade() {
            $this->checkDependencies();
            parent::upgrade();
            $this->installAndUpdate();
        }


        /**
         * @return void
         */
        public function install() {
            $this->checkDependencies();
            $this->_packageObj = parent::install();
            $this->installAndUpdate();
        }


        /**
         * Handle all the updating methods.
         * @return void
         */
        private function installAndUpdate() {
            $this->setupAttributeTypeAssociations()
                ->setupCollectionAttributes()
                ->setupFileAttributes()
                ->setupFileSets()
                ->setupTheme()
                ->setupTemplates()
                ->setupPageTypes()
                ->assignPageTypes()
                ->setupSinglePages()
                ->setupBlockTypeSets()
                ->setupBlocks();
        }


        /**
         * @return Controller
         */
        private function setupAttributeTypeAssociations(){
            $fileAKC = \Concrete\Core\Attribute\Key\Category::getByHandle('file');
            if( is_object($fileAKC) ){
                $fileAKC->associateAttributeKeyType($this->attributeType('image_file'));
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupCollectionAttributes(){
            if( ! is_object(CollectionAttributeKey::getByHandle(self::COLLECTION_ATTR_IMAGE)) ){
                CollectionAttributeKey::add($this->attributeType('image_file'), array(
                    'akHandle' =>  self::COLLECTION_ATTR_IMAGE,
                    'akName'    => 'Page Image'
                ), $this->packageObject());
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupFileAttributes(){
            if( !(is_object(FileAttributeKey::getByHandle(self::FILE_ATTR_ASSOCIATED_COPY))) ){
                FileAttributeKey::add($this->attributeType('textarea'), array(
                    'akHandle'					=> self::FILE_ATTR_ASSOCIATED_COPY,
                    'akName'					=> t('Associated Copy'),
                    'uakRegisterEdit'			=> 1,
                    'uakRegisterEditRequired' 	=> 0,
                    'akIsSearchable'            => 1,
                    'akIsSearchableIndexed'     => 1,
                    'akTextareaDisplayMode'     => 'rich_text'
                ), $this->packageObject());
            }
//
//            if( !(is_object(FileAttributeKey::getByHandle(self::FILE_ATTR_SECONDARY_PHOTO))) ){
//                FileAttributeKey::add($this->attributeType('image_file'), array(
//                    'akHandle'					=> self::FILE_ATTR_SECONDARY_PHOTO,
//                    'akName'					=> t('Secondary Photo'),
//                    'uakRegisterEdit'			=> 1,
//                    'uakRegisterEditRequired' 	=> 0
//                ), $this->packageObject());
//            }
//
//            if( !(is_object(FileAttributeKey::getByHandle(self::FILE_ATTR_INVOLVEMENT_LEVEL))) ){
//                FileAttributeKey::add($this->attributeType('select'), array(
//                    'akHandle'                  => self::FILE_ATTR_INVOLVEMENT_LEVEL,
//                    'akName'                    => t('Involvement Level'),
//                    'uakRegisterEdit'           => 1,
//                    'uakRegisterEditRequired'   => 0
//                ), $this->packageObject());
//            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupFileSets(){
            if( ! is_object(FileSet::getByName(self::FILE_SET_MASTHEAD)) ){
                FileSet::createAndGetSet(self::FILE_SET_MASTHEAD, FileSet::TYPE_PUBLIC);
            }
            if( ! is_object(FileSet::getByName(self::FILE_SET_MASTHEAD_BLOG)) ){
                FileSet::createAndGetSet(self::FILE_SET_MASTHEAD_BLOG, FileSet::TYPE_PUBLIC);
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupTheme(){
            try {
                if( ! is_object(PageTheme::getByHandle('lbr')) ){
                    /** @var $theme \Concrete\Core\Page\Theme\Theme */
                    $theme = PageTheme::add('lbr', $this->packageObject());
                    if( is_object($theme) ){
                        $theme->applyToSite();
                    }
                }
            }catch(Exception $e){ /* fail gracefully */ }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupTemplates(){
            if( ! PageTemplate::getByHandle('default') ){
                PageTemplate::add('default', t('Default'), 'full.png', $this->packageObject());
            }
            if( ! PageTemplate::getByHandle('home') ){
                PageTemplate::add('home', t('Home'), 'full.png', $this->packageObject());
            }
            if( ! PageTemplate::getByHandle('landing') ){
                PageTemplate::add('landing', t('Landing'), 'full.png', $this->packageObject());
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupPageTypes(){
            /** @var $pageType \Concrete\Core\Page\Type\Type */
            $pageType = PageType::getByHandle('page');

            // Delete it? Only works if the $pageType isn't assigned to this package already
            if( is_object($pageType) && !((int)$pageType->getPackageID() >= 1) ){
                $pageType->delete();
            }

            if( !is_object(PageType::getByHandle('page')) ){
                /** @var $ptPage \Concrete\Core\Page\Type\Type */
                $ptPage = PageType::add(array(
                    'handle'                => 'page',
                    'name'                  => t('Page'),
                    'defaultTemplate'       => PageTemplate::getByHandle('default'),
                    'ptIsFrequentlyAdded'   => 1,
                    'ptLaunchInComposer'    => 1
                ), $this->packageObject());

                // Set configured publish target
                $ptPage->setConfiguredPageTypePublishTargetObject(
                    PublishTargetType::getByHandle('all')->configurePageTypePublishTarget($ptPage, array(
                        'ptID' => $ptPage->getPageTypeID()
                    ))
                );

                /** @var $layoutSet \Concrete\Core\Page\Type\Composer\FormLayoutSet */
                $layoutSet = $ptPage->addPageTypeComposerFormLayoutSet('Basics', 'Basics');

                /** @var $controlTypeCorePageProperty \Concrete\Core\Page\Type\Composer\Control\Type\CorePagePropertyType */
                $controlTypeCorePageProperty = \Concrete\Core\Page\Type\Composer\Control\Type\Type::getByHandle('core_page_property');

                /** @var $controlTypeName \Concrete\Core\Page\Type\Composer\Control\CorePageProperty\NameCorePageProperty */
                $controlTypeName = $controlTypeCorePageProperty->getPageTypeComposerControlByIdentifier('name');
                $controlTypeName->addToPageTypeComposerFormLayoutSet($layoutSet)
                    ->updateFormLayoutSetControlRequired(true);

                /** @var $controlTypePublishTarget \Concrete\Core\Page\Type\Composer\Control\CorePageProperty\PublishTargetCorePageProperty */
                $controlTypePublishTarget = $controlTypeCorePageProperty->getPageTypeComposerControlByIdentifier('publish_target');
                $controlTypePublishTarget->addToPageTypeComposerFormLayoutSet($layoutSet)
                    ->updateFormLayoutSetControlRequired(true);
            }

            return $this;
        }


        /**
         * @return Controller
         */
        function assignPageTypes(){
            Loader::db()->Execute('UPDATE Pages set pkgID = ? WHERE cID = 1', array(
                (int) $this->packageObject()->getPackageID()
            ));

            // Things available through the API
            $homePageCollection = \Concrete\Core\Page\Page::getByID(1)->getVersionToModify();
            $homePageCollection->update(array(
                'pTemplateID' => PageTemplate::getByHandle('home')->getPageTemplateID()
            ));
            $homePageCollection->setPageType(PageType::getByHandle('page'));

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupSinglePages() {
            // Property Search Results
            SinglePage::add('/properties/', $this->packageObject());

            SinglePage::add('/dashboard/theme_settings', $this->packageObject());
            SinglePage::add('/dashboard/theme_settings/settings', $this->packageObject());

            SinglePage::add('/dashboard/regions', $this->packageObject());
            SinglePage::add('/dashboard/regions/detail', $this->packageObject());

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupBlockTypeSets(){
            if( !is_object(BlockTypeSet::getByHandle(self::PACKAGE_HANDLE)) ){
                BlockTypeSet::add(self::PACKAGE_HANDLE, self::PACKAGE_HANDLE, $this->packageObject());
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupBlocks(){
            if(!is_object(BlockType::getByHandle('photo_wall'))) {
                BlockType::installBlockTypeFromPackage('photo_wall', $this->packageObject());
            }
            if(!is_object(BlockType::getByHandle('button'))) {
                BlockType::installBlockTypeFromPackage('button', $this->packageObject());
            }

//            if(!is_object(BlockType::getByHandle('statistic'))) {
//                BlockType::installBlockTypeFromPackage('statistic', $this->packageObject());
//            }
//
//            if(!is_object(BlockType::getByHandle('photo_wall'))) {
//                BlockType::installBlockTypeFromPackage('photo_wall', $this->packageObject());
//            }
//
//            if(!is_object(BlockType::getByHandle('single_page_nav'))) {
//                BlockType::installBlockTypeFromPackage('single_page_nav', $this->packageObject());
//            }
//
//            if(!is_object(BlockType::getByHandle('twitter_feed'))) {
//                BlockType::installBlockTypeFromPackage('twitter_feed', $this->packageObject());
//            }
//
//            if(!is_object(BlockType::getByHandle('portfolio'))) {
//                BlockType::installBlockTypeFromPackage('portfolio', $this->packageObject());
//            }

            return $this;
        }


        /**
         * Get the package object; if it hasn't been instantiated yet, load it.
         * @return \Concrete\Core\Package\Package
         */
        private function packageObject(){
            if( $this->_packageObj === null ){
                $this->_packageObj = Package::getByHandle( $this->pkgHandle );
            }
            return $this->_packageObj;
        }


        /**
         * @return AttributeType
         */
        private function attributeType( $handle ){
            if( is_null($this->{"at_{$handle}"}) ){
                $attributeType = \Concrete\Core\Attribute\Type::getByHandle($handle);
                if( is_object($attributeType) && $attributeType->getAttributeTypeID() >= 1 ){
                    $this->{"at_{$handle}"} = $attributeType;
                }
            }
            return $this->{"at_{$handle}"};
        }

    }
}
