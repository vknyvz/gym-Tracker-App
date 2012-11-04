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
class vkNgine_View_Helper_Phoneformat extends Zend_View_Helper_HtmlElement
{
    public function phoneFormat($phone = 0)
    {	
		if (!empty($phone) && strlen($phone) == 10) {
	    	if (is_numeric($phone)) { 
	    	
	    		$area = substr($phone, 0, 3); 
				$prefix = substr($phone, 3, 3); 
				$number = substr($phone, 6, 4); 
				 
				return '('.$area.')'.'-'.$prefix.'-'.$number;
	    	}
    	}
    	return '';
    }
    

}