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

class BNAutoLoad
{
    protected static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new BNAutoLoad();
        return self::$instance;
    }

    public function load($classname)
    {
        $currentDir = dirname(__FILE__);
        $path = array(
            $currentDir, /* models */
            $currentDir.'/../controllers/admin/',
            $currentDir.'/../controllers/front/'
        );

        foreach ($path as $dir)
        {
/*            if (file_exists($dir.'/'.$classname.'.php'))
                Tools::p($dir.'/'.$classname.'.php');
            elseif (file_exists($dir.'/'.strtolower($classname).'.php'))
                Tools::p($dir.'/'.strtolower($classname).'.php');*/

            if (file_exists($dir.'/'.$classname.'.php'))
                require_once($dir.'/'.$classname.'.php');
            elseif (file_exists($dir.'/'.strtolower($classname).'.php'))
                require_once($dir.'/'.strtolower($classname).'.php');
        }

    }
}
