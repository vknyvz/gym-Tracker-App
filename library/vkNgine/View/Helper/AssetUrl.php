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
class vkNgine_View_Helper_AssetUrl extends Zend_View_Helper_Url
{
    /**
     * construct the asset url
     * 
     * @param array $args
     * @param string $action
     * @param string $controller
     * @return string
     */
    public function assetUrl($args = array(), $action = 'view', $controller = 'assets')
    {
    	$_args = array_merge($args, array(
    		'action' => $action,
    		'controller' => $controller
    	));
    	
    	return $this->url(
    		$_args,
    		null,
    		true
    	);
    }
}
