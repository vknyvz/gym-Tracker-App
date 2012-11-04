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
class Admin_Model_Form_Login extends vkNgine_Form_Design
{
    public function init()
    {
    	parent::init('adminFormLogin');
    	
		$this->addElements(array(	
			new vkNgine_Form_Element_Text(
				'email', 
				array('label' => Zend_Registry::get('t')->_('Username/Email'),
				
					  'class' => 'field text medium'), 	
		   		true),
			new vkNgine_Form_Element_Password(
				'password', 
				array('label' => Zend_Registry::get('t')->_('Password'),
					  'class' => 'field text medium'), 
				true),
			new vkNgine_Form_Element_Checkbox(
				'remember', 
				array('label'     => Zend_Registry::get('t')->_('Remember Me?'),
					  'class'     => 'field checkbox',
					  'value' 	  => 0,
					  'desc'      => null,
					  'checkedValue' => '1',
					  'uncheckedValue' => '0',
					  'placement' => 'PREPEND'
				)),
			new vkNgine_Form_Element_Submit(
				'submit', 
				array('value' => Zend_Registry::get('t')->_('Login'), 
					  'ignore' => true,
					  'class' => 'ui-corner-all float-right ui-button')),
		));	        			  
    }
}

