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
class vkNgine_View_Helper_FileSizeFormat extends Zend_View_Helper_HtmlElement
{
    /**
     * returns a nice human readable file size info
     * 
     * @param int $bytes
     * @return string
     */
    public function fileSizeFormat($bytes)
    {
	   if ($bytes < 1024) 
	   	  return $bytes.' B';
	   elseif ($bytes < 1048576) 
	   	  return round($bytes / 1024, 2).' KB';
	   elseif ($bytes < 1073741824) 
	   	  return round($bytes / 1048576, 2).' MB';
	   elseif ($bytes < 1099511627776) 
	   	  return round($bytes / 1073741824, 2).' GB';
	   else 
	      return round($bytes / 1099511627776, 2).' TB';
    }
}