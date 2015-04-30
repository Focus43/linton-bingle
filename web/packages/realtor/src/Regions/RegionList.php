<?php namespace Concrete\Package\Realtor\Src\Regions {

    use \Concrete\Core\Search\Column\Set as DatabaseItemListColumnSet;
    use \Concrete\Core\Search\Column\Column as DatabaseItemListColumn;
    use \Concrete\Core\Legacy\DatabaseItemList;

	class RegionList extends DatabaseItemList {
		
		const DB_FRIENDLY_DATE = 'Y-m-d H:i:s';
		
		protected $autoSortColumns 	= array('createdUTC', 'modifiedUTC', 'name', 'parentRegion'),
				  $itemsPerPage		= 10;

		public function filterByKeywords($keywords) {
            $db = \Loader::db();
            $this->searchKeywords = $db->quote($keywords);
            $qkeywords = $db->quote('%' . $keywords . '%');
            $this->filter(false, "(name LIKE $qkeywords OR parentRegion LIKE $qkeywords)");
		}


		/**
		 * Filter by name\
		 * @param string Name
		 */
		public function filterByName( $name ){
            $name = \Loader::db()->quote('%'.$name.'%');
            $this->filter(false, "region.name LIKE $name");
        }

        /**
         * Filter by parent region
         * @param string parenRegion
         */
        public function filterByParent( $parentRegion ){
            $parentRegion = \Loader::db()->quote('%'.$parentRegion.'%');
            $this->filter(false, "parentRegion LIKE $parentRegion");
        }

		public function sortByName(){
			parent::sortBy('region.name', 'asc');
		}


		public function get( $itemsToGet = 100, $offset = 0 ){
            $personnel = array();
            $this->createQuery();
            $r = parent::get($itemsToGet, $offset);
            foreach($r AS $row){
                $personnel[] = Region::getByID( $row['id'] );
            }
            return $personnel;
        }


        public function getTotal(){
            $this->createQuery();
            return parent::getTotal();
        }


        protected function createQuery(){
            if( !$this->queryCreated ){
                $this->setBaseQuery();
                $this->queryCreated = true;
            }
        }

        public function setBaseQuery(){
            $queryStr = "SELECT * FROM Regions regions";
            $this->setQuery( $queryStr );
        }
//
	}


	class RegionColumnSet extends DatabaseItemListColumnSet {

		public function __construct(){
			$this->addColumn(new DatabaseItemListColumn('name', t('Name'), array('Concrete\Package\Realtor\Src\Regions\RegionColumnSet', 'getNameAsLast')));
			$this->addColumn(new DatabaseItemListColumn('parentRegion', t('Parent Region'), array('Concrete\Package\Realtor\Src\Regions\RegionColumnSet', 'getParentRegion')));
		}

		public function getNameAsLast( Region $regionObj ){
			$name = "{$regionObj->getName()}";
			return '<a href="'. \View::url('/dashboard/regions/detail/edit/', $regionObj->getID()).'">'.$name.'</a>';
		}

		public function getParentRegion( Region $regionObj ){
			return $regionObj->getParentRegion(true);
		}

		public function getCurrent(){
			return new self;
		}

	}
}

