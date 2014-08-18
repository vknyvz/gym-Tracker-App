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
 * @copyright   Copyright (c) 2011-2014 Volkan Yavuz (http://www.vknyvz.com)
 */

class vkNgine_SEO
{
	public static function createURLs($text, $limit=75)
	{
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
		$text = trim($text, '-');
		$text = strtolower($text);	
		$text = preg_replace('~[^-\w]+~', '', $text);
	
		if(strlen($text) > 70) {
			$text = substr($text, 0, 70);
		}
	
		if (empty($text)) {
			return time();
		}
	
		return $text;
	}
}