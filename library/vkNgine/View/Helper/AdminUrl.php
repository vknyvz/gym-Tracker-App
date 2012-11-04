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
class vkNgine_View_Helper_AdminUrl extends Zend_View_Helper_Url
{
    /**
     * construct the admin url
     * 
     * @param string $action
     * @param string $controller
     * @param array $args
     * @return string
     */
    public function adminUrl($action = 'index', $controller = 'index', $args = array())
    {
    	$_args = array_merge($args, array(
    		'action' => $action,
    		'controller' => $controller,
    		'module' => 'admin'
    	));
    	
    	return $this->url(
    		$_args,
    		null,
    		true
    	);
    }
}
