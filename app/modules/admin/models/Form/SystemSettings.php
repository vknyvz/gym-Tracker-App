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
class Admin_Model_Form_SystemSettings extends vkNgine_Form_SubForm_Abstract
{
    public function init()
    {
    	$this->addSubForm(
    			new Admin_Model_Form_SystemSettings_General(), 'General_Settings')
    		 ->addSubForm(
			 	new Admin_Model_Form_SystemSettings_Language(), 'Language_Settings')	
    		 ->addSubForm(
    			new Admin_Model_Form_SystemSettings_Cache(), 'Cache_Settings')
			 ->addSubForm(
    			new Admin_Model_Form_SystemSettings_Email(), 'Email_Settings')
    		->addSubForm(
    			new Admin_Model_Form_SystemSettings_DateTime(), 'Date_and_Time_Settings')
			 ->addSubForm(
			 	new Admin_Model_Form_SystemSettings_GoogleAnalytics(), 'Google_Analytics_Settings')	
			 ->addSubForm(
			 	new Admin_Model_Form_SystemSettings_EnvProduction(), 'Application_Environment_Settings_for_Production')
			 ->addSubForm(
			 	new Admin_Model_Form_SystemSettings_EnvDev(), 'Application_Environment_Settings_for_Development'
		);	 
		
	}
}