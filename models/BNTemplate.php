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

class BNTemplate extends ObjectModel {

    public          $id_bn_template;
    public          $name;

    public          $width;
    public          $height;
    public          $openMethod;
    public          $closeMethod;
    public          $bgColor;
    public          $borderColor;
    public          $borderSize;
    public          $opacity;
    public          $padding;
    public          $date_add;
    public          $date_upd;


    public static $definition = array(
        'table' => 'bn_template',
        'primary' => 'id_bn_template',
        'fields' => array(
            'id_bn_template' => array('type' => self::TYPE_INT,    'validate' => 'isUnsignedId', 'size' => 11,   'db_type' => 'INT(11)'),
            'name' =>           array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 128, 'db_type' => 'VARCHAR(255)', 'required' => true),
            'width' =>          array('type' => self::TYPE_INT,    'validate' => 'isInt', 'size' => 3,           'db_type' => 'INT(11)'),
            'height' =>         array('type' => self::TYPE_INT,    'validate' => 'isInt', 'size' => 3,           'db_type' => 'INT(11)'),
            'openMethod' =>     array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 128, 'db_type' => 'VARCHAR(255)'),
            'closeMethod' =>    array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 128, 'db_type' => 'VARCHAR(255)'),
            'bgColor' =>        array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 45,  'db_type' => 'VARCHAR(255)'),
            'borderColor' =>    array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 45,  'db_type' => 'VARCHAR(255)'),
            'borderSize' =>     array('type' => self::TYPE_INT,    'validate' => 'isInt', 'size' => 2,           'db_type' => 'INT(11)'),
            'opacity' =>        array('type' => self::TYPE_FLOAT,  'validate' => 'isFloat', 'size' => 3,         'db_type' => 'FLOAT'),
            'padding' =>        array('type' => self::TYPE_INT,    'validate' => 'isInt', 'size' => 2,           'db_type' => 'INT(11)'),
            'date_add' =>       array('type' => self::TYPE_DATE,   'validate' => 'isDate',                       'db_type' => 'DATETIME', 'default' => '1970-01-01 00:00:00'),
            'date_upd' =>       array('type' => self::TYPE_DATE,   'validate' => 'isDate',                       'db_type' => 'DATETIME', 'default' => '1970-01-01 00:00:00'),
        ),
    );


    public static function getAllTemplates() {

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'bn_template`');

    }
}
