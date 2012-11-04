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
class Admin_Model_Form_SystemSettings_Email extends vkNgine_Form_SubForm_Design
{
	public function init()
	{
		parent::init('adminFormSystemSettingsEmail');
		
		$this->addElements(array(
				new vkNgine_Form_Element_Select(
					'mail_type',
					array('label' => Zend_Registry::get('t')->_('Mail Server Type'),
						  'class' => 'field select small',
						  'desc' => null),
					array('smtp' => 'SMTP',
						  'pop3' => 'POP3'),
			   		false),	
			  	new vkNgine_Form_Element_Text(
					'mail_server',
					array('label' => Zend_Registry::get('t')->_('Mail Server'),
						  'class' => 'field text medium'),
			   		false),	
			   	new vkNgine_Form_Element_Text(
					'mail_port',
					array('label' => Zend_Registry::get('t')->_('Mail Server Port'),
						  'class' => 'field text medium'),
			   		false),	
			   	new vkNgine_Form_Element_Text(
					'mail_username',
					array('label' => Zend_Registry::get('t')->_('Mail Server Username'),
						  'class' => 'field text medium'),
			   		false),
			   	new vkNgine_Form_Element_Text(
					'mail_noreply',
					array('label' => Zend_Registry::get('t')->_('No-Reply Email Address'),
						  'class' => 'field text medium'),
			   		false),
			   	new vkNgine_Form_Element_Text(
					'mail_password',
					array('label' => Zend_Registry::get('t')->_('Mail Server Password'),
						  'class' => 'field text medium'),
			   		false),
		));	
	}
}