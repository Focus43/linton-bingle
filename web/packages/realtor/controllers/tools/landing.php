<?php namespace Concrete\Package\Realtor\Controller\Tools {

    use Page;
    use PageList;
    use Controller;

    class Landing extends Controller {

        public function getPageListForId( $id, $multi = true ) {

            $multi = ($multi == "multi") ? true : false;

            $parentIDs = $multi ? Page::getById($id)->getCollectionChildrenArray($oneLevelOnly = true) : array($id);
            $pageList = new PageList();
            $pageList->filterByParentID($parentIDs);
            $pageList->sortByPublicDateDescending();
            $pageObjs = $pageList->get();
            $pages = array();

            foreach ( $pageObjs as $pg ) {
                $p = new \stdClass;
                $p->path = $pg->cPath;
                $p->name = $pg->vObj->cvName;
                $p->description = $pg->vObj->cvDescription;
                $p->iconPath = ($pg->getAttribute('page_image')) ? $pg->getAttribute('page_image')->getRelativePath() : REALTOR_IMAGE_PATH . 'nav_placeholder.jpg';

                array_push($pages, $p);
            }

            $respObj = new \stdClass;
            $respObj->code = 1;
            $respObj->pages = $pages;
            echo json_encode($respObj);
            exit;
        }

    }
}