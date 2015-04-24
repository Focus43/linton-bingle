<?php namespace Concrete\Package\Realtor\Src\Traits {

    date_default_timezone_set('UTC');

    use Database;
    use DateTime;
    use DateTimeZone;

    /**
     * Class Persistable
     * @package Concrete\Package\Realtor\Src\Traits
     * @todo: Installation test to ensure support for prepersist callbacks!
     */
    trait Persistable {

        /**
         * @Id @Column(type="integer") @GeneratedValue
         * @var int
         */
        protected $id;

        /**
         * @Column(type="datetime")
         * @var DateTime
         */
        protected $createdUTC;

        /**
         * @Column(type="datetime")
         * @var DateTime
         */
        protected $modifiedUTC;

        /**
         * @PrePersist
         */
        public function setCreatedUTC(){
            if( !($this->createdUTC instanceof DateTime) ){
                $this->createdUTC = new DateTime('now', new DateTimeZone('UTC'));
            }
        }

        /**
         * @PrePersist
         * @PreUpdate
         */
        public function setModifiedUTC(){
            $this->modifiedUTC = new DateTime('now', new DateTimeZone('UTC'));
        }

        /**
         * @return int|null
         */
        public function getID(){
            return $this->id;
        }

        /**
         * @return DateTime
         */
        public function getModifiedUTC(){
            return $this->modifiedUTC;
        }

        /**
         * @return DateTime
         */
        public function getCreatedUTC(){
            return $this->createdUTC;
        }

        /**
         * @param array $properties
         * @return mixed
         */
        public static function create( array $properties = array() ){
            $instance = new self();
            $instance->setPropertiesFromArray( $properties );
            $instance->save();
            return $instance;
        }

        /**
         * Update the instance with the given properties
         * @param array $properties
         */
        public function update( array $properties = array() ){
            $this->setPropertiesFromArray( $properties );
            $this->save();
        }

        /**
         * Delete a record
         */
        public function delete(){
            $this->entityManager()->remove($this);
            $this->entityManager()->flush();
        }

        /**
         * Persist to the database
         * @return void
         */
        protected function save(){
            $this->entityManager()->persist( $this );
            $this->entityManager()->flush();
        }

        /**
         * @return \Doctrine\ORM\EntityManager
         */
        protected static function entityManager(){
            return Database::get()->getEntityManager();
        }
    }

}