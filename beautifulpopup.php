<?php
/****************************************************************//**
 *          Beautiful Popup Notification or Prestashop
 *          Add some beautiful popup, where and when you want on your shop
 *
 *          @category       Module / Front
 *          @author         Lathanao <Lathanaogmail.com>
 *          @copyright      2017 Lathanao
 *          @version        1.0
  *         @license        Commercial license see README.md
********************************************************************/

include_once(dirname(__FILE__).'/models/BNAutoLoad.php');
spl_autoload_register(array(BNAutoLoad::getInstance(), 'load'));

class Beautifulpopup extends Module {

    protected static $instance = null;

    public function __construct()
    {
        $this->name = 'Beautifulpopup';
        $this->version = '1.0';
        $this->tab = 'Block';
        $this->author = "Lathanao";
        $this->year = '2017';
        $this->ps_versions_compliancy['min'] = '1.6.0.1';

        parent::__construct();

        $this->displayName = $this->l('Beautiful Popup solution');
        $this->description = $this->l('Add some beautifull popups, where and when you want on your shop');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');

        $this->file = __FILE__;
    }


    ################
    # INSTALLATION #
    ################

    public function install() {

        // if (!BNPopup::createDatabase() || !BNTemplate::createDatabase())
        //     return false;

        if (!$this->createPopupTabs())
            return false;

        if (!parent::install())
            return false;

        if (!$this->registerHook('footer') || !$this->registerHook('backOfficeHeader'))
            return false;

        return true;
    }


    public function uninstall() {

        if (!$this->removePopupTabs())
            return false;

        if (!parent::uninstall())
            return false;

        return true;
    }

    protected function createPopupTabs()
    {
        $langs = Language::getLanguages();
        $PopupTabs = new Tab((int) Tab::getIdFromClassName('AdminBeautifulPopup'));
        $PopupTabs->class_name = 'AdminBeautifulPopup';
        $PopupTabs->module = '';
        $PopupTabs->id_parent = 0;
        foreach ($langs as $l) {
            $PopupTabs->name[$l['id_lang']] = $this->l('Beautiful Popup');
        }

        $PopupTabs->save();

        $tabs = [
            [
                'class_name' => 'AdminPopup',
                'id_parent'  => $PopupTabs->id,
                'module'     => $this->name,
                'name'       => 'Manage Popup',
            ],
            [
                'class_name' => 'AdminTemplate',
                'id_parent'  => $PopupTabs->id,
                'module'     => $this->name,
                'name'       => 'Manage Template',
            ],
        ];

        foreach ($tabs as $tab) {
            $newTab = new Tab((int) Tab::getIdFromClassName($tab['class_name']));
            $newTab->class_name = $tab['class_name'];
            $newTab->id_parent = $tab['id_parent'];
            $newTab->module = $tab['module'];
            foreach ($langs as $l) {
                $newTab->name[$l['id_lang']] = $this->l($tab['name']);
            }

            $newTab->save();
        }

        return true;
    }

    protected function removePopupTabs()
    {
        $tabs = [   ['class_name' => 'AdminBeautifulPopup'],
                    ['class_name' => 'AdminPopup'],
                    ['class_name' => 'AdminTemplate']];

        foreach ($tabs as $key => $tab)
        	  (new Tab((int) Tab::getIdFromClassName($tab['class_name'])))->delete();

        return true;
    }

    public function hookbackOfficeHeader() {

        $this->context->controller->addCSS(($this->_path).'css/header.css', 'all');
    }


    public function hookFooter() {

        global $cookie;

        if (!Tools::isSubmit('admin_preview_popup')) {

            $popups = BNPopup::getAllPopup();
            $context = Context::getContext();
            $page = Tools::getValue('controller');
            $idCustomer = $context->customer->id;
            $nbOrder = Order::getCustomerNbOrders($idCustomer);

            foreach($popups as $key => $popup) {

                $cookieName = preg_replace('/[^A-Za-z]/', "", $popup->name);
                $cookie = new Cookie($cookieName);

                if (!$cookie->__isset($cookieName))
                    $cookie->__set($cookieName, 0);

                if ($popup->nb_view <= $cookie->__get($cookieName))   // 2. If allready see
                    continue;
                if ($popup->id_bn_page == 2 && $page != "index")   // 2. If right page
                    continue;
                if ($popup->id_bn_page == 3 && $page != "product")   // 2. If right page
                    continue;
                if ($popup->id_bn_page == 4 && $page != "cms")   // 2. If right page
                    continue;
                if ($popup->id_bn_peaple == 2 && !empty($idCustomer)) // 4. Only guest
                    continue;
                if ($popup->id_bn_peaple == 3 && empty($idCustomer)) // 5. Only all registered users
                    continue;
                if ($popup->id_bn_peaple == 4 && (empty($idCustomer) || $nbOrder == 0)) // 6. Only registered users who made a order allready
                    continue;
                if ($popup->id_bn_peaple == 5 && (empty($idCustomer) || $nbOrder != 0)) // 7. Only registered users who never made any order
                    continue;

                $cookie->__set($cookieName, (1 + $cookie->__get($cookieName)));
                return $this->renderPopup($popup);
            }

        } else {

            $popup = new BNPopup(Tools::getValue('admin_preview_popup'));
            return $this->renderPopup($popup);
        }
    }


    public function renderPopup($popup) {

        global $smarty;
        $template = new BNTemplate($popup->id_bn_template);
        $smarty->assign("popup", $popup);
        $smarty->assign("template", $template);
        $this->context->controller->addjqueryPlugin('fancybox');
        return ($this->display(__FILE__, 'views/templates/front/popup.tpl'));
    }
}
