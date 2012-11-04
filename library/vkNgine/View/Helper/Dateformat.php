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
class vkNgine_View_Helper_Dateformat extends Zend_View_Helper_HtmlElement
{
    /**
     * formats a given date with the specific options
     * 
     * @param string $date
     * @param Zend_Date const $format
     * @return string
     */
    public function dateFormat($date, $format)
    {
    	if (!empty($date)) {
	  		$date = new Zend_Date($date, Zend_Date::ISO_8601, vkNgine_Config::getSystemConfig()->language->locale);
    		return $date->toString($format);
    	}
    	
    	return Zend_Registry::get('t')->_('An error occurred during formatting the given date');
    }
}