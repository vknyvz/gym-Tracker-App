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
class vkNgine_CleanFileNames extends Zend_Controller_Plugin_Abstract
{
	/**
	 * cleans a file name
	 * 
	 * @param mixed $value
	 * @return mixed
	 */
	public function clean($value)
	{
		$patternCounter=0;
		$patterns[$patternCounter] = '/[\x21-\x2d]/u'; // remove range of shifted characters on keyboard - !"#$%&'()*+,-
		$patternCounter++;
		
		$patterns[$patternCounter] = '/[\x5b-\x60]/u'; // remove range including brackets - []\^_`
		$patternCounter++;
		
		$patterns[$patternCounter] = '/[\x7b-\xff]/u'; // remove all characters above the letter z.  This will eliminate some non-English language letters
		$patternCounter++;
		
		$patterns[$patternCounter] = '/\@/u'; // remove @
		$patternCounter++;
		
		$patterns[$patternCounter] = '/\ /u'; // replace spaces
		$patternCounter++;
		
		$replacement ="_";
		
		return preg_replace($patterns, $replacement, $value);
	}
	
	public static function cleanCacheNames($value)
	{
	    $patternCounter=0;
	    $patterns[$patternCounter] = '/\@/u'; // remove @
	    $patternCounter++;
	    
	    $patterns[$patternCounter] = '/\./u'; // remove .
	    $patternCounter++;
	    
	    $patterns[$patternCounter] = '/\ /u'; // replace spaces
	    $patternCounter++;
	    
	    $replacement = "_";
	    
	    return preg_replace($patterns, $replacement, $value); 
	}
}	