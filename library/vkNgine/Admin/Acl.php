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
class vkNgine_Admin_Acl extends Zend_Acl
{	
	private $role;

    public function __construct()
    {
    	// add the roles
        $this->addRole(new Zend_Acl_Role('ADMIN'));
        $this->addRole(new Zend_Acl_Role('STANDARD'));
        $this->addRole(new Zend_Acl_Role('LIMITED'));
        
        // add the modules
        
         // admin can do everything for now
        $this->allow('ADMIN');       

        // deny standard users 
    	$this->deny('STANDARD');
    	$this->deny('LIMITED');
    	    	
    	$user = Zend_Registry::get('user');
    	$this->role = $user->level;
    }    

    /**
     * checks if a user is allowed a privilege
     * 
     * @param string $resource
     * @param string $privilege
     */
    public function isAllowed($resource = null, $privilege = null)
    {
    	return parent::isAllowed($this->role, $resource, $privilege);
    }
}