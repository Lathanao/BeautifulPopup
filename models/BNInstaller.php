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

class BNInstaller extends Module
{
    const SQL_INSTALL_PATH  = 'data/install.sql';
    const SQL_DROP_PATH     = 'data/drop.sql';
    const SQL_INSERT_PATH   = 'data/insert.sql';

    protected static $instance = null;

    protected $mI;

    public static function getInstance($moduleInstance)
    {
        if (self::$instance === null)
            self::$instance = new BNInstaller($moduleInstance);
        return self::$instance;
    }

    public function __construct($moduleInstance)
    {
        $this->module = $moduleInstance;
    }


    public function install()
    {
        if (!$this->runSql(self::SQL_INSTALL_PATH))
            return false;

        if (!$this->createTabs())
            return false;

        return true;
    }

    public function uninstall()
    {
        if (!$this->runSql(self::SQL_DROP_PATH))
            return false;


        if (!$this->dropTabs())
            $this->_errors[] = $this->l('Beautiful Popup solution');

        return true;
    }

    protected function runSql($file = null)
    {
        $inputFile = dirname(__FILE__).'/../'.self::SQL_INSTALL_PATH;
        $query = '';

        // Open & read input
        if (($fdi = fopen($inputFile, 'r')) === false)
            return false;
        while (($line = fgets($fdi)) !== false)
            $query .= $line;


        $query = str_replace('_DB_PREFIX_', _DB_PREFIX_, $query);
        $queries = preg_split('#;\s*[\r\n]+#', $query);

        foreach ($queries as $query)
        {
            $query = trim($query);
            if (!$query)
                continue;
            if (!Db::getInstance()->Execute($query))
                return false;
        }
        return true;
    }

    protected function createTabs()
    {
        $langs = Language::getLanguages();
        $PopupTabs = new Tab((int) Tab::getIdFromClassName('AdminBeautifulPopup'));
        $PopupTabs->class_name = 'AdminBeautifulPopup';
        $PopupTabs->module = '';
        $PopupTabs->id_parent = 0;
        foreach ($langs as $l) {
            $PopupTabs->name[$l['id_lang']] = 'Beautiful Popup';
        }

        $PopupTabs->save();

        $tabs = [
            [
                'class_name' => 'AdminPopup',
                'id_parent'  => $PopupTabs->id,
                'module'     => $this->module->name,
                'name'       => 'Manage Popup',
            ],
            [
                'class_name' => 'AdminTemplate',
                'id_parent'  => $PopupTabs->id,
                'module'     => $this->module->name,
                'name'       => 'Manage Template',
            ],
        ];

        foreach ($tabs as $tab) {
            $newTab = new Tab((int) Tab::getIdFromClassName($tab['class_name']));
            $newTab->class_name = $tab['class_name'];
            $newTab->id_parent = $tab['id_parent'];
            $newTab->module = $tab['module'];
            foreach ($langs as $lang) {
                $newTab->name[$lang['id_lang']] = $tab['name'];
            }

            if(!$newTab->save())
                $this->_errors[] = "Error in save tab: $newTab->class_name";
        }

        return true;
    }

    protected function dropTabs()
    {
        $tabs = [   ['class_name' => 'AdminBeautifulPopup'],
                    ['class_name' => 'AdminPopup'],
                    ['class_name' => 'AdminTemplate']];

        foreach ($tabs as $key => $tab)
        	  (new Tab((int) Tab::getIdFromClassName($tab['class_name'])))->delete();

        return true;
    }

}
