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
class vkNgine_Acl extends Zend_Acl
{
	public $role;
	
	/**
	 * load the acl resources and set up permissions
	 *
	 */
    public function __construct()
    {
        
        // add the modules
        $this->add(new Zend_Acl_Resource('pt'));        
        
    	$user = Zend_Registry::get('user');
    	$this->role = $user->level;    
    }
}

