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
class vkNgine_View_Helper_Seo extends Zend_View_Helper_HtmlElement
{
	public static function seo($value)
	{
		if(strstr($value, '/') !== true){
			$value = str_replace('/', '_', $value);
		}
		$value = strtolower($value);
	
		return str_replace(' ', '-', $value);
	}
}