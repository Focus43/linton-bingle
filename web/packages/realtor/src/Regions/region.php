<?php namespace Concrete\Package\Realtor\Src\Regions {

    use Loader;
    use File;

	class Region {
		
		
		const JACKSON       = 'jackson',
            TETON_VALLEY    = 'teton_valley',
            LINCOLN_COUNTY  = 'lincoln_county',
            OTHER_WYOMING   = 'other';

		
		protected $tableName,
				  $id,
				  $createdUTC,
				  $modifiedUTC;

		// helper for generating lists
		public static $parentRegions = array(
			self::JACKSON           => 'Jackson Hole, WY',
            self::TETON_VALLEY 	    => 'Teton Valley, ID',
			self::LINCOLN_COUNTY    => 'Lincoln County, WY',
            self::OTHER_WYOMING		=> 'Other Wyoming'
		);
		
		
		/**
		 * @param array $properties Set object property values with key => value array
		 */	
		public function __construct( array $properties = array() ){
			$this->setPropertiesFromArray($properties);
			$this->tableName = "Regions";
		}
		
		
		public function __toString(){
			return "{$this->name}, {$this->breed}";
		}
		
		/** @return int Get the dogID */
		public function getID(){ return $this->id; }
		/** @return string Date the object was first created */
		public function getDateCreated(){ return $this->createdUTC; }
		/** @return string Date the object was last modified */
		public function getDateModified(){ return $this->modifiedUTC; }
        /** @return string Get name */
        public function getName(){ return $this->name; }
        /** @return string Get query */
        public function getSearchQuery(){ return $this->searchQuery; }
        /** @return string Get picture ID (File object ID) */
        public function getImageID(){ return $this->imageID; }
        /** @return string Get short description */
        public function getDescription(){ return $this->description; }
        /** @return string Get parent region */
        public function getParentRegion(){ return $this->parentRegion; }
        
        


		/** @return string Get dog breed handle */
		public function getParentHandle($formatted = false){
			if( $formatted === true ){
				return ucwords(str_replace(array('_', '-', '/'), ' ', $this->parentRegion));
			}
			return $this->parentRegion;
		 }

        /** @return string Get protection level handle */
        public function getProtectionHandle($formatted = false){
            if( $formatted === true ){
                $protectionStr = "Level ";

                for ($i=0; $i<(int)$this->protectionHandle; $i++) {
                    $protectionStr .= "I";
                }

                return $protectionStr;
            }

            return $this->protectionHandle;
        }

        /** @return string Get price */
        public function getPrice($formatted = false){
            if( $formatted === true ){
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                return money_format('%i', $this->price);
            }

            return $this->price;
        }
		
		public function getPictureFileObj(){
			if( $this->_fileObj === null ){
				$this->_fileObj = File::getByID( (int)$this->imageID );
			}
			return $this->_fileObj;
		}


		
		/**
		 * Set properties of the current instance
		 * @param array $arr Pass in an array of key => values to set object properties
		 * @return void
		 */
		public function setPropertiesFromArray( array $properties = array() ) {
			foreach($properties as $key => $prop) {
				$this->{$key} = $prop;
			}
		}
		
		
		protected function persistable(){
			return array('name', 'description', 'imageID', 'searchQuery', 'parentRegion');
		}
		
		
		public function save(){
			if( $this->id >= 1 ){
				$fields		= $this->persistable();
				$updateStr  = 'modifiedUTC = UTC_TIMESTAMP()';
				$values		= array();
				foreach($fields AS $property){
					$updateStr .= ", {$property} = ?";
					$values[] = $this->{$property};
				}
				$values[] = $this->id;
				Loader::db()->Execute("UPDATE {$this->tableName} SET {$updateStr} WHERE id = ?", $values);
			}else{
				$db 		= Loader::db();
				$fields		= $this->persistable();
				$fieldNames = "createdUTC, modifiedUTC, " . implode(',', $fields);
				$fieldCount	= implode(',', array_fill(0, count($fields), '?'));
				$values		= array();
				foreach($fields AS $property){
					$values[] = $this->{$property};
				}
				$db->Execute("INSERT INTO {$this->tableName} ($fieldNames) VALUES (UTC_TIMESTAMP(), UTC_TIMESTAMP(), $fieldCount)", $values);
				$this->id	 = $db->Insert_ID();
			}
			
			return self::getByID( $this->id );
		}

		public static function getByID( $id ){
			$self = new self();
			$row = Loader::db()->GetRow("SELECT * FROM {$self->tableName} WHERE id = ?", array( (int)$id ));
			$self->setPropertiesFromArray($row);
			return $self;
		}
		
		
		/**
		 * Delete the record, and any attribute values associated w/ it
		 * @return void
		 */
		public function delete(){
			Loader::db()->Execute("DELETE FROM {$this->tableName} WHERE id = ?", array($this->id));
		}
		
	}
}