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

class AdminTemplateController extends ModuleAdminController {

    public function __construct() {

        $this->bootstrap = true;
        $this->table = 'bn_template';
        $this->className = 'BNTemplate';
        $this->tpl_list_vars['title'] = $this->l('Manage your popup templates');

        $this->fields_list = array(
            'id_bn_template' => array(
                'title' => $this->l('ID'),
                'width' => 40,
                'align' => 'center',
                'class' => 'fixed-width-md',
            ),
            'name' => array(
                'title' => $this->l('name'),
                'width' => 500,
                'align' => 'left',
                'class' => 'fixed-width-md'
            ),
            'width' => array(
                'title' => $this->l('width'),
                'width' => 100,
                'align' => 'center',
                'class' => 'fixed-width-md',
            ),
            'height' => array(
                'title' => $this->l('height'),
                'width' => 100,
                'align' => 'center',
                'class' => 'fixed-width-md',
            ),
            'bgColor' => array(
                'title' => $this->l('Background Color'),
                'width' => 100,
                'align' => 'center',
                'class' => 'fixed-width-md',
                'callback' => 'getColor',
            ),
            'borderColor' => array(
                'title' => $this->l('Border Color'),
                'width' => 100,
                'align' => 'center',
                'class' => 'fixed-width-md',
                'callback' => 'getColor',
            ),
            'borderColor' => array(
                'title' => $this->l('Border Color'),
                'width' => 100,
                'align' => 'center',
                'class' => 'fixed-width-md',
                'callback' => 'getColor',
            ),
        );

        parent::__construct();
    }

    public function renderForm() {

        $this->fields_form = array(
            'legend' => array(
            'title' => $this->l('Template popup manager'),
            ),
            'input' => array(
            	array(
                    'name' => 'name',
                    'type' => 'text',
                    'label' => $this->l('Title'),
                    'desc' => $this->l('Add here the title (ex: Home popup for new customer).')
                ),
           		array(
                    'name' => 'width',
                    'type' => 'text',
                    'label' => $this->l('Width'),
                    'desc' => $this->l('Add here the width (ex: 40).')
                ),
	            array(
                    'name' => 'height',
                    'type' => 'text',
                    'label' => $this->l('Height'),
                    'desc' => $this->l('Add here the height (ex: 40).')
                ),
            	array(
                    'name' => 'bgColor',
                    'type' => 'text',
                    'label' => $this->l('Background Color'),
                    'desc' => $this->l('Add here the background color.'),
                    'class' => 'jscolor'
                ),
            	array(
                    'name' => 'borderColor',
                    'type' => 'text',
                    'label' => $this->l('Border Color'),
                    'desc' => $this->l('Add here the border color.'),
                    'class' => 'jscolor'
                ),
            	array(
                    'name' => 'borderSize',
                    'type' => 'text',
                    'label' => $this->l('Border Size'),
                    'desc' => $this->l('Add here the border size (ex: 2).')
                ),
            	array(
                    'name' => 'opacity',
                    'type' => 'text',
                    'label' => $this->l('Opacity'),
                    'desc' => $this->l('Add here the opacity (ex: from 0.0 to 1).')
                ),
            	array(
                    'name' => 'padding',
                    'type' => 'text',
                    'label' => $this->l('Padding'),
                    'desc' => $this->l('Add here the border padding (ex: 10).')
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save')
            )
        );
        return parent::renderForm();
    }

    /**
     * Display button at the end of table
     *
     */
    public function renderList() {

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        return parent::renderList();
    }

    /**
     * Add js and css on the controller page
     *
     */
    public function setMedia() {

        parent::setMedia();
        $this->addJqueryUI('ui.datepicker');
    }

    /**
     * Add the  'new popup' on the controller page
     *
     */
    public function initPageHeaderToolbar() {

        if (!Tools::isSubmit('addbn_template') && !Tools::isSubmit('updatebn_template')) {

            $this->page_header_toolbar_btn['new_product'] = array(
                'href' => self::$currentIndex.'&addbn_template&token='.$this->token,
                'desc' => $this->l('Add Template', null, null, false),
                'icon' => 'process-icon-new'
            );
        }

        return parent::initPageHeaderToolbar();
    }

    static public function getColor($corlor) {

        return "<span style='background-color:#$corlor; color:white; border-radius:3px 3px 3px 3px; font-size:11px; padding: 2px 5px'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>";
    }
}
