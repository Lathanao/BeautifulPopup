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


class AdminPopupController extends ModuleAdminController {

    public function __construct() {

        $this->bootstrap = true;
        $this->table = 'bn_popup';
        $this->className = 'BNpopup';

        parent::__construct();

        $this->tpl_list_vars['icon'] = 'icon-folder-close';
        $this->tpl_list_vars['title'] = $this->l('Manage your popup');

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            )
        );

        $this->fields_list = array(
            'id_bn_popup' => array(
                'title' => $this->l('ID'),
                'width' => 40,
                'align' => 'left',
                'class' => 'fixed-width-xs',
            ),
            'name' => array(
                'title' => $this->l('Name'),
                'width' => 300,
                'align' => 'left',
                'class' => 'fixed-width-lg',
            ),
            'id_bn_peaple' => array(
                'title' => $this->l('Who'),
                'width' => 200,
                'align' => 'center',
                'class' => 'fixed-width-md',
                'callback' => 'getNamePeaple',
            ),
            'id_bn_page' => array(
                'title' => $this->l('Where'),
                'width' => 150,
                'align' => 'center',
                'class' => 'fixed-width-md',
                'callback' => 'getNamePage',
            ),
           'id_bn_template' => array(
                'title' => $this->l('Template'),
                'width' => 100,
                'align' => 'center',
                'class' => 'fixed-width-md',
                'callback' => 'getNameTemplate',
            ),
            'timer' => array(
                'title' => $this->l('Timer'),
                'width' => 100,
                'align' => 'center',
                'class' => 'fixed-width-md',
            ),
            'active' => array(
                'title' => $this->l('Active'),
                'active' => 'status',
                'filter_key' => '!active',
                'align' => 'center',
                'type' => 'bool',
                'width' => 30,
                'class' => 'fixed-width-md',
                'orderby' => false
            ),
            'validity' => array(
                'title' => $this->l('Validity'),
                'width' => 100,
                'align' => 'center',
                'class' => 'fixed-width-md',
                'callback' => 'colorDateIssue',
            ),
        );
    }


    /**
     * Display form for create or update popup
     *
     */
    public function renderForm() {

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Blog Category'),
            ),
            'input' => array(
            	array(
                    'name'  => 'name',
                    'type'  => 'text',
                    'label' => $this->l('Title'),
                    'desc'  => $this->l('Add here the category title (ex: Home popup for new customer).')
                ),
                array(
                    'name'  => 'long_content',
                    'type'  => 'textarea',
                    'rows'  => 10,
                    'cols'  => 62,
                    'label' => $this->l('Popup content'),
                    'desc'  => $this->l('Add here the popup HTML content.')
                ),
                array(
                    'name'  => 'css',
                    'type'  => 'textarea',
                    'rows'  => 10,
                    'cols'  => 62,
                    'label' => $this->l('CSS'),
                    'desc'  => $this->l('Add your CSS (optional).')
                ),
                array(
                    'name'  => 'id_bn_peaple',
                    'type'  => 'select',
                    'label' => $this->l('Who can see the popup ?'),
                    'desc'  => $this->l('Select who can this popup (everyone by default).'),
                    'options' => array(
                        'query' => Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'bn_peaple`'),
                        'id'    => 'id_bn_peaple',
                        'name'  => 'name'
                    ),
                ),
                array(
                    'name'  => 'id_bn_page',
                    'type'  => 'select',
                    'label' => $this->l('Where to show the popup'),
                    'desc'  => $this->l('Select the page where to show this popup (only on home page or product should be better than everywhere).'),
                    'options' => array(
                        'query' => Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'bn_page`'),
                        'id'    => 'id_bn_page',
                        'name'  => 'name'
                    ),
                ),
                array(
                    'type'  => 'switch',
                    'label' => $this->l('Displayed'),
                    'desc'  => $this->l('Display or hide this popup.'),
                    'name'  => 'active',
                    'required'  => false,
                    'is_bool'   => true,
                    'values'    => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'name'  => 'timer',
                    'type'  => 'text',
                    'label' => $this->l('Delay before display the popup'),
                    'desc'  => $this->l('Choose the delay before display the popup (in milliseconde, 500 by default).')
                ),
                array(
                    'name'  => 'nb_view',
                    'type'  => 'text',
                    'label' => $this->l('Number of views maximum'),
                    'desc'  => $this->l('Choose here how many time a customer can see this popup (1 by default).')
                ),
                array(
                    'name'  => 'validity',
                    'type'  => 'date',
                    'label' => $this->l('Validity date'),
                    'desc'  => $this->l('Choose here the limit validity date of your popup (ex: 25 dec. for a christmas popup).')
                ),
                array(
                    'name'  => 'id_bn_template',
                    'type'  => 'select',
                    'label' => $this->l('Popup template'),
                    'desc'  => $this->l('Select the template for this popup (everyone by default).'),
                    'options' => array(
                        'query' => Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'bn_template`'),
                        'id'    => 'id_bn_template',
                        'name'  => 'name'
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save')
            ),
            'buttons' => array(
                'save_and_preview' => array(
                    'name' => 'previewpopup',
                    'type' => 'submit',
                    'title' => $this->l('Save and preview'),
                    'class' => 'btn btn-default pull-right',
                    'icon' => 'process-icon-preview'
                ),
                'save_and_stay' => array(
                    'name' => 'savenstaypopup',
                    'type' => 'submit',
                    'title' => $this->l('Save and stay'),
                    'class' => 'btn btn-default pull-right',
                    'icon' => 'process-icon-savenstay'
                )
            )
        );


        $this->context->smarty->assign('url_prev', Tools::getShopDomain(true).'?admin_preview_popup='.Tools::getValue('id_bn_popup'));
        $this->context->smarty->display(_PS_MODULE_DIR_.$this->module->name.'/views/templates/admin/content.tpl');

        return parent::renderForm();
    }

    /**
     * Trick s for save object, before redirect for preview or stay stetement
     * @see '&url_preview=1' works with /views/tempalte/admin/content.tpl
     */
    public function postProcess() {

        if (Tools::isSubmit('previewpopup')) {
            parent::postProcess();
            Tools::redirectAdmin(self::$currentIndex.'&id_bn_popup='.(int)Tools::getValue('id_bn_popup').'&updatebn_popup&token='.Tools::getAdminTokenLite('AdminPopup').'&url_preview=1');
        }

        if (Tools::isSubmit('savenstaypopup')) {
            parent::postProcess();
            Tools::redirectAdmin(self::$currentIndex.'&id_bn_popup='.(int)Tools::getValue('id_bn_popup').'&updatebn_popup&token='.Tools::getAdminTokenLite('AdminPopup'));
        }
        parent::postProcess();
    }

    /**
     * Display button at the end of table on page controller
     *
     */
    public function renderList() {

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        return parent::renderList();
    }

    /**
     * Add js and css on the page controller
     *
     */
    public function setMedia() {

        parent::setMedia();
        $this->addJS(_PS_MODULE_DIR_.$this->module->name.'/js/tinyLoader.js');
        $this->addJS(_PS_MODULE_DIR_.$this->module->name.'/js/addCssAdmin.js');

        $this->addJqueryUI('ui.datepicker');
    }

    /**
     * Add the  'new popup' on the page controller
     *
     */
    public function initPageHeaderToolbar() {

        if (!Tools::isSubmit('addbn_popup') && !Tools::isSubmit('updatebn_popup')) {

            $this->page_header_toolbar_btn['new_product'] = array(
                'href' => self::$currentIndex.'&addbn_popup&token='.$this->token,
                'desc' => $this->l('Add Popup', null, null, false),
                'icon' => 'process-icon-new'
            );
        }
        return parent::initPageHeaderToolbar();
    }

    ////////////////////////////////////////////
    //          STATIC METHODE
    ////////////////////////////////////////////

    /**
     * Color result
     * @see __construct(), callback
     */
    static public function colorDateIssue($validity) {

        $today = strtotime(date('Y-m-d'));
        $validityStr = strtotime($validity);

        if ($today - $validityStr > 0)
            $color = '#eab3b7';
        else
            $color = '#92d097';
        return "<span style='background-color:".$color."; color:white; border-radius:3px 3px 3px 3px; font-size:11px; padding: 2px 5px'>".$validity."</span>";
    }

    /**
     * Color peaple name for display on controller page
     * @see __construct(), callback
     */
    static public function getNamePeaple($id_peaple) {

        $peaples = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'bn_peaple`');
        foreach ($peaples as $value)
            if($value['id_bn_peaple'] == $id_peaple)
                return $value['name'];
        return "<span style='background-color:#eab3b7; color:white; border-radius:3px 3px 3px 3px; font-size:11px; padding: 2px 5px'>May be no one ?</span>";
    }

    /**
     * Color page name for display on controller page
     * @see __construct(), callback
     */
    static public function getNamePage($id_page) {

        $pages = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'bn_page`');
        foreach ($pages as $value)
            if($value['id_bn_page'] == $id_page)
                return $value['name'];
        return "<span style='background-color:#eab3b7; color:white; border-radius:3px 3px 3px 3px; font-size:11px; padding: 2px 5px'>May be nowhere ?</span>";
    }

    /**
     * Color template name for display on controller page
     * @see __construct(), callback
     */
    static public function getNameTemplate($id_template) {

        $template = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'bn_template`');
        foreach ($template as $value)
            if($value['id_bn_template'] == $id_template)
                return $value['name'];
        return "<span style='background-color:#eab3b7; color:white; border-radius:3px 3px 3px 3px; font-size:11px; padding: 2px 5px'>No template ?</span>";
    }

}
