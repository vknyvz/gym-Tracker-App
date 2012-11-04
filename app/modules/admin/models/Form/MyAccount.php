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
class Admin_Model_Form_MyAccount extends vkNgine_Form_AjaxDesign
{
    public function init()
    {
    	parent::init('adminFormMyAccount');
    	
		$this->addElements(array(	
			new vkNgine_Form_Element_Text(
				'password', 
				array('label' => Zend_Registry::get('t')->_('Password'),
					  'class' => 'field text medium'), 	
		   		true),
		));	 
    }
}