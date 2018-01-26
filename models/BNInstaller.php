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

class BNInstaller
{
    const SQL_INSTALL_PATH = 'data/install.sql';
    const SQL_INSERT_PATH = 'data/insert.sql';
    const CONF_XML_PATH = 'data/config.xml';


    protected static $instance = null;

    protected $xml;
    protected $mI;

    public static function getInstance($moduleInstance)
    {
        if (self::$instance === null)
            self::$instance = new BNInstaller($moduleInstance);
        return self::$instance;
    }

    public function __construct($moduleInstance)
    {
        $this->xml = simplexml_load_file(dirname(__FILE__).'/../'.self::CONF_XML_PATH);
        $this->mI = $moduleInstance;
    }

    ################
    # INSTALLATION #
    ################

    public function install()
    {

        if ($this->_installSql() !== true)
            return false;

        if ($this->_installTab() !== true)
            return false;

        return true;
    }

    public static function _insertSql()
    {

        $inputFile = dirname(__FILE__).'/../'.self::SQL_INSTALL_PATH;
        $query = '';

        // Open & read input
        if (($fdi = fopen($inputFile, 'r')) === false)
            return false;
        while (($line = fgets($fdi)) !== false)
            $query .= $line;

        // Replace DB prefix
        $query = str_replace('_DB_PREFIX_', _DB_PREFIX_, $query);
        $queries = preg_split('#;\s*[\r\n]+#', $query);

        // Execute SQL request
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

    protected function _installSql()
    {

        $inputFile = dirname(__FILE__).'/../'.self::SQL_INSTALL_PATH;
        $query = '';

        // Open & read input
        if (($fdi = fopen($inputFile, 'r')) === false)
            return false;
        while (($line = fgets($fdi)) !== false)
            $query .= $line;

        // Replace DB prefix
        $query = str_replace('_DB_PREFIX_', _DB_PREFIX_, $query);
        $queries = preg_split('#;\s*[\r\n]+#', $query);

        // Execute SQL request
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

    protected function _installTab()
    {
        $mainIdTab = 0;
        $i = 0;

        // Create tab for each tab found in XML configuration
        foreach ($this->xml->tabs->tab as $tab)
        {
            $i18n = array();
            foreach ($tab->langs->lang as $lang)
                $i18n[(string)$lang['iso']] = (string)$lang;
            $newTab = new Tab();
            foreach (Language::getLanguages(false /* active */) as $lang)
                if ($iso = Language::getIsoById($lang['id_lang']))
                    $newTab->name[$lang['id_lang']] = array_key_exists($iso, $i18n) ? $i18n[$iso] : current($i18n);
            $newTab->class_name = (string)$tab->class;
            $newTab->id_parent = (int)$tab['main'] ? 0 : $mainIdTab;
            $newTab->module = $this->mI->name;
            $newTab->add();

            if ((int)$tab['main'])
            {
                $mainIdTab = $newTab->id;
                if ((int)$tab['first'])
                {
                    $currentTabs = Tab::getTabs(1 /* id_lang */, $newTab->id_parent);
                    for ($i = count($currentTabs); $i; $i--)
                        $newTab->updatePosition(0 /* way */, $i - 1 /* position */);
                }
            }
        }
        return true;
    }

    #############
    # UNINSTALL #
    #############

    public function uninstall()
    {
        return true;
    }
}
