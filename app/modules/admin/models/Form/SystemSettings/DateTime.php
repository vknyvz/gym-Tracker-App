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
class Admin_Model_Form_SystemSettings_DateTime extends vkNgine_Form_SubForm_Design
{
	public function init()
	{
		parent::init('adminFormSystemSettingsDateTime');
		
		$this->addElements(array(
			new vkNgine_Form_Element_Select(
				'timezone',
				array('label' => Zend_Registry::get('t')->_('Timezone'),
					  'class' => 'field select small',
					  'desc'  => null),
				array('America/Denver' 		=> Zend_Registry::get('t')->_('America/Denver'),
					  'America/Los_Angeles' => Zend_Registry::get('t')->_('America/Los_Angeles'),
					  'America/New_York' 	=> Zend_Registry::get('t')->_('America/New_York'),
					  'America/Vancouver'   => Zend_Registry::get('t')->_('America/Vancouver'),
					  'Europe/Amsterdam'    => Zend_Registry::get('t')->_('Europe/Amsterdam'),
					  'Europe/Berlin' 	    => Zend_Registry::get('t')->_('Europe/Berlin'),
					  'Europe/Istanbul' 	=> Zend_Registry::get('t')->_('Europe/Istanbul'), 
					  'Europe/Madrid'		=> Zend_Registry::get('t')->_('Europe/Madrid'),
					  'Europe/Paris'		=> Zend_Registry::get('t')->_('Europe/Paris'),
					  'Europe/Rome'			=> Zend_Registry::get('t')->_('Europe/Rome'),
				),
		   		false),	
		));	
	}
}