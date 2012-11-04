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
class Admin_Model_Form_Reset_Password extends vkNgine_Form_Design
{
    public function init()
    {
    	parent::init('adminFormResetPassword');
    	
		$this->addElements(array(	
			new vkNgine_Form_Element_Hidden('token'),
			new vkNgine_Form_Element_Email(
				'email', 
				array('label' 	 => Zend_Registry::get('t')->_('Username/Email'),
					  'class' 	 => 'field text medium',
					  'validate' => 'user'), 	
		   		true),
		   	new vkNgine_Form_Element_Password(
				'password', 
				array('label' 	 => Zend_Registry::get('t')->_('Password'),
					  'class' 	 => 'field text medium'
				), 	
		   		true),
			new vkNgine_Form_Element_Submit(
				'submit', 
				array('value' => Zend_Registry::get('t')->_('Send New Password'),
					  'class' => 'ui-corner-all float-right ui-button')),
		));	 
    }
    
	public function setTokenValue($value)
	{
		$this->getElement('token')->setValue($value);
		return $this;
	}
}