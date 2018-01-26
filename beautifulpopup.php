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

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new Beautifulpopup();
        return self::$instance;
    }

    ################
    # INSTALLATION #
    ################

    public function install() {


        if (!BNPopup::createDatabase() || !BNTemplate::createDatabase())
            return false;

        if (!parent::install())
            return false;

        if (!$this->registerHook('footer') || !$this->registerHook('backOfficeHeader'))
            return false;

        return true;
    }

    public static function getVersionDir()
    {
        $version = explode('.', _PS_VERSION_);
        if ((int)$version[1] < 6)
            return ('1.5');
        return ('1.6');
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
