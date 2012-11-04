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
class Admin_Model_Form_SystemSettings_Cache extends vkNgine_Form_SubForm_Design
{
	public function init()
	{
		parent::init('adminFormSystemSettingsCache');
		
		$this->addElements(array(
			new vkNgine_Form_Element_Button(
				'cache_clear',
				array('label' => Zend_Registry::get('t')->_('Clear Cache') 
					  )),
			new vkNgine_Form_Element_Checkbox(
					'cache_enabled',
					array('label' => Zend_Registry::get('t')->_('Enabled:'),
						  'value' => false,
						  'class' => 'field checkbox',
						  'desc'  => null,
						  'checkedValue' => '1',
						  'uncheckedValue' => '0',
						  'placement' => 'PREPEND'),
			   		false),	
		   	new vkNgine_Form_Element_Select(
				'cache_type',
				array('label' => Zend_Registry::get('t')->_('Cache Type'),
					  'class' => 'field select small',
					  'desc' => Zend_Registry::get('t')->_('Make sure Memcached is installed on the server before selecting it')),
				array('file' => $this->convertText2Turkish(Zend_Registry::get('t')->_('File System')),
					  'memcached' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Memcached'))),
		   		false),	
		   	new vkNgine_Form_Element_Text(
				'cache_dir',
				array('label' => Zend_Registry::get('t')->_('Cache Directory'),
					  'class' => 'field text medium'),
		   		false),	
			new vkNgine_Form_Element_Text(
				'cache_lifetime',
				array('label' => Zend_Registry::get('t')->_('Cache Lifetime'),
					  'class' => 'field text medium'),
				false),
		));	
	}
}