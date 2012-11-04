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
class vkNgine_Array extends Zend_Controller_Plugin_Abstract
{	
	/**
	 * prints out an array nicely
	 * 
	 * @param array $arr
	 */
	public static function x($arr, $die = false)
	{
		echo '===============';
			echo '<pre>';
				print_r($arr);
			echo '</pre>';
		echo '===============';
		
		if($die) {
			exit;   
		}   
	}
}
?>