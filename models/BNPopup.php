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

class BNPopup extends ObjectModel {

    public          $id_bn_popup;
    public          $id_bn_template;
    public          $id_bn_page;
    public          $id_bn_peaple;
    public          $name;
    public          $long_content;
    public          $css;
    public          $catch_email;
    public          $active;
    public          $timer;
    public          $nb_view;
    public          $nb_page_before_view;
    public          $expiration;
    public          $validity;
    public          $date_add;
    public          $date_upd;


    public static $definition = array(
        'table' => 'bn_popup',
        'primary' => 'id_bn_popup',
        'fields' => array(
            'id_bn_popup' =>        array('type' => self::TYPE_INT,  'validate' => 'isUnsignedId', 'size' => 11,     'db_type' => 'INT(11)'),
            'id_bn_template' =>     array('type' => self::TYPE_INT,  'validate' => 'isUnsignedId', 'size' => 11,     'db_type' => 'INT(11)'),
            'id_bn_page' =>         array('type' => self::TYPE_INT,  'validate' => 'isUnsignedId', 'size' => 11,     'db_type' => 'INT(11)'),
            'id_bn_peaple' =>       array('type' => self::TYPE_INT,  'validate' => 'isUnsignedId', 'size' => 4,      'db_type' => 'INT(11)'),
            'name' =>               array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 128, 'db_type' => 'VARCHAR(255)'),
            'long_content' =>       array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml',                    'db_type' => 'TEXT'),
            'css' =>                array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml',                    'db_type' => 'TEXT'),
            'catch_email' =>        array('type' => self::TYPE_BOOL, 'validate' => 'isBool',                         'db_type' => 'INT(11)'),
            'active' =>             array('type' => self::TYPE_BOOL, 'validate' => 'isBool',                         'db_type' => 'INT(11)'),
            'timer' =>              array('type' => self::TYPE_INT,  'validate' => 'isInt', 'size' => 11,            'db_type' => 'INT(11)'),
            'nb_view' =>            array('type' => self::TYPE_INT,  'validate' => 'isInt', 'size' => 11,            'db_type' => 'INT(11)'),
            'nb_page_before_view' =>array('type' => self::TYPE_INT,  'validate' => 'isInt', 'size' => 11,            'db_type' => 'INT(11)'),
            'expiration' =>         array('type' => self::TYPE_INT,  'validate' => 'isUnsignedId', 'size' => 1,      'db_type' => 'INT(11)'),
            'validity' =>           array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat',                   'db_type' => 'DATETIME', 'default' => '1970-01-01 00:00:00'),
            'date_add' =>           array('type' => self::TYPE_DATE, 'validate' => 'isDate',                         'db_type' => 'DATETIME', 'default' => '1970-01-01 00:00:00'),
            'date_upd' =>           array('type' => self::TYPE_DATE, 'validate' => 'isDate',                         'db_type' => 'DATETIME', 'default' => '1970-01-01 00:00:00'),
        ),
    );


    public static function getAllPopup() {

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT *
            FROM `'._DB_PREFIX_.'bn_popup`
            WHERE `active`= 1
            AND `validity` > NOW();');

        if (!$result)
            return array();
        return ObjectModel::hydrateCollection('BNPopup', $result);
    }

    public static function createDatabase($className = null)
    {
        $success = true;

        if (empty($className)) {
            $className = get_called_class();
        }

        $definition = static::getDefinition($className);
        $sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.bqSQL($definition['table']).'` (';
        $sql .= '`'.$definition['primary'].'` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,';
        foreach ($definition['fields'] as $fieldName => $field) {
            if ($fieldName === $definition['primary']) {
                continue;
            }
            if (isset($field['lang']) && $field['lang'] || isset($field['shop']) && $field['shop']) {
                continue;
            }
            $sql .= '`'.$fieldName.'` '.$field['db_type'];
            if (isset($field['required'])) {
                $sql .= ' NOT NULL';
            }
            if (isset($field['default'])) {
                $sql .= ' DEFAULT \''.$field['default'].'\'';
            }
            $sql .= ',';
        }
        $sql = trim($sql, ',');
        $sql .= ')';

        try {
            $success &= \Db::getInstance()->execute($sql);
        } catch (PrestaShopDatabaseException $exception) {
            static::dropDatabase($className);

            return false;
        }

        if (isset($definition['multilang']) && $definition['multilang']
            || isset($definition['multilang_shop']) && $definition['multilang_shop']) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.bqSQL($definition['table']).'_lang` (';
            $sql .= '`'.$definition['primary'].'` INT(11) UNSIGNED NOT NULL,';
            foreach ($definition['fields'] as $fieldName => $field) {
                if ($fieldName === $definition['primary'] || !(isset($field['lang']) && $field['lang'])) {
                    continue;
                }
                $sql .= '`'.$fieldName.'` '.$field['db_type'];
                if (isset($field['required'])) {
                    $sql .= ' NOT NULL';
                }
                if (isset($field['default'])) {
                    $sql .= ' DEFAULT \''.$field['default'].'\'';
                }
                $sql .= ',';
            }

            // Lang field
            $sql .= '`id_lang` INT(11) NOT NULL,';

            if (isset($definition['multilang_shop']) && $definition['multilang_shop']) {
                $sql .= '`id_shop` INT(11) NOT NULL,';
            }

            // Primary key
            $sql .= 'PRIMARY KEY (`'.bqSQL($definition['primary']).'`, `id_lang`)';

            $sql .= ')';

            try {
                $success &= \Db::getInstance()->execute($sql);
            } catch (PrestaShopDatabaseException $exception) {
                static::dropDatabase($className);

                return false;
            }
        }

        if (isset($definition['multishop']) && $definition['multishop']
            || isset($definition['multilang_shop']) && $definition['multilang_shop']) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.bqSQL($definition['table']).'_shop` (';
            $sql .= '`'.$definition['primary'].'` INT(11) UNSIGNED NOT NULL,';
            foreach ($definition['fields'] as $fieldName => $field) {
                if ($fieldName === $definition['primary'] || !(isset($field['shop']) && $field['shop'])) {
                    continue;
                }
                $sql .= '`'.$fieldName.'` '.$field['db_type'];
                if (isset($field['required'])) {
                    $sql .= ' NOT NULL';
                }
                if (isset($field['default'])) {
                    $sql .= ' DEFAULT \''.$field['default'].'\'';
                }
                $sql .= ',';
            }

            // Shop field
            $sql .= '`id_shop` INT(11) NOT NULL,';

            // Primary key
            $sql .= 'PRIMARY KEY (`'.bqSQL($definition['primary']).'`, `id_shop`)';

            $sql .= ')';

            try {
                $success &= \Db::getInstance()->execute($sql);
            } catch (PrestaShopDatabaseException $exception) {
                static::dropDatabase($className);

                return false;
            }
        }

        return $success;
    }

    public static function dropDatabase($className = null)
    {
        $success = true;
        if (empty($className)) {
            $className = get_called_class();
        }

        $definition = \ObjectModel::getDefinition($className);

        $success &= \Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.bqSQL($definition['table']).'`');

        if (isset($definition['multilang']) && $definition['multilang']
            || isset($definition['multilang_shop']) && $definition['multilang_shop']) {
            $success &= \Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.bqSQL($definition['table']).'_lang`');
        }

        if (isset($definition['multishop']) && $definition['multishop']
            || isset($definition['multilang_shop']) && $definition['multilang_shop']) {
            $success &= \Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.bqSQL($definition['table']).'_shop`');
        }

        return $success;
    }

}
