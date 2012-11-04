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
class Admin_Model_Form_SystemSettings_GoogleAnalytics extends vkNgine_Form_SubForm_Design
{
	public function init()
	{
		parent::init('adminFormSystemSettingsGoogleAnalytics');
		
		$this->addElements(array(
			new vkNgine_Form_Element_Checkbox(
				'ga_enabled',
				array('label' => Zend_Registry::get('t')->_('Enabled:'),
					  'class' => 'field checkbox',
					  'desc' => Zend_Registry::get('t')->_('Google Analytics will be turned on only for Production Server'),
					  'value' => '0',
					  'checkedValue' => '1',
					  'uncheckedValue' => '0',
					  'placement' => 'PREPEND'),
		   		false),	
		   	new vkNgine_Form_Element_Text(
				'ga_code',
				array('label' => Zend_Registry::get('t')->_('Code'),
					  'class' => 'field text medium'),
		   		false),		
		));
	}
}