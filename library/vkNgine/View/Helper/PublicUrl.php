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
class vkNgine_View_Helper_PublicUrl extends Zend_View_Helper_Url
{
	/**
     * construct the public site url
     * 
     * @param string $action
     * @param string $controller
     * @param array $args
     * @return string
     */
    public function publicUrl($action = 'index', $controller = 'index', $args = null)
    {
		if($args)
		{
			$_args = array_merge($args, array(
				'action' 	 => $action,
				'controller' => $controller,
			));
			
			return $this->url(
				$_args,
				null,
				true
			);
		}
		else
		{
			$_args = array(
				'action' 	 => $action,
				'controller' => $controller,
			);
			
			return $this->url(
				$_args,
				null,
				true
			);
		}
    }
}
    