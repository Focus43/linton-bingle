<?php namespace Concrete\Package\Realtor\Src {

    /**
     * Class Calendar
     * @package Concrete\Package\Sequence\Src
     * @Entity
     * @HasLifecycleCallbacks
     */
    class ThemeProperties extends Abstracts\Base {
        use Traits\Persistable;

        /**
         * @Column(type="string", length=255)
         */
        protected $theme_social_link_facebook;
        /**
         * @Column(type="text")
         */
        protected $theme_social_link_twitter;
        /**
         * @Column(type="string", length=255)
         */
        protected $theme_social_link_youtube;
        /**
         * @Column(type="simple_array")
         */
        protected $theme_social_link_linkedin;
        /**
         * @Column(type="string", length=255)
         */
        protected $theme_social_link_pinterest;
        /**
         * @Column(type="string", length=255)
         */
        protected $theme_social_link_googleplus;
        /**
         * @Column(type="string", length=255)
         */
        protected $theme_email_address;
        /**
         * @Column(type="string", length=255)
         */
        protected $theme_phone_number;
        /**
         * @Column(type="string", length=255)
         */
        protected $theme_twitter_feed_handle;
//        /**
//         * @Column(columnDefinition="integer unsigned")
//         */
//        protected $mainImageID;
//        /**
//         * @Column(columnDefinition="integer unsigned")
//         */
//        protected $galleryFileSetID;
//        /**
//         * @Column(columnDefinition="integer unsigned")
//         */
//        protected $clientLogoFileID;
//        /**
//         * @Column(columnDefinition="boolean")
//         */
//        protected $isFeatured;


        /**
         * Constructor
         */
        public function __construct(){

        }
        /**
         * @return string
         */
//        public function __toString(){
//            return ucwords( $this->title );
//        }
//        /**
//         * @return string
//         */
//        public function getTitle(){
//            return $this->title;
//        }
//        /**
//         * @return string
//         */
//        public function getDescription(){
//            return $this->description;
//        }
//        /**
//         * @return string
//         */
//        public function getShortName(){
//            return $this->shortName;
//        }
//        /**
//         * @return string
//         */
//        public function getCategory(){
//            return implode(",", (array) $this->category);
//        }
//        /**
//         * @return string
//         */
//        public function getCategoryString(){
//            $categoryOptions = self::getCategoryOptions();
//            $categoryString = "";
//            foreach ( (array) $this->category as $key ) {
//                $categoryString .= $categoryOptions[$key] . ", ";
//            }
//            return substr($categoryString, 0, -2);
//        }
//        /**
//         * @return string
//         */
//        public function getToolsUsed(){
//            return $this->toolsUsed;
//        }
//        /**
//         * @return string
//         */
//        public function getClientName(){
//            return $this->clientName;
//        }
//        /**
//         * @return string
//         */
//        public function getClientUrl(){
//            return $this->clientUrl;
//        }
//        /**
//         * @return string
//         */
//        public function getProjectUrl(){
//            return $this->projectUrl;
//        }
//        /**
//         * @return int
//         */
//        public function getMainImageID(){
//            return $this->mainImageID;
//        }
//        /**
//         * @return int
//         */
//        public function getGalleryFileSetID(){
//            return $this->galleryFileSetID;
//        }
//        /**
//         * @return int
//         */
//        public function getClientLogoFileID(){
//            return $this->clientLogoFileID;
//        }

        /**
         * @param $id Int
         * @return mixed SequencePortfolio|null
         */
        public static function getByID( $id ){
            return self::entityManager()->find(__CLASS__, $id);
        }

    }
}