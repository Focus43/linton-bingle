<?php
namespace Concrete\Package\Realtor\Controller\SinglePage\Dashboard\ThemeSettings {
    use \Concrete\Core\Page\Controller\DashboardPageController;
    use Concrete\Package\Realtor\Controller as RealtorPackage;
    use Loader;

    class Settings extends DashboardPageController {

        public function on_start(){
            $this->set('formHelper', Loader::helper('form'));
        }
        public function view(){
            $this->set('pkgConfig', RealtorPackage::getPackageConfigObj());
//            var_dump(RealtorPackage::getPackageConfigObj()->get('theme.social_link_facebook'));exit;
        }
        public function success(){
            $this->set('message', 'Settings Saved!');
            $this->view();
        }
        public function save(){
            /** @var Config $config */
            $config = RealtorPackage::getPackageConfigObj();
            // Loop through data and save it
            foreach($_REQUEST AS $key => $value){
                $config->save('theme.' . $key, $value);
            }
            $this->redirect(\View::url('dashboard/theme_settings/settings/success'));
        }

//        public function view( $id = null ) {
//            $this->requireAsset('redactor');
//            $this->requireAsset('core/file-manager');
//            $this->addFooterItem('<script type="text/javascript">var CCM_EDITOR_SECURITY_TOKEN = \''.Loader::helper('validation/token')->generate('editor').'\'</script>');
//        }
//
//        public function save( $id = null ) { /** @var params Symfony\Component\HttpFoundation\ParameterBag */
//            if ( $id == null ) {
//                ThemeProperties::create($_POST);
//            } else {
//                $portfolio = ThemeProperties::getByID($id);
//                $portfolio->update($_POST);
//            }
//
//            $this->redirect('/dashboard/theme_settings');
//        }

//        public function delete( $id ) { /** @var $portfolio \Concrete\Package\Realtor\Src\ThemeProperties */
//            $portfolio = ThemeProperties::getByID($id);
//            $portfolio->delete();
//            $this->redirect('/dashboard/theme_settings');
//        }


    }
}

//class DashboardThemeSettingsSettingsController extends Controller {
//    public function on_start(){
//        $this->set('formHelper', Loader::helper('form'));
//    }
//    public function view(){
//        $this->set('pkgConfig', SunstatePackage::getPackageConfigObj());
//    }
//    public function success(){
//        $this->set('message', 'Settings Saved!');
//        $this->view();
//    }
//    public function save(){
//        /** @var Config $config */
//        $config = SunstatePackage::getPackageConfigObj();
//        // Loop through data and save it
//        foreach($_REQUEST AS $key => $value){
//            $config->save($key, $value);
//        }
//        $this->redirect(View::url('dashboard/theme_settings/settings/success'));
//    }
//}