<?php
/**
 * Initializes the app
 * Include below code to every cron job
 * This file is intended to run on the shell
 * Include path is set for a Zend Framework and library folders
 */
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../app') );
set_include_path(implode(PATH_SEPARATOR, array(realpath(APPLICATION_PATH . '/../library'), realpath('/usr/local/zend/share/ZendFramework/library/'), get_include_path(), )));

chdir(APPLICATION_PATH);
include 'env.php';

require_once 'Zend/Application.php';  
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/config.xml');

$application->bootstrap('config')->bootstrap('db')->bootstrap('cache')->bootstrap('logger')->bootstrap('autoload');

$config = vkNgine_Config::getSystemConfig();

$logger = Zend_Registry::get('logger');