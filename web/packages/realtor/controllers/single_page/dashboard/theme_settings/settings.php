<?php
namespace Concrete\Package\Realtor\Controller\SinglePage\Dashboard\Portfolio {
    use \Concrete\Core\Page\Controller\DashboardPageController;
    use \Concrete\Package\Realtor\Src\ThemeProperties;
    use Loader;

    class ThemeSettings extends DashboardPageController {


        public function view( $id = null ) {
            $this->requireAsset('redactor');
            $this->requireAsset('core/file-manager');
            $this->addFooterItem('<script type="text/javascript">var CCM_EDITOR_SECURITY_TOKEN = \''.Loader::helper('validation/token')->generate('editor').'\'</script>');
        }

        public function save( $id = null ) { /** @var params Symfony\Component\HttpFoundation\ParameterBag */
            if ( $id == null ) {
                ThemeProperties::create($_POST);
            } else {
                $portfolio = ThemeProperties::getByID($id);
                $portfolio->update($_POST);
            }

            $this->redirect('/dashboard/theme_settings');
        }

//        public function delete( $id ) { /** @var $portfolio \Concrete\Package\Realtor\Src\ThemeProperties */
//            $portfolio = ThemeProperties::getByID($id);
//            $portfolio->delete();
//            $this->redirect('/dashboard/theme_settings');
//        }


    }
}