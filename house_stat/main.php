<?php
/*
 * Created on 2013-4-25
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 //set constant variable 
if (!defined('MODULE_PATH')) {
    define('MODULE_PATH', ROOT_PATH . '/module');
}

if (!defined('COMMON_PATH')) {
	define('COMMON_PATH', ROOT_PATH . '/common');
}

if (!defined('LOG_PATH')) {
        define('LOG_PATH', ROOT_PATH . '/logs');
}

if (!defined('CONFIG_PATH')) {
        define('CONFIG_PATH', ROOT_PATH . '/config');
}

if (!defined('DATA_PATH')) {
       define('DATA_PATH', ROOT_PATH . '/data');
}

//add dir into $include_path
$include_path = get_include_path() . PATH_SEPARATOR . MODULE_PATH . PATH_SEPARATOR . LOG_PATH . PATH_SEPARATOR . DATA_PATH ;

set_include_path($include_path);
