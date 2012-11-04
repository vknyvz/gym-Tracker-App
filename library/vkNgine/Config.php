<?php
/**
 * vkNgine3 Admin System
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the new BSD license.
 *
 * @category    core
 * @package     vkNgine3
 * @copyright   Copyright (c) 2011 Volkan Yavuz (http://www.vknyvz.com)
 */
class vkNgine_Config 
{
    /**
     * @static
     * @return Zend_Config
     */
    public static function getSystemConfig () 
    {
        $config = null;

        try {
            $config = Zend_Registry::get("config");
        }
        catch (Exception $e) {
            try {
                $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/config.xml', APPLICATION_ENV);
                self::setSystemConfig($config);
            }
            catch (Exception $e) {
            }
        }

        return $config;
    }

    /**
     * @static
     * @param Zend_Config $config
     * @return void
     */
    public static function setSystemConfig(Zend_Config $config)
    {
        Zend_Registry::set('config', $config);   
    }
    
    /**
     * @static
     * @param string $environment
     * @return void
     */
    public static function getConfigByEnvironment($environment)
    {
    	return new Zend_Config_Xml(APPLICATION_PATH . '/configs/config.xml', $environment);
    }
    
}
