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
class Admin_Model_Form_SystemSettings_General extends vkNgine_Form_SubForm_Design
{
	public function init()
	{
		parent::init('adminFormSystemSettingsGeneral');
		
		$this->addElements(array(	
			new vkNgine_Form_Element_Text(
				'app_description',
				array('label' => Zend_Registry::get('t')->_('Site Description'),
					  'class' => 'field text medium'),
		   		true),
		   	new vkNgine_Form_Element_Text(
				'app_keywords',
				array('label' => Zend_Registry::get('t')->_('Site Keywords'),
					  'class' => 'field text medium'),
		   		true),
			new vkNgine_Form_Element_Text(
				'login_remember',
				array('label' => Zend_Registry::get('t')->_('Login Remember'),
					  'class' => 'field text medium'),
		   		false),
		   	new vkNgine_Form_Element_Text(
				'form_expiration_time',
				array('label' => Zend_Registry::get('t')->_('Form Expiration Time'),
					  'class' => 'field text medium'),
		   		true),		
		   	new vkNgine_Form_Element_Text(
				'default_module',
				array('label' => Zend_Registry::get('t')->_('Default Module'),
					  'class' => 'field text medium'),
		   		false),
		   	new vkNgine_Form_Element_Text(
				'per_page',
				array('label' => Zend_Registry::get('t')->_('Pagination Per Page'),
					  'class' => 'field text medium'),
		   		true),	
		   	new vkNgine_Form_Element_Checkbox(
				'debug_enabled',
				array('label' => Zend_Registry::get('t')->_('Debug Enabled:'),
					  'class' => 'field checkbox',
					  'value' => false,
					  'desc' => Zend_Registry::get('t')->_('This will only enable ZFDebug on the development environment'),
					  'checkedValue' => '1',
					  'uncheckedValue' => '0',
					  'placement' => 'PREPEND'),
		   		false),				
		));
		
	}
}