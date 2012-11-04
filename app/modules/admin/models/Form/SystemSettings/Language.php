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
class Admin_Model_Form_SystemSettings_Language extends vkNgine_Form_SubForm_Design
{
	public function init()
	{
		parent::init('adminFormSystemSettingsLanguage');
		
		$this->addElements(array(	
			new vkNgine_Form_Element_Select(
				'language',
				array('label' => Zend_Registry::get('t')->_('Language'),
					  'class' => 'field select small',
					  'escape' => false,
					  'desc' => null),
				array('en' => $this->convertText2Turkish(Zend_Registry::get('t')->_('English')),
					  'tr' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Turkish'))),
		   		true),
		));
	}
}