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
class Admin_Model_Form_SystemSettings_EnvProduction extends vkNgine_Form_SubForm_Design
{
	public function init()
	{
		parent::init('adminFormSystemSettingsEnvProduction');
		
		$this->addElements(array(
			new vkNgine_Form_Element_Text(
				'live_db_host',
				array('label' => Zend_Registry::get('t')->_('Database Host'),
					  'class' => 'field text medium'),
		   		true),	
		   	new vkNgine_Form_Element_Text(
				'live_db_user',
				array('label' => Zend_Registry::get('t')->_('Database Username'),
					  'class' => 'field text medium'),
		   		true),	
		   	new vkNgine_Form_Element_Text(
				'live_db_pass',
				array('label' => Zend_Registry::get('t')->_('Database Password'),
					  'class' => 'field text medium'),
		   		true),
		   	new vkNgine_Form_Element_Text(
				'live_dbname',
				array('label' => Zend_Registry::get('t')->_('Database Name'),
					  'class' => 'field text medium'),
		   		true),							
		));
	}
}