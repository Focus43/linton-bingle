<?php namespace Concrete\Package\Realtor\Controller\Tools {

    use Controller;
    use Concrete\Package\Realtor\Src\Regions\Region;

    class Regions extends Controller {

        public function delete($id){
            $personnelObj = Region::getByID($id);
            $personnelObj->delete();

            echo json_encode( (object) array(
                'code'	=> 1,
                'msg'	=> 'Success'
            ));
        }
    }
}