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
class vkNgine_View_Helper_Plural extends Zend_View_Helper_HtmlElement
{
    public function plural($number, $singular, $plural = null)
    {    	
    	$plural = $plural ? $plural : $singular . 's';

    	if ($number == 0)
    	{
    		return 'No ' . $plural;
    	}
    	elseif ($number == 1)
    	{
    		if(vkNgine_Config::getSystemConfig()->language->locale != 'en') {
	    		$singular = str_replace('"s', '', $singular);
				$singular = str_replace('"', '', $singular);
	    		return Zend_Registry::get('t')->_('One') . ' ' . $singular;
    		}
    		else {
    			return Zend_Registry::get('t')->_('One') . ' 2' . $singular;
    		}
    	}
    	else
    	{
    		if(vkNgine_Config::getSystemConfig()->language->locale != 'en') {
    			$plural = str_replace('"s', '', $plural);
    			$plural = str_replace('"', '', $plural);
    			return $number . ' ' . $plural;
    		}
    		else {
    			return $number . ' ' . $plural;
    		}
    	}
    }
}
?>