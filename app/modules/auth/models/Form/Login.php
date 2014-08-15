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
class Auth_Model_Form_Login extends vkNgine_Form_Design
{
    public function init()
    {
    	parent::init('publicFormLogin');
    	
		$this->addElements(array(	
			new vkNgine_Form_Element_Text(
				'username', 
				array('label' => null,
					  'placeholder' => Zend_Registry::get('t')->_('Username'),
					  'id' => null,
					  'class' => 'm-wrap placeholder-no-fix',
					  'removeDecorators' => 1), 	
		   		true),
			new vkNgine_Form_Element_Password(
				'password', 
				array('label' => null,
					  'placeholder' => Zend_Registry::get('t')->_('Password'),
					  'id' => null,
					  'class' => 'm-wrap placeholder-no-fix',
					  'removeDecorators' => 1), 	
				true),
		));        			  
    }
}

